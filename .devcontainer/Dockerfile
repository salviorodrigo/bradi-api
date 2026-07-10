FROM mcr.microsoft.com/devcontainers/php:3-8.5-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends ripgrep \
    && rm -rf /var/lib/apt/lists/*

RUN sed -i "s/xdebug.start_with_request = yes/xdebug.start_with_request = trigger\\nxdebug.client_host = host.docker.internal/" /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install iconv