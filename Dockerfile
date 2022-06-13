FROM php:7.4-fpm as php
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install  gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip \