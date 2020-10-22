FROM php:7.4-cli

WORKDIR /usr/src/app
CMD [ "php", "./index.php" ]

RUN pecl install redis-5.1.1 \
    && docker-php-ext-enable redis