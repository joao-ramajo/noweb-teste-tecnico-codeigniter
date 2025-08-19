FROM php:8.0-cli-alpine

WORKDIR /var/www/html

RUN apk --no-cache add $PHPIZE_DEPS linux-headers && \
    pecl install xdebug && \
    docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli xdebug && \
    apk --no-cache del $PHPIZE_DEPS

COPY ["composer.json", "composer.lock", "./"]

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-interaction

COPY . ./

CMD php -S 0.0.0.0:8080 -t /var/www/html index.php