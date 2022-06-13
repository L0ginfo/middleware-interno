cd /var/www/html
git clone https://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@github.com/L0ginfo/pontaNegra.git
cd /var/www/html/pontaNegra
git checkout develop
git pull origin develop
unzip vendor.zip
service apache2 stop
service apache2 start
service apache2 start

curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
curl https://packages.microsoft.com/config/ubuntu/18.04/prod.list > /etc/apt/sources.list.d/mssql-release.list
apt-get update
ACCEPT_EULA=Y apt-get -y install msodbcsql17
apt-get -y install unixodbc-dev
apt-get -y install mssql-tools
apt-get -y install php-pear
apt-get -y install php7.3-dev
pecl install sqlsrv
pecl install pdo_sqlsrv
echo "extension=sqlsrv.so" > /etc/php/7.3/mods-available/sqlsrv.ini
echo "extension=pdo_sqlsrv.so" > /etc/php/7.3/mods-available/pdo_sqlsrv.ini
echo "extension=pdo_sqlsrv.so" >> /etc/php/7.3/apache2/conf.d/30-pdo_sqlsrv.ini
echo "extension=sqlsrv.so" >> /etc/php/7.3/apache2/conf.d/20-sqlsrv.ini
echo extension=pdo_sqlsrv.so >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/30-pdo_sqlsrv.ini
echo extension=sqlsrv.so >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/20-sqlsrv.ini

echo "Adjusting environment"
echo "<VirtualHost *:80>" >> /etc/apache2/sites-enabled/000-default.conf
echo "DocumentRoot /var/www/html/" >> /etc/apache2/sites-enabled/000-default.conf
echo "ServerName loginfo.test" >> /etc/apache2/sites-enabled/000-default.conf
echo "</VirtualHost>" >> /etc/apache2/sites-enabled/000-default.conf

echo "Adjusting apache"
sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
service apache2 start
service apache2 start
a2enmod rewrite
phpenmod mbstring
service apache2 stop
service apache2 start
service apache2 start