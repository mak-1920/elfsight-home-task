FROM composer:latest AS composer
FROM php:8.3-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN \
    apt update \
	&& apt install -y apt-utils icu-devtools libicu-dev libpq-dev procps \
    && pecl install xdebug \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-install pdo_pgsql intl \
    && docker-php-ext-enable xdebug \
    && usermod -u 1000 www-data

WORKDIR /var/www/html
