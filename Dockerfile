# Stage 1: Build Assets (Fixes the raw HTML / missing CSS issue)
FROM node:20 AS build
WORKDIR /app
COPY . .
RUN npm install && npm run build

# Stage 2: PHP Application
FROM php:8.2-apache

# 1. Install Linux Libraries
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    unzip \
    zip \
    git \
    curl \
    && docker-php-ext-install zip intl pdo pdo_pgsql \
    && a2enmod rewrite

# 2. Set working directory
WORKDIR /var/www/html

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copy project files
COPY . .

# 5. Copy compiled assets from Stage 1 (This makes the CSS work)
COPY --from=build /app/public/build ./public/build

# 6. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 7. Set permissions for Laravel storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Configure Apache to point to /public and handle Render's dynamic port
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# 9. Startup Command: This runs migrations automatically and then starts Apache
CMD sh -c "php artisan migrate --force && apache2-foreground"

EXPOSE 80