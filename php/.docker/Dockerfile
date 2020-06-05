# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

# Image
FROM php:7.4-fpm-alpine

# Build Dependencies
ENV BUILD_DEPS 'autoconf git gcc g++ make bash'

# Install Build Dependencies
RUN apk --no-cache upgrade && apk add $BUILD_DEPS

# 
RUN git clone --depth 1 --branch v1.4.2 https://github.com/edenhill/librdkafka.git \
    && cd librdkafka \
    && ./configure \
    && make \
    && make install

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer;

RUN pecl channel-update pecl.php.net \
    && pecl install rdkafka-4.0.3 \
    && docker-php-ext-enable rdkafka \
    && rm -rf /librdkafka \
    && apk del $BUILD_DEPS

WORKDIR /app

USER root

RUN apk add sudo

RUN adduser -D _www  \
        && echo "_www ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/_www \
        && chmod 0440 /etc/sudoers.d/_www

RUN apk add bash composer git

RUN wget https://get.symfony.com/cli/installer -O - | bash

RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony