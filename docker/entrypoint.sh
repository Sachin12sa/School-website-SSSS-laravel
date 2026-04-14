#!/bin/sh

# Replace the port in Nginx config with the PORT environment variable provided by Render
if [ -n "$PORT" ]; then
  sed -i "s/listen 80;/listen ${PORT};/g" /etc/nginx/sites-available/default
  sed -i "s/listen \[::\]:80;/listen \[::\]:${PORT};/g" /etc/nginx/sites-available/default
fi

# Run migrations if DB_CONNECTION is set
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Clear and cache Laravel config/routes/views for performance
echo "Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
echo "Starting Nginx..."
nginx -g "daemon off;"
