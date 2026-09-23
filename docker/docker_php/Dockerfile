FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        git unzip \
    && docker-php-ext-install \
        intl \
        pdo_pgsql \
        pgsql \
        zip \
        bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions xdebug

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
