FROM php:8.3-fpm-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

# Install required dependencies for GD and other extensions
RUN apk --no-cache add \
    curl \
    zip \
    unzip \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install gd pdo_mysql intl mysqli zip \
    && docker-php-ext-enable gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set correct permissions (optional, based on your app needs)
RUN chown -R www-data:www-data /var/www/html

# ENTRYPOINT [ "./run.sh" ]
