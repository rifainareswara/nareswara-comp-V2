#!/bin/sh
set -e

# Update database connection to point to the db container
sed -i "s/DB_HOST=127.0.0.1/DB_HOST=db/g" .env

echo "Waiting for MySQL to be ready..."
# Simple wait loop
MAX_TRIES=30
TRIES=0
while [ $TRIES -lt $MAX_TRIES ]; do
    if mysql -h db -u root --password= -e "SELECT 1" >/dev/null 2>&1; then
        echo "MySQL is ready!"
        break
    fi
    TRIES=$((TRIES+1))
    echo "Waiting for MySQL (attempt $TRIES/$MAX_TRIES)..."
    sleep 2
done

if [ $TRIES -eq $MAX_TRIES ]; then
    echo "Error: MySQL did not become ready in time"
    exit 1
fi

# Run database migrations
php artisan migrate --force

# Start FrankenPHP
exec /usr/local/bin/frankenphp run