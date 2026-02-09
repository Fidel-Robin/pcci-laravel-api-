# Use PHP 8.2 FPM as base
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev git unzip zip curl \
    && docker-php-ext-install pdo_pgsql

# Set working directory
WORKDIR /var/www

# Copy composer files
COPY composer.json composer.lock ./

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies without running scripts
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copy full project
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Run post-install scripts manually
RUN php artisan package:discover

# Expose port
EXPOSE 8000

# Run Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
