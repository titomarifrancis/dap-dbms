# dap-dbms
Uses latest PHP7 and PostgreSQL on latest version of OpenBSD

Notes:
on OpenBSD 6.8 install include xbase68.tgz
don't run syspatch before installing packages

We install PHP7.2.33

edit /etc/rc.conf.local:
  httpd_flags=
  pkg_scripts=php72_fpm

edit /etc/httpd.conf:
ext_ip="192.168.253.138"
server "default" {
      listen on $ext_ip port 80
      location "*.php" {
            fastcgi socket "/run/php-fpm.sock"
      }
      directory index index.php
      root "/htdocs"
}

on /var/www/htdocs:
git clone https://github.com/titomarifrancis/dap-dbms.git
