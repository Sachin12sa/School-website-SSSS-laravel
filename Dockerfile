# -------------------------
# Stage 1: Frontend build
# -------------------------
FROM node:20 AS frontend-builder

WORKDIR /app
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# -------------------------
# Stage 2: PHP App
# -------------------------
FROM php:8.3-fpm-alpine

# System dependencies
RUN apk add --no-cache \
    curl git zip unzip libpng-dev libjpeg-turbo-dev freetype-dev \
    libzip-dev oniguruma-dev nginx

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy project
COPY . .

# Copy frontend build
COPY --from=frontend-builder /app/public/build ./public/build

# 🔥 IMPORTANT FIX
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose Render port
EXPOSE 10000

# Simple Laravel server (IMPORTANT for Render)
CMD php artisan serve --host=0.0.0.0 --port=10000