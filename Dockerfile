FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html
COPY . .

RUN composer update --no-dev --optimize-autoloader

# Buat file database sqlite kosong agar tidak error
RUN mkdir -p /var/www/html/database && touch /var/www/html/database/database.sqlite

RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
