# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

# Image
FROM php:7.4-fpm-alpine

# Build Dependencies
ENV BUILD_DEPS 'git gcc g++ make zip'

# Install Build Dependencies
RUN apk --no-cache upgrade && apk add $BUILD_DEPS

# Install PECL HTTP dependencies (Persistent HTTP Connections)
RUN set -ex \
  && apk add --no-cache bash build-base wget curl icu-dev m4 autoconf libtool imagemagick imagemagick-dev zlib zlib-dev libcurl curl-dev libevent libevent-dev libidn libidn-dev \
  && printf "\n" | pecl install raphf propro \
  && docker-php-ext-enable raphf propro \
  && printf "\n" | pecl install pecl_http \
  && echo -e "extension=raphf.so\nextension=propro.so\nextension=http.so" > /usr/local/etc/php/conf.d/docker-php-ext-http.ini \
  && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-raphf.ini \
  && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-propro.ini


# Librdkafka for kafka integration
RUN git clone --depth 1 --branch v1.4.2 https://github.com/edenhill/librdkafka.git \
    && cd librdkafka \
    && ./configure \
    && make \
    && make install

# PGSQL Extension
RUN apk add postgresql-dev
RUN docker-php-ext-install pdo_pgsql

# Messenger Performance Specific Extensions
RUN apk add --update icu-dev
RUN docker-php-ext-install intl

# Composer installation
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer;

# Instruct pecl to install rdkafka
RUN pecl channel-update pecl.php.net \
    && pecl install rdkafka-3.0.3 \
    && docker-php-ext-enable rdkafka \
    && rm -rf /librdkafka \
    && apk del $BUILD_DEPS

# XDebug
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.9.6 \
    && docker-php-ext-enable xdebug

# Set the default work directory
WORKDIR /app

# Set the default user
USER root

# Add sudo capability for management (should not go production)
RUN apk add sudo

# Add a _www user for symfony
RUN adduser -D _www  \
        && echo "_www ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/_www \
        && chmod 0440 /etc/sudoers.d/_www

# Add bash, composer and git (for symfony CLI tool installation to go smooth)
RUN apk add bash composer git

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash

# Expose Symfony CLI globally to the system
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony