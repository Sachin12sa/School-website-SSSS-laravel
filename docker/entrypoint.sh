#!/bin/sh
set -e

: "${PORT:=10000}"

sed -i "s/listen 80;/listen ${PORT};/g" /etc/nginx/http.d/default.conf
sed -i "s/listen \[::\]:80;/listen \[::\]:${PORT};/g" /etc/nginx/http.d/default.conf

mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R 775 storage bootstrap/cache

if echo "${APP_KEY:-}" | grep -Eq '^[A-Za-z0-9+/]{43}=$'; then
    export APP_KEY="base64:${APP_KEY}"
fi

php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

php-fpm -D
exec nginx -g "daemon off;"
