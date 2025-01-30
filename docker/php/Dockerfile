FROM composer:lts as composer

FROM php:8.4.3-fpm-bookworm

WORKDIR /var/www/html

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    gd \
    xml \
    simplexml \
    pdo \
    pdo_mysql \
    mysqli \
    mbstring \
    xdebug \
    decimal \
    yaml \
    xsl \
    apcu \
    ctype \
    iconv \
    intl \
    opcache \
    zip

COPY ./conf/xdebug.ini $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
COPY ./conf/custom.ini $PHP_INI_DIR/conf.d/custom.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN ln -s /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini