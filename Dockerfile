# Stage 1: Build Assets (Node)
FROM node:20 AS node-builder
WORKDIR /app
COPY . .
RUN npm install && npm run build

# Stage 2: PHP/Apache
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev libicu-dev libpq-dev unzip zip git curl \
    && docker-php-ext-install zip intl pdo pdo_pgsql

RUN a2enmod rewrite
WORKDIR /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy code
COPY . .
# Copy compiled assets from Stage 1
COPY --from=node-builder /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Apache Config
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80