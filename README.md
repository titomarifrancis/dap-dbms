# dap-dbms
Uses latest PHP7 and PostgreSQL on latest version of OpenBSD

Notes:
on OpenBSD 6.8 install include xbase68.tgz
don't run syspatch before installing packages

We install PHP7.3

edit /etc/rc.conf.local:</br>
  httpd_flags=</br>
  pkg_scripts=php73_fpm</br>

edit /etc/httpd.conf:</br>
ext_ip="192.168.253.138"</br>
server "default" {</br>
      listen on $ext_ip port 80</br>
      location "*.php" {</br>
            fastcgi socket "/run/php-fpm.sock"</br>
      }</br>
      directory index index.php</br>
      root "/htdocs"</br>
}</br>
types {<br/>
    include "/usr/share/misc/mime.types"</br>
}</br>
</br>
Ensure PECL SSH2 is enabled in /etc/php-7.3.ini</br>
extensions=ssh2</br>
Enable PHP POstgreSQL and PDO driver for PostgreSQL</br>
extensions=pgsql</br>
extensions=pdo_pgsql</br>
</br>
on /var/www/htdocs:</br>
git clone https://github.com/titomarifrancis/dap-dbms.git</br>
</br>
ln -s /var/www/htdocs/dap-dbms/scripts/update.sh /usr/local/bin/update-dap-dbms</br>
chmod +x /usr/local/bin/update-dap-dbms</br>
</br>
on Ubuntu 20.04</br>
sudo apt update</br>
sudo apt install apache2</br>
sudo ufw app list</br>
sudo ufw allow 'Apache'</br>
sudo systemctl status apache2</br>
</br>
If PHP exhibits weird or absence of functionality, edit /etc/php-7.2.ini (corresponding to the PHP7 version you have)</br>
</br>
On the Ubuntu server, install ViewerJS from https://viewerjs.org/
