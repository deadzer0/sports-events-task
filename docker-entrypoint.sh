#!/bin/bash

# Изчакване базата данни да е готова
until nc -z -v -w30 db 3306
do
    echo "Waiting for database connection..."
    sleep 5
done

# Инсталиране на зависимостите
composer install

# Генериране на ключ ако не съществува
php artisan key:generate --no-interaction

# Изпълняване на миграциите
php artisan migrate --force

# Изпълняване на seeders ако са нужни
TABLES_COUNT=$(php artisan tinker --execute="return DB::table('tournaments')->count();")

if [ "$TABLES_COUNT" -eq "0" ]; then
    echo "Database is empty, seeding data..."
    php artisan db:seed --force
else
    echo "Database already has data, skipping seed..."
fi

# Стартиране на Apache
apache2-foreground
