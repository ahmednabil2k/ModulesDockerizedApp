FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www

# Copy composer.lock and composer.json
COPY composer.json /var/www/

RUN if [ -f $composer.lock ]; then \
        cp composer.lock /var/www/; \
    fi

# Remove cache
RUN rm -rf /var/cache/apk/*
RUN rm -rf /tmp/*

RUN apk update && apk add \
    git \
    curl \
    zip \
    unzip \
    build-base \
    libzip-dev \
    zlib-dev \
    icu-dev \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    openssl-dev \
    supervisor \
    && rm -rf /var/cache/apk/*

# Instal and configure php extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli zip exif pcntl intl \
    && docker-php-ext-install -j$(nproc) mbstring

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

RUN docker-php-ext-install opcache

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
        && pecl install redis \
        && docker-php-ext-enable redis

# Add bash scripts
RUN apk add bash

# Detect Application Env
ARG APP_ENV
ARG RUN_MIGRATIONS

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN if [ "$APP_ENV" = "production" ]; then \
        php -d memory_limit=-1 /usr/local/bin/composer install -vvv --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts --no-ansi --no-interaction --working-dir=/var/www; \
    else \
        php -d memory_limit=-1 /usr/local/bin/composer install -vvv --no-scripts --no-ansi --no-interaction --working-dir=/var/www; \
    fi

# Copy the root working dir to the /var/www/
COPY . .
RUN chown -R www-data:www-data /var/www

# Configure Opcache
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0"
COPY ./docker/php/opcache.ini "$PHP_INI_DIR/conf.d/opcache.ini"
COPY ./docker/php/php.ini "$PHP_INI_DIR/php.ini"

COPY ./docker/php/supervisord.conf /etc/supervisord.conf
COPY ./docker/php/entrypoint.sh /usr/bin/entrypoint.sh
RUN chmod +x /usr/bin/entrypoint.sh

ENV RUN_MIGRATIONS=$RUN_MIGRATIONS
ENV APP_ENV=$APP_ENV

CMD "/usr/bin/entrypoint.sh"
