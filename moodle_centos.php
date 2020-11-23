#!/bin/bash
# https://blog.mrverrall.co.uk/2015/10/moodle-on-centos-and-red-hat-7.html
#######################################################################
##  READ THIS FIRST !!! - TWO LINES BELOW MADE A TRICK (SELINUX ISSUE)
#######################################################################
## semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/moodledata(/.*)?"
## restorecon -R /var/www/moodledata
#######################################################################
#
# This Bash script installs Moodle (http://moodle.org) and all it's
# requirements into a freshly installed Centos or RHEL 7 operating system.
# It assumes an 'Enforced' SELinux environment and configures the system
# accordingly.
#
# It is designed to be instructional and clear to read to persons unfamiliar
# with Bash and as such does *no* sanity checking before taking actions.
# Becasue of this *great* care should be taken if you feel the urge to run 
# this twice on a single system.
#
# What this script does
# =====================
# - Installs and configures a 'LAMP' stack
# - Installs and configures ClamAV
# - Installs Memcached and configures two instances
# - Creates the Moodle database
# - Installs Moodle with good defaults
# - Configures SELinux paramaters so that it may remain enforced
#
# What this script does NOT do
# ============================
# This script does not generate a production ready environment. 
# e.g. root access to the database is not secured and the clamav virus 
# definitions are not updated or scheduled to be updated (freshclam).
# These are just two examples.
#
# The MIT License (MIT)
# =====================
# 
# Copyright (c) 2015 Paul Verrall
# 
# Permission is hereby granted, free of charge, to any person obtaining a copy
# of this software and associated documentation files (the "Software"), to deal
# in the Software without restriction, including without limitation the rights
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
# copies of the Software, and to permit persons to whom the Software is
# furnished to do so, subject to the following conditions:
# 
# The above copyright notice and this permission notice shall be included in all
# copies or substantial portions of the Software.
# 
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
# SOFTWARE.

##################################################
# This script is intended to be run as root user.
# Lets just check that before we begin.
##################################################
if [ "$(id -u)" != "0" ]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi

# First Install some core utilities we will need.
# git - for fetching and managing the Moodle source
# policycoreutils-python - for managing SELiinux
# epel-release - for Clamav and Zend Opcache

yum install -y git policycoreutils-python epel-release

##################################################
# httpd (apache)
##################################################

# Install the httpd and the core php mdules we'll need
yum install -y httpd php php-gd php-fpm php-cli php-xmlrpc php-soap \
   php-intl php-mbstring php-xml php-pecl-zendopcache

# Add persistent rule to the firewall for http
firewall-cmd --permanent --add-service=http
firewall-cmd --reload

# SELinux - Allow httpd to send emails
setsebool -P httpd_can_sendmail 1
# SELinux - Allow httpd to use network daemons, e.g. memcached
setsebool -P httpd_can_network_relay 1
# SELinux - Allow httpd to make network connections, e.g. LDAP, external rss, etc.
setsebool -P httpd_can_network_connect 1

# We need to forbid access to the .git folder in our web root 
# To do this we add the file '/etc/httpd/conf.d/no-git.conf'
# in which we match the locations begining with .git and forbid them
cat << EOF > /etc/httpd/conf.d/no-git.conf
<LocationMatch "/.git">
    Require all denied
</LocationMatch>
EOF

##################################################
# Database (mariadb)
##################################################
yum install -y mariadb-server php-mysqlnd
systemctl enable mariadb
systemctl start mariadb

# Choose a Moodle database name, default moodle
echo -n "Enter a database name and press [ENTER]: "
read -e -i moodle YOUR_DB
# Choose a Moodle database user, default moodleuser
echo -n "Enter a database username and press [ENTER]: "
read -e -i moodleuser YOUR_USER
# Choose a moodle databse password, default yourpassword
echo -n "Enter a database password and press [ENTER]: "
read -e -i yourpassword YOUR_PASSWORD

# Create a moodle database as per https://docs.moodle.org/29/en/MySQL#Creating_Moodle_database
echo "Log into mariadb (mysql) with the ROOT password you set, NOT the moodle database password."
mysql -uroot << EOF
    SET GLOBAL innodb_file_per_table=1;
    SET GLOBAL innodb_file_format=Barracuda;
    CREATE DATABASE $YOUR_DB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
    GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,CREATE TEMPORARY TABLES,DROP,INDEX,ALTER 
    ON $YOUR_DB.* TO moodleuser@localhost IDENTIFIED BY '$YOUR_PASSWORD';
EOF

##################################################
### AV (clamav)
##################################################

# Install the clam daemon and tools
yum install -y clamav-scanner-systemd clamav clamav-update

# Edit the /etc/clam.d/scan.conf and delete 'Example' near the top
sed -i '/^Example/d' /etc/clamd.d/scan.conf

