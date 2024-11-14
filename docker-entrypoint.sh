#!/bin/bash

# Wait for database to be ready
until nc -z -v -w30 db 3306
do
    echo "Waiting for database connection..."
    sleep 5
done

# Install dependencies
composer install

# Generate key if not exists
php artisan key:generate --no-interaction

# Run migrations
php artisan migrate --force

# Run seeders if needed
TABLES_COUNT=$(php artisan tinker --execute="return DB::table('tournaments')->count();")

if [ "$TABLES_COUNT" -eq "0" ]; then
    echo "Database is empty, seeding data..."
    php artisan db:seed --force
else
    echo "Database already has data, skipping seed..."
fi

# Start Apache
apache2-foreground
