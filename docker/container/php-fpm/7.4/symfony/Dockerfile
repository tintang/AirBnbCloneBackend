FROM php:7.4-fpm

# set our timezone
ENV TZ "Europe/Berlin"

# create a new user php that is connected to user id 1000 (default user on linux)
# this will map rights to the outer user
# advantage: files created by php (via composer install|update) are accessable by developer
# disadvantage: if your user id is not 1000 this does not work and is as default - use acls instead
RUN groupadd --gid 1000 php \
  && useradd --uid 1000 --gid php --shell /bin/bash --create-home php

# install required extensions
RUN apt-get update && apt-get install -y \
    wget \
    git \
    unzip \
    libxml2-dev \
    libxml2-dev libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    zlib1g-dev \
    libssl-dev \
    libzip-dev \
    libicu-dev \
    zip \
    graphicsmagick

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    intl \
    xml \
    simplexml  \
    zip \
    xmlreader \
    xmlwriter \
    opcache

# install x-debug
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY ./config/xdebug.ini /usr/local/etc/php/conf.d/30-xdebug.ini


# set user php as default user after logged in to container

COPY ./bin /root/bin/
RUN /root/bin/install-composer.sh
RUN /root/bin/install-symfony.sh

USER php
