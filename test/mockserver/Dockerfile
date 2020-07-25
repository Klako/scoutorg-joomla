FROM ubuntu:18.04

RUN apt-get update
RUN apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update

RUN DEBIAN_FRONTEND="noninteractive" apt-get -y install tzdata
RUN apt-get install -y php7.4
RUN apt-get install -y php7.4-sqlite3 php7.4-xdebug
RUN apt-get install -y composer
RUN apt-get install -y zip

COPY config/php.ini /
RUN cat php.ini >> /etc/php/7.4/cli/php.ini

COPY src /root/server
WORKDIR /root/server
RUN composer install

COPY entrypoint.sh /

CMD ["/entrypoint.sh"]
