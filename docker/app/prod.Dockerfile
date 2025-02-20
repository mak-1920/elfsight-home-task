FROM composer:latest AS composer
FROM php:8.3-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN \
    apt update \
	&& apt install -y apt-utils icu-devtools libicu-dev libpq-dev procps \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-install pdo_pgsql intl \
    && usermod -u 1000 www-data

ADD docker/nginx/conf.d /etc/nginx/conf.d
ADD docker/fpm/conf.d/www.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

RUN composer install --no-dev
