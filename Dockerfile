FROM php:8.4-cli

# Instala dependências do sistema + extensões PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpq-dev \
    build-essential \
    && docker-php-ext-install zip pcntl opcache sockets pdo_pgsql


# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction && \
    printf "1\nyes\n" | php artisan octane:install && \
    ./vendor/bin/rr get-binary -n --ansi;

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["/usr/local/bin/start.sh"]
