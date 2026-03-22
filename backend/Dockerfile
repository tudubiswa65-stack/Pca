# Multi-stage build for Student API backend
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
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
    curl \
    gettext

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
COPY docker/nginx.conf /etc/nginx/nginx.conf.template
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php.ini /usr/local/etc/php/php.ini
COPY docker/start.sh /start.sh

# Create nginx directories and make start script executable
RUN mkdir -p /var/log/nginx /var/lib/nginx/tmp/client_body \
    && chmod +x /start.sh

# Expose port (Railway will override with $PORT at runtime)
EXPOSE 8080

# Use start.sh to substitute $PORT and launch supervisord
CMD ["/start.sh"]