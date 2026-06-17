FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html/

# تصحیح فایل config/app.php قبل از نصب
RUN sed -i "s/MCRYPT_RIJNDAEL_128/'AES-256-CBC'/" /var/www/html/config/app.php

# حذف vendor و composer.lock برای نصب دوباره
RUN rm -rf vendor composer.lock

RUN composer install --no-dev --ignore-platform-reqs

RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

EXPOSE 80
