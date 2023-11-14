FROM php:8.2.12-fpm-alpine3.18 as base

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions
RUN install-php-extensions @fix_letsencrypt
RUN install-php-extensions bcmath
RUN install-php-extensions intl
RUN install-php-extensions opcache
RUN install-php-extensions pcntl
RUN install-php-extensions pdo_mysql
RUN install-php-extensions redis
RUN install-php-extensions sockets
RUN install-php-extensions grpc


FROM base as development

RUN install-php-extensions @composer-2
RUN install-php-extensions xdebug
RUN  mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN rm -fr /var/cache/*
