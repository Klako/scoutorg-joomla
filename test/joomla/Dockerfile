FROM ubuntu:18.04

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update
RUN apt-get install -y apache2
COPY ports.conf /etc/apache2/
RUN a2enmod rewrite

RUN DEBIAN_FRONTEND="noninteractive" apt-get -y install tzdata
RUN apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update

RUN apt-get install -y php7.4 php7.4-zip php7.4-xml php7.4-mysql php7.4-curl php7.4-xdebug

RUN apt-get install -y composer
RUN composer global require joomlatools/console
RUN ln -s ~/.composer/vendor/bin/joomla /usr/bin/joomla

RUN apt-get install -y sudo
RUN apt-get install -y mysql-client
RUN apt-get install -y zip

RUN joomla site:download testsite --release=3.9.19

COPY config /config
RUN cat /config/php.ini >> /etc/php/7.4/apache2/php.ini
COPY configuration.yaml /
COPY entrypoint.sh /

CMD [ "/entrypoint.sh" ]
