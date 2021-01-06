FROM php:7.4-zts-buster

ENV SWOOLE_VERSION=4.5.9

RUN set -xe && \
    apt-get update && \
    apt-get install -y $PHPIZE_DEPS libpq-dev netcat-traditional git openssl libssl-dev libcurl4-openssl-dev autoconf libzip-dev && \
    docker-php-ext-install sockets exif zip && \
    docker-php-ext-enable sockets exif zip

RUN set -xe && \
    curl -LO https://github.com/swoole/swoole-src/archive/v${SWOOLE_VERSION}.tar.gz && \
    tar xzf v${SWOOLE_VERSION}.tar.gz && \
    cd swoole-src-${SWOOLE_VERSION} && \
        phpize && \
        ./configure --enable-openssl --with-openssl-dir=/usr/include/openssl && \
        make -j && \
        make && \
        make install && \
    cd ../.. && rm -rf v${SWOOLE_VERSION}.tar.gz swoole-src-${SWOOLE_VERSION} && \
    docker-php-ext-enable swoole

RUN set -xe && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN set -xe && \
#    git clone https://github.com/swoole/sdebug.git && \
#    cd sdebug && \
#    ./rebuild.sh && \
#    cd .. && \
#    rm -rf sdebug\

RUN set -xe && \
    apt-get remove -y $PHPIZE_DEPS


ADD hyperf.ini /usr/local/etc/php/conf.d/hyperf.ini

WORKDIR /app