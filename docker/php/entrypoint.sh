#!/bin/bash

chmod 777 -R /var/www

if [ "$RUN_MIGRATIONS" = true ] ; then

    php /var/www/artisan key:generate --force
    php /var/www/artisan migrate --force
    php /var/www/artisan tenants:migrate --force

    if [ "$APP_ENV" != 'production' ] ; then
        php /var/www/artisan optimize:clear
    else
        php /var/www/artisan optimize
    fi

    php-fpm

else
    /usr/bin/supervisord -n -c /etc/supervisord.conf
fi
