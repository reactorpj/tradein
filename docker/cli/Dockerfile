FROM composer:lts as composer

FROM php:8.4-cli-bookworm

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

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt update \
    && apt install wget

RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

COPY ./conf/custom.ini $PHP_INI_DIR/conf.d/custom.ini

RUN ln -s /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini