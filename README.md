How can I add php/sql to my Mint server?

1. Type: <i>sudo apt install apache2</i>
2. Test if it is working: http://localhost/

3. Type: <i>sudo apt install libapache2-mod-php</i>
4. Restart apache: <i>sudo systemctl restart apache2</i> (-or-) <i> sudo service apache2 restart</i>
5. WWW root: /var/www/html/
6. Create <?php phpinfo() ?> and run to check if working.

7. Type: <i>sudo apt install mysql-server</i>
8. Type: <i>sudo apt install mysql-client</i> (can be added later)
9. Test if it is working: <i>sudo systemctl status mysql</i>  (-or-) <i> sudo service mysql status</i>

10. Type: <i>sudo apt install phpmyadmin</i>
11. Restart apache: <i>sudo systemctl restart apache2</i> (-or-) <i> sudo service apache2 restart</i>
12. Open in browser (default username: phpmyadmin): http://localhost/phpmyadmin/
13. IF NO PHPMYADMIN STARTS - go to:/etc/apache2/apache2.conf
<br />13a. Add at the very back of apache2.conf: Include /etc/phpmyadmin/apache.conf
<br />13b. Restart apache: <i>sudo systemctl restart apache2</i> (-or-) <i> sudo service apache2 restart</i>

14. Open in browser (default username: phpmyadmin): http://localhost/phpmyadmin/

link: https://connectwww.com/how-to-install-and-configure-apachephpmysql-and-phpmyadmin-on-ubuntu/727/

If there is no prvelage to create new database use the system maintenance user and password created when you installed phpMyAdmin.
It can be found in the debian.cnf file at /ect/mysql then you will have total access:

    cd /etc/mysql
    sudo nano debian.cnf
    Just look - don't change anything!
    [mysql_upgrade]
    host     = localhost
    user     = debian-sys-maint       <----use this user
    password = s0meRaND0mChar$s       <----use this password !!NEVER CHANGE IT!! 
    socket   = /var/run/mysqld/mysqld.sock
-------------------------------------------------------------
<br />14a. If root password is not set go and set it with [Password Hashing] = "Native MySQL"

15. To access webserver on network check firewall status:

    sudo ufw app list
    sudo ufw status
    
16. If there is no connection (no external access) 

    sudo ufw allow 80/tcp
    
    sudo ufw allow 443/tcp
    
    sudo ufw reload
    
17. If there is error on database acces in phpMyAdmin - check version - phpMyAdmin v.4.6 not-compatyble with PHP 7. Download and manually install phpMyAdmin 4.9 (https://devanswers.co/manually-upgrade-phpmyadmin/)
<br />17a. Rename <i>/usr/share/phpmyadmin</i> into <i>/usr/share/phpmyadmin_OLD</i>
<br />17b. Download phpMyAdmin-4.9.5-english.tar.gz from https://www.phpmyadmin.net/downloads/
<br />17c. Create new <i>/usr/share/phpmyadmin</i> and unpack downloaded conthent there
<br />BEWARE!! Latest phpMyAdmin v.5 isnot compatybile with old PHP 5!!
    
