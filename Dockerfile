FROM php:8.4-apache

RUN apt-get update \
    && apt-get install -y libicu-dev \
    && docker-php-ext-install mysqli pdo_mysql intl \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

EXPOSE 80