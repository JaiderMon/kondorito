FROM php:8.2-cli

WORKDIR /app

RUN apt-get update \
    && apt-get install -y unzip git libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

COPY . .

CMD php -S 0.0.0.0:${PORT:-10000} -t public public/router.php
