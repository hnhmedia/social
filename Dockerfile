FROM php:8.2-apache

RUN apt-get update \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Expose default Apache port
EXPOSE 80

# Simple healthcheck: ensure Apache is up
HEALTHCHECK --interval=30s --timeout=5s --retries=3 CMD curl -f http://localhost/ || exit 1
