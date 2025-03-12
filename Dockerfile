FROM dunglas/frankenphp as base

# Set working directory
WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    autoconf \
    g++ \
    make \
    pkgconf \
    libicu-dev

# Install PHP extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    opcache \
    intl \
    zip \
    xml \
    soap

# Install additional extensions via PECL
RUN pecl install apcu && docker-php-ext-enable apcu
RUN pecl install redis && docker-php-ext-enable redis

COPY . /app

# Install the composer packages using www-data user
WORKDIR /app
COPY --from=composer:2.8.5 /usr/bin/composer /usr/bin/composer
RUN composer install
# [END BASE STAGE]

# [FRONTEND STAGE]
FROM node:22-alpine as frontend
WORKDIR /app
COPY . .
RUN apk add --no-progress --quiet --no-cache git
RUN yarn cache clean
RUN yarn install
RUN yarn build
# [END FRONTEND STAGE]

# [RELEASE STAGE]
FROM base as release
# Prepare the frontend files & caching
COPY --from=frontend --chown=www-data:www-data /app/public /app/public
EXPOSE 8000
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]

