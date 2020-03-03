How can I add php/sql to my Mint server?

1. Type: sudo apt-get install apache2
2. Test if it is working: http://localhost/

3. Type: sudo apt-get install libapache2-mod-php
4. Restart apache: sudo systemctl restart apache2
5. WWW root: /var/www/html/
6. Create <?php phpinfo() ?> and run to check if working.

7. Type: sudo apt-get install mysql-server
8. Type: sudo apt-get install mysql-client
9. Test if it is working: sudo systemctl status mysql

10. Type: sudo apt-get install phpmyadmin
11. Restart apache: sudo systemctl restart apache2
12. Open in browser (default username: phpmyadmin): http://localhost/phpmyadmin/
13. IF NO PHPMYADMIN STARTS - go to:/etc/apache2/apache2.conf
13a. Add at the very back of apache2.conf: Include /etc/phpmyadmin/apache.conf
13b. Restart apache: sudo systemctl restart apache2

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
    password = s0meRaND0mChar$s       <----use this password
    socket   = /var/run/mysqld/mysqld.sock
-------------------------------------------------------------
15. To access webserver on network check firewall status:

    sudo ufw app list
    sudo ufw status
    
16. If there is no connection (no external access) 

    sudo ufw allow 80/tcp
    sudo ufw allow 443/tcp
    sudo ufw reload
