How can I add php/sql to my Mint server?

1. Type: sudo apt-get install apache2
2. Test if it is working: http://localhost/
3. Type: sudo apt-get install libapache2-mod-php
4. Restart apache: sudo systemctl restart apache2
5. WWW root: /var/www/html/
6. Create <?php phpinfo() ?> and run to check if working.
