# Multi-stage build for Public + Student Portal frontend
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install --production
COPY . .
RUN npm run build || echo "No build script found"

FROM php:8.2-fpm-alpine AS php-builder

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    unzip \
    git \
    curl

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        gd \
        bcmath \
        pcntl \
        opcache

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy built assets from node builder
COPY --from=node-builder /app/public/build /var/www/html/public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php.ini /usr/local/etc/php/php.ini

# Create nginx directories
RUN mkdir -p /var/log/nginx /var/lib/nginx/tmp/client_body

# Optimize Laravel for production
RUN php artisan config:cache || echo "No config to cache" \
    && php artisan route:cache || echo "No routes to cache" \
    && php artisan view:cache || echo "No views to cache"

# Expose port
EXPOSE 8080

# Start supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]