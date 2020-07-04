#!/bin/bash

sleep 10

joomla site:install testsite --options=configuration.yaml -vvv \
    --mysql-login=${JOOMLA_MYSQL_LOGIN} \
    --mysql-host=${JOOMLA_MYSQL_HOST} \
    --mysql-database=${JOOMLA_MYSQL_DATABASE}
joomla vhost:create testsite --disable-ssl --http-port=81

joomla extension:installfile testsite /root/component
rm -r /var/www/testsite/components/com_scoutorg
rm -r /var/www/testsite/administrator/components/com_scoutorg
rm /var/www/testsite/language/{sv-SE,en-GB}/{sv-SE,en-GB}.com_scoutorg.{sys.ini,ini} 2> /dev/null
rm /var/www/testsite/administrator/language/{sv-SE,en-GB}/{sv-SE,en-GB}.com_scoutorg.{sys.ini,ini} 2> /dev/null
joomla extension:symlink testsite com_scoutorg --projects-dir /var/www/projects

chown -R www-data:www-data /var/www/testsite

/usr/sbin/apache2ctl -D FOREGROUND