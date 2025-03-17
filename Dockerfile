FROM php:8.2-fpm-alpine

WORKDIR /var/www/app

# Zaktualizowanie repozytoriów i instalacja niezbędnych zależności
RUN apk update && apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    autoconf \
    g++ \
    make \
    libtool \
    gcc \
    libc-dev \
    bash \
    libmemcached-dev \
    redis \
    mysql-client

# Instalacja rozszerzeń PHP
RUN pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo pdo_mysql

# Instalacja Node.js i npm
RUN apk --no-cache add nodejs npm

# Pobranie i instalacja Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

# Ustawienie uprawnień do katalogu
RUN chmod 777 -R /var/www/app
