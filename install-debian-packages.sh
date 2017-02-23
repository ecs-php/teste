#!/usr/bin/env bash
sudo apt-get update
sudo apt-get install -y apache2
sudo apt-get install -y php5
sudo apt-get install -y git
sudo apt-get install -y php5-mysql
sudo apt-get install -y php5-sqlite
sudo apt-get install -y php5-curl
sudo apt-get install -y php5-gd
sudo apt-get install -y php5-xsl
sudo apt-get install -y php5-dev
sudo apt-get install -y php5-mcrypt
sudo apt-get install -y php-pear
sudo apt-get install -y graphviz
sudo apt-get install -y cups	
sudo apt-get install -y smbclient
sudo apt-get install -y cupsys cupsys-bsd cupsys-client cupsys-driver-gimpprint
sudo apt-get install -y foomatic-db-engine foomatic-db-hpijs
sudo apt-get install -y foomatic-filters-ppds foomatic-gui
sudo apt-get install -y nodejs
sudo apt-get install -y npm
sudo apt-get install libpcre3-dev
sudo pecl install SPL_Types
sudo echo extension=spl_types.so | sudo tee /etc/php5/mods-available/spl_types.ini
sudo php5enmod spl_types
sudo service apache2 reload

# setup hosts file
VHOST=$(cat <<EOF
<VirtualHost *:80>
    DocumentRoot "/vagrant/"
    <Directory "/vagrant/">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
<VirtualHost *:8080>
    DocumentRoot "/var/www/phpci/public"
    <Directory "/var/www/phpci/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-available/000-default.conf

sudo a2enmod rewrite
service apache2 restart

curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

wget http://deployer.org/deployer.phar
mv deployer.phar /usr/local/bin/dep
chmod +x /usr/local/bin/dep

sudo apt-get -y upgrade


