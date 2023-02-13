# Use an official PHP image as the base image
FROM php:8.1-fpm-alpine
# Install the required system packages and PHP extensions
RUN apk add --no-cache \
    libzip-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    gd \
    zip \
    mysqli \
    && pecl install -o -f redis \
    && docker-php-ext-enable redis