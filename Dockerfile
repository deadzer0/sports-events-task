FROM php:8.3-apache

# Приемане на UID и GID като аргументи
ARG UID=1000
ARG GID=1000

# Инсталиране на системни зависимости
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    netcat-traditional \
    librabbitmq-dev \
    libssl-dev

# Активиране на Apache mod_rewrite
RUN a2enmod rewrite

# Задаване на ServerName, за да се премахне предупреждението
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Инсталиране на PHP разширения
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd sockets

# Инсталиране на AMQP разширението
RUN pecl install amqp && \
    docker-php-ext-enable amqp

# Инсталиране на Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Създаване на нова група и потребител с UID и GID от аргументите
RUN groupadd -g ${GID} laravel && \
    useradd -u ${UID} -g laravel -m laravel

# Работна директория
WORKDIR /var/www/html

# Копиране на Laravel проекта
COPY . /var/www/html

# Настройка на правата
RUN chown -R laravel:laravel /var/www/html

# Конфигуриране на Apache DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Копиране на wait-for-it.sh
COPY wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Копиране и настройка на entrypoint скрипта
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Превключване към новия потребител
USER laravel
