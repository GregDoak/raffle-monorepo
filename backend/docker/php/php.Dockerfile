FROM bref/php-85-dev:3
ENV BREF_RUNTIME=fpm

RUN dnf install -y make git

COPY --from=composer:2 /usr/bin/composer /usr/bin/
