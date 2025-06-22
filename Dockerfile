# Use official PHP image with extensions
FROM php:8.0-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    sqlite3 \
    libsqlite3-dev \
    git \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install
# RUN composer install --no-dev --optimize-autoloader


# Set permissions (only for local dev)
# RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www
RUN chown -R www-data:www-data storage bootstrap/cache database && \
    chmod -R 775 storage bootstrap/cache && \
    chmod 664 database/charity.db

# Generate application key
# COPY .env.example .env
# Ensure the .env file is writable
# RUN chmod 664 .env
# RUN php artisan key:generate
# RUN php artisan config:cache

# Set environment variables
ENV APP_ENV=local \
    APP_DEBUG=true \
    APP_URL=http://localhost:8080 \
    DB_CONNECTION=sqlite \
    DB_DATABASE=charity.db



# Expose HTTP port for Render
EXPOSE 8080

# Run Laravel's built-in dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
