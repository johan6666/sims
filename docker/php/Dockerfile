FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json ./
RUN npm install
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build

FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
        bash \
        git \
        icu-dev \
        libzip-dev \
        oniguruma-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        zlib-dev \
        libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        bcmath \
        exif \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        zip \
        gd \
    && rm -rf /var/cache/apk/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY --from=vendor /app/vendor /opt/vendor
COPY --from=assets /app/public/build /opt/public-build

COPY . /var/www/html
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && mkdir -p storage bootstrap/cache public/build \
    && chown -R www-data:www-data storage bootstrap/cache public/build

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm", "-F"]
