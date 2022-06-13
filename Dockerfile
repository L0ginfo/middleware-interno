FROM ubuntu:18.04

LABEL name="WMS" \
    vendor="Equipe Loginfo" \
    maintainer="Equipe Loginfo"

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update
RUN apt-get install -y wget
RUN apt-get install -y unzip
RUN apt-get install -y nodejs
RUN apt-get install -y npm
RUN apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update
RUN apt install -y php7.3 
RUN apt install -y libapache2-mod-php7.3
RUN apt install -y php7.3-mysql
RUN apt install -y php7.3-common
RUN apt install -y php7.3-curl
RUN apt install -y php7.3-json
RUN apt install -y php7.3-xml
RUN apt install -y php7.3-soap
RUN apt install -y php7.3-bcmath
RUN apt install -y php7.3-intl
RUN apt install -y php7.3-mbstring php7.3-gettext php7.3-gd php7.3-zip
RUN add-apt-repository ppa:ondrej/apache2
RUN apt-get update
RUN apt-get install -y apache2
RUN apt-get install -y mysql-server
RUN apt-get install -y systemd
RUN sed -i '/; max_input_vars = 1000/c\; max_input_vars = 1000000' /etc/php/7.3/apache2/php.ini
RUN apt-get install -y curl
RUN apt-get install -y git-all
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --version=1.10.19
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN mkdir -p /scripts
COPY configure.sh /scripts
WORKDIR /scripts
RUN chmod +x configure.sh
RUN ./configure.sh
VOLUME [ "/var/www/html" ]
CMD [""./configure.sh"]