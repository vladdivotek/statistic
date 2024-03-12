FROM php:8.1-fpm-alpine

WORKDIR "/var/www/html"

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN echo "Updating dependencies:"
RUN apk update && apk add \
	mc \
	nano \
    build-base \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    curl \
    libmcrypt-dev \
    neovim \
    bash \
    openssh-client

RUN apk add --update linux-headers

# Installing PDO-MySQL Extension
RUN echo "Installing PDO-MySQL Extension:"
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Installing composer
RUN echo "Installing composer"
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installing NodeJS
RUN echo "Installing NodeJS:"
RUN apk add nodejs npm
