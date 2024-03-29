FROM laravelsail/php82-composer:latest as composer
FROM php:5.6-fpm

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer update --prefer-dist --no-scripts --no-dev --no-autoloader --ignore-platform-reqs --ignore-platform-reqs && \
    composer install --prefer-dist --no-scripts --no-dev --no-autoloader --ignore-platform-reqs --ignore-platform-reqs && \
    composer clear-cache
COPY . .
RUN composer dump-autoload --no-scripts --no-dev --optimize

# Depending on the composer you use, you may be required to use a different php version.
FROM php:8.2-apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# 1. Install production packages and clean up apt cache.
RUN apt-get update && apt-get install -y \
    libbz2-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libreadline-dev \
    libpq-dev \
    sudo \
    zip \
 && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

# 2. Apache configs + document root.
RUN echo "ServerName laravel-app.local" >> /etc/apache2/apache2.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# 4. Start with base PHP config, then add extensions.
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install \
    bcmath \
    bz2 \
    calendar \
    iconv \
    intl \
    mbstring \
    opcache \
    pdo pdo_pgsql pgsql \
    zip

# 5. Copy the application code from the composer stage.
#COPY --from=composer /app /var/www/html
