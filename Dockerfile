# Gunakan PHP 8.4
FROM php:8.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip nodejs npm nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Set working directory
WORKDIR /var/www

# Copy Laravel project
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader \
    && php artisan storage:link

# Install & Build Frontend (Vite)
RUN npm install && npm run build

# Konfigurasi Nginx
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# Expose ports
EXPOSE 80

# Start PHP-FPM & Nginx
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
