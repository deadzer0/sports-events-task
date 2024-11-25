#!/bin/bash

# Изчакване на базата данни да бъде готова
wait-for-it.sh db:3306 -t 30 -- echo "Database is up"

# Инсталиране на зависимостите
git config --global --add safe.directory /var/www/html
composer install

# Генериране на ключ, ако не съществува
php artisan key:generate --no-interaction

# Изпълнение на миграциите
php artisan migrate --force

# Изпълнение на seeders, ако е необходимо
TABLES_COUNT=$(php -r "require 'vendor/autoload.php'; echo \DB::table('tournaments')->count();")

if [ "$TABLES_COUNT" = "0" ]; then
    echo "Database is empty, seeding data..."
    php artisan db:seed --force
else
    echo "Database already has data, skipping seed..."
fi

# Стартиране на Apache
apache2-foreground
