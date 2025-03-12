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

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create Laravel storage structure
RUN mkdir -p /app/storage/framework/sessions \
    /app/storage/framework/views \
    /app/storage/framework/cache

# Copy package.json and package-lock.json
COPY package*.json ./

# Copy composer files
COPY composer*.json ./
RUN composer install --no-scripts --no-autoloader --no-interaction

# Copy the rest of the application
COPY . .

# Set environment variables
ENV APP_KEY=base64:avl6bymXewa9o0RwhWxwhVD+6xnl902zd0/SSFaC7BU=

# Set git to safe directory
RUN git config --global --add safe.directory /app

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage /app/bootstrap/cache \
    && chmod -R +x /app

# Run composer install again with all scripts
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Clear config cache
RUN php artisan config:clear

FROM node:22-alpine as frontend
WORKDIR /app
COPY . .
RUN apk add --no-progress --quiet --no-cache git
RUN yarn cache clean
RUN yarn install
RUN yarn build
# [END FRONTEND STAGE]

FROM base as release
# Prepare the frontend files & caching
COPY --from=frontend --chown=www-data:www-data /app/public /app/public

# Expose port
EXPOSE 8000

# Start FrankenPHP
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
