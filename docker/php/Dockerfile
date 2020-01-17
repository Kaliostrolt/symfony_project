FROM php:7.3-fpm

ENV PROJECT_DIR /usr/src/app
ARG BUILD_MODE=dev
ARG BUILD_NO_XDEBUG=''

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev
RUN docker-php-ext-install zip

RUN docker-php-ext-enable apcu

# install composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# allow composer to be run by superuser/root without warning "Do not run Composer as root/super user!"
ENV COMPOSER_ALLOW_SUPERUSER 1

# install/enable xdebug (for "dev" build mode)
# Note: we do it AFTER composer execution to speed up the build process
RUN if [ "$BUILD_MODE" = "dev" -a -z "$BUILD_NO_XDEBUG" ] ; then \
    pecl install xdebug-2.7.0 \
        && docker-php-ext-enable xdebug \
# copy custom PHP xdebug config (if any)
    ; if [ -f ${PROJECT_DIR}/docker/php/xdebug.ini ]; then \
        cp -f ${PROJECT_DIR}/docker/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    ; fi \
; fi

# install optional software (convenient for development)
RUN if [ "$BUILD_MODE" = "dev" ] ; then apt-get install -y \
    iputils-ping \
; fi

WORKDIR ${PROJECT_DIR}

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin