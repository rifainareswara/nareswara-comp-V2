# Stage 1: Build frontend
FROM node:18 as node-build

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Build Laravel backend dengan PHP 8.4
FROM php:8.4-cli

WORKDIR /app
COPY . /app

# Install dependensi yang diperlukan
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libzip-dev \
    default-mysql-client \
    libpng-dev \
    && docker-php-ext-install zip pdo pdo_mysql mysqli gd

# Install Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Copy built frontend assets dari stage node
COPY --from=node-build /app/public/build /app/public/build

# Set permissions dan storage link
RUN php artisan storage:link && \
    chmod -R 775 /app/storage /app/bootstrap/cache

# Expose port 80
EXPOSE 80

# Command untuk menjalankan server secara langsung
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]