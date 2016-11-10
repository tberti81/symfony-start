FROM php:7.0-fpm

RUN apt-get update && \
    apt-get install -y libbz2-dev \
            zlib1g-dev \
            libmcrypt-dev \
            libmemcached-dev \
    && \
    apt-get clean \
    && \
    rm -rf /var/lib/apt/lists/* \
    && \
    docker-php-ext-install mbstring \
    && \
    pecl install memcached \
    && \
    docker-php-ext-enable memcached \
    && \
    mkdir -p /www/log/symfonystart \
    && \
    chmod 777 /www/log/symfonystart
