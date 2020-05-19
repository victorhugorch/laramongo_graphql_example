FROM php:7.4-fpm-alpine

MAINTAINER Victor Hugo Rocha <victorhugorch@gmail.com>

WORKDIR /var/www

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN sed -i 's/memory_limit.*$/memory_limit = 512M/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/upload_max_filesize.*$/upload_max_filesize = 100M/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/post_max_size.*$/post_max_size = 100M/g' $PHP_INI_DIR/php.ini

RUN set -ex \
 && apk update \
 && apk upgrade \
 && apk --no-cache add $PHPIZE_DEPS openssl-dev git libgcrypt-dev libxml2-dev zip libzip-dev libstdc++ bash \
 && docker-php-ext-configure zip \
 && docker-php-ext-install zip bcmath soap pdo pcntl

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN apk --update --no-cache add autoconf g++ make && \
    pecl install -f xdebug && \
    docker-php-ext-enable xdebug && \
    apk del --purge autoconf g++ make

RUN apk add --update nodejs nodejs-npm

EXPOSE 9000
CMD ["php-fpm"]