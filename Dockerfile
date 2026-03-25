FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libsqlite3-dev nginx gettext \
    && docker-php-ext-install zip pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

RUN touch /var/www/html/database/database.sqlite
RUN chown www-data:www-data /var/www/html/database/database.sqlite

COPY docker/nginx.conf /etc/nginx/sites-available/default

CMD ["sh", "-c", "php artisan migrate --force && php-fpm -D && envsubst '${PORT}' < /etc/nginx/sites-available/default > /etc/nginx/sites-enabled/default && echo 'Nginx config:' && cat /etc/nginx/sites-enabled/default && sleep 2 && nginx -g 'daemon off;'"]
