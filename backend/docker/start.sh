#!/bin/sh
set -e

# Default port if not provided by Railway
export PORT="${PORT:-8080}"

echo "Starting PCA Student API Backend on port ${PORT}..."

# Substitute ${PORT} environment variable in nginx config template
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# Ensure storage and cache directories exist with correct permissions
mkdir -p \
    /var/www/html/storage/app/public \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache

chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

chmod -R 775 \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Generate APP_KEY if not set
if [ -z "${APP_KEY}" ]; then
    echo "APP_KEY not set — generating one now..."
    php /var/www/html/artisan key:generate --force || true
fi

# Run Laravel production optimizations
php /var/www/html/artisan config:cache 2>/dev/null || true
php /var/www/html/artisan route:cache 2>/dev/null || true
php /var/www/html/artisan view:cache 2>/dev/null || true

echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
