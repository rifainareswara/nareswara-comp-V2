#!/bin/sh

# Jalankan migrasi dan seeding sebelum aplikasi dimulai
php artisan migrate:fresh --seed

# Jalankan PHP-FPM & Nginx
php-fpm & nginx -g "daemon off;"
