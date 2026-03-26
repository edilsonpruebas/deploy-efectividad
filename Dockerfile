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

# Solo crear el archivo si NO existe (preserva datos entre reinicios)
RUN [ -f /var/www/html/database/database.sqlite ] || touch /var/www/html/database/database.sqlite
RUN chown www-data:www-data /var/www/html/database/database.sqlite

COPY docker/nginx.conf /etc/nginx/sites-available/default

# ✅ Ahora incluye db:seed con --class para no duplicar datos
CMD ["sh", "-c", "php artisan migrate --force && php artisan db:seed --force && php-fpm -D && sleep 1 && nginx -g 'daemon off;'"]