#!/bin/bash

while ! mysqladmin ping -h"${MYSQL_HOST}" --silent; do
    sleep 1
done

joomla site:install testsite --options=configuration.yaml -vvv \
    --mysql-login=${MYSQL_USER}:${MYSQL_PASSWORD} \
    --mysql-host=${MYSQL_HOST} \
    --mysql-database=${MYSQL_DATABASE}
joomla vhost:create testsite --disable-ssl --http-port=81

joomla extension:installfile testsite /root/library
rm -r /var/www/testsite/libraries/scoutorg
joomla extension:symlink testsite lib_scoutorg --projects-dir /var/www/projects

joomla extension:installfile testsite /root/component
rm -r /var/www/testsite/components/com_scoutorg
rm -r /var/www/testsite/administrator/components/com_scoutorg
rm /var/www/testsite/language/{sv-SE,en-GB}/{sv-SE,en-GB}.com_scoutorg.{sys.ini,ini} 2> /dev/null
rm /var/www/testsite/administrator/language/{sv-SE,en-GB}/{sv-SE,en-GB}.com_scoutorg.{sys.ini,ini} 2> /dev/null
rm -r /var/www/testsite/media/com_scoutorg
joomla extension:symlink testsite com_scoutorg --projects-dir /var/www/projects

cat /config/params.sql | mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" -h"$MYSQL_HOST" $MYSQL_DATABASE

chown -R www-data:www-data /var/www/testsite

/usr/sbin/apache2ctl -D FOREGROUND