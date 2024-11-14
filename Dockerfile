FROM php:8.3-apache

# Инсталиране на системни зависимости
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    netcat-traditional

# Активиране на Apache mod_rewrite
RUN a2enmod rewrite

# Инсталиране на PHP разширения
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Инсталиране на Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копиране на Laravel проекта
COPY . /var/www/html/

# Настройване на Apache DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Настройване на права
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 775 /var/www/html/bootstrap/cache

# Работна директория
WORKDIR /var/www/html

# Копиране и настройване на entrypoint скрипта
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Уверяваме се, че PHP процесите ще се изпълняват като www-data
USER www-data