# Uncomment the following line from /etc/clamd.d/scan.conf
# 'LocalSocket /var/run/clamd.scan/clamd.sock'
sed -i 's#^\(.*\)\(LocalSocket /var/run/clamd\.scan/clamd\.sock\)#\2#' \
   /etc/clamd.d/scan.conf

# Allow httpd to access the clamav socket by changing the group on /var/run/clamd.scan
# as per instruction at /usr/share/doc/clamav-server-0.98.7/README
chgrp apache /var/run/clamd.scan

# link the to /etc/cland.conf so command line tools 'just work'
ln -s /etc/clamd.d/scan.conf /etc/clamd.conf

# SELinux - Allow Clamd to work
setsebool -P antivirus_can_scan_system 1

# Start our Clamav service
systemctl enable clamd@scan.service
systemctl start clamd@scan.service

##################################################
# Memcached
##################################################

# Install memcached and it's php module
yum install -y memcached php-pecl-memcached

# Disable the default memcached service
systemctl mask memcached

# We are going to be running two memcached services
# One for sessions and one for the MUC

# Create their environment configuration
cp /etc/sysconfig/memcached /etc/sysconfig/memcached_muc
cp /etc/sysconfig/memcached /etc/sysconfig/memcached_sessions

# Edit only the sessions file and increase the port number to 11212
sed -i 's/11211/11212/' /etc/sysconfig/memcached_sessions

# Create the Systemd service (unit) definitiond for our two memcached services
cp /lib/systemd/system/memcached.service /lib/systemd/system/memcached_muc.service
cp /lib/systemd/system/memcached.service /lib/systemd/system/memcached_sessions.service

# edit the coressponding EnvironmentFile path by appending _(sessions|muc)
sed -i 's/^\(EnvironmentFile=-\/etc\/sysconfig\/memcached\)$/\1_muc/' \
   /lib/systemd/system/memcached_muc.service
sed -i 's/^\(EnvironmentFile=-\/etc\/sysconfig\/memcached\)$/\1_sessions/' \
   /lib/systemd/system/memcached_sessions.service

# SELinux - Allow memcached to use a non-default port
semanage port -a -t memcache_port_t -p tcp 11212
semanage port -a -t memcache_port_t -p udp 11212

# Enable and start memcached
systemctl enable memcached_sessions
systemctl enable memcached_muc
systemctl start memcached_sessions
systemctl start memcached_muc

##################################################
# Moodle
##################################################

# Get the Moodle source code using git and put it in our default webroot
git clone https://github.com/moodle/moodle.git /var/www/html

# Move to the webroot
cd /var/www/html

# Establish what the most recent current stable version of Moodle is
MOODLE_VERSION=$(git branch -r  | grep -o MOODLE_.* | sort -nr | head -n1)

# Checkout a new git branch based on current stable
git checkout -b $MOODLE_VERSION origin/$MOODLE_VERSION

# Create a moodledata directory outside of the webroot
# and allow apache to write to it
mkdir -p     /var/www/moodledata
chgrp apache /var/www/moodledata
chmod 2770   /var/www/moodledata

# SELinux - Allow httpd to read/write to the moodledata directory
semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/moodledata(/.*)?"
restorecon -R /var/www/moodledata

# Allow apache to write to the webroot to create config.php
chmod 0770   /var/www/html
chgrp apache /var/www/html

# SELinux - Allow apache to write to the webroot to create config.php
chcon -t httpd_sys_rw_content_t /var/www/html

# Install moodle using the database paramaters set earlier
install_vars="--chmod=2770 \
              --wwwroot="http://localhost" \
              --dbuser=$YOUR_USER \
              --dbname=$YOUR_DB \
              --dbpass=$YOUR_PASSWORD \
              --dbtype=mariadb"

su apache -s /bin/bash -c \
    "/usr/bin/php /var/www/html/admin/cli/install.php $install_vars"

# Add directives for clam and memcached sessions to config.php
cat << EOF > config.ammedments
\$CFG->runclamonupload = 1;
\$CFG->pathtoclam = '/bin/clamdscan';
\$CFG->session_handler_class = '\core\session\memcached';
\$CFG->session_memcached_save_path = '127.0.0.1:11212';
\$CFG->session_memcached_prefix = 'memc.sess.key.';
\$CFG->session_memcached_acquire_lock_timeout = 120;
\$CFG->session_memcached_lock_expire = 7200;
EOF

sed -i '/directorypermissions/r config.ammedments' config.php && rm -f config.ammedments

# SELinux - restore contexts to the webtoot, removing write access for apache
restorecon -R /var/www/html

# Enable and start the httpd
systemctl enable httpd
systemctl start httpd

cat << EOF
You may now log in to Moodle at the address you specified during setup.
Once you have logged in you will want to configure the MUC to use the 
Memcached instace we configured for it. Instructions on how to do this 
are available at:
https://docs.moodle.org/29/en/MUC_FAQ#How_do_I_deploy_Memcached
EOF

exit
