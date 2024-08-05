FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
  libxml2-dev \
  unzip \
  git \
  libzip-dev\
  nginx \
  && docker-php-ext-install dom mysqli simplexml zip \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY composer.json ./

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_ROOT_VERSION=1.0.0

RUN composer install --no-interaction --no-plugins --no-scripts

RUN composer

COPY . .

EXPOSE 80

CMD ["apache2-foreground"]