FROM php:8.3-fpm

WORKDIR /var/www

# dépendances système
RUN apt-get update && apt-get install -y \
    zip unzip curl libpng-dev libonig-dev libxml2-dev

# extensions PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]