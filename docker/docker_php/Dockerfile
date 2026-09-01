FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    zlib1g-dev \
    libicu-dev \
    libpq-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        intl \
        zip \
        pdo \
        pdo_pgsql \
        pgsql \
        xml \
        bcmath \
        mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG USER_ID=1000
RUN usermod -u ${USER_ID} www-data && groupmod -g ${USER_ID} www-data

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .

USER www-data
