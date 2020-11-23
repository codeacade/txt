############  FROM: https://www.tecmint.com/install-ftp-server-in-centos-7/
#
# 1. Installing vsftpd server is straight forward, just run the following command in the terminal.

> yum install vsftpd

# 2. After the installation completes, the service will be disabled at first
# So we need to start it manually for the time being and enable it to start automatically from the next system boot as well:

> systemctl start vsftpd
> systemctl enable vsftpd

# 3. Next, in order to allow access to FTP services from external systems.
# We have to open port 21, where the FTP daemons are listening as follows:

> firewall-cmd --zone=public --permanent --add-port=21/tcp
> firewall-cmd --zone=public --permanent --add-service=ftp
> firewall-cmd --reload

# 4. Now we will move over to perform a few configurations to setup and secure our FTP server.
# Let us start by making a backup of the original config file /etc/vsftpd/vsftpd.conf:

> cp /etc/vsftpd/vsftpd.conf /etc/vsftpd/vsftpd.conf.orig

# Next, open the config file above and set the following options with these corresponding values:

anonymous_enable=NO             # disable  anonymous login
local_enable=YES		# permit local logins
write_enable=YES		# enable FTP commands which change the filesystem
local_umask=022		        # value of umask for file creation for local users
dirmessage_enable=YES	        # enable showing of messages when users first enter a new directory
xferlog_enable=YES		# a log file will be maintained detailing uploads and downloads
connect_from_port_20=YES        # use port 20 (ftp-data) on the server machine for PORT style connections
xferlog_std_format=YES          # keep standard log file format
listen=NO   			# prevent vsftpd from running in standalone mode
listen_ipv6=YES		        # vsftpd will listen on an IPv6 socket instead of an IPv4 one
pam_service_name=vsftpd         # name of the PAM service vsftpd will use
userlist_enable=YES  	        # enable vsftpd to load a list of usernames
tcp_wrappers=YES  		# turn on tcp wrappers

etc...

