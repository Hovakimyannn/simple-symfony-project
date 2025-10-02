FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
    git \
    curl \
    libzip-dev \
    icu-dev \
    libpq-dev \
    bash

RUN docker-php-ext-install pdo pdo_mysql intl opcache zip

RUN set -eux; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS autoconf; \
    pecl install apcu; \
    docker-php-ext-enable apcu; \
    apk del .build-deps

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

COPY ./php.ini /usr/local/etc/php/conf.d/custom.ini

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
