FROM php:8.2-fpm-alpine

# Install dependencies
RUN apk add --no-cache --virtual .build-deps \
        oniguruma-dev \
        libzip-dev \
        tzdata \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        zip \
        opcache \
        bcmath \
        exif \
        mbstring \
    && apk del .build-deps

# Set timezone
ENV TZ=Asia/Phnom_Penh

# Use production PHP config
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Custom PHP settings
RUN echo "memory_limit=256M" > $PHP_INI_DIR/conf.d/custom.ini \
 && echo "upload_max_filesize=20M" >> $PHP_INI_DIR/conf.d/custom.ini \
 && echo "post_max_size=20M" >> $PHP_INI_DIR/conf.d/custom.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Fix permissions
RUN chown -R www-data:www-data /var/www/html