FROM dunglas/frankenphp

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
    nodejs \
    npm \
    libicu-dev \
    autoconf \
    g++ \
    make \
    pkgconf

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

# Set PHP.ini configurations
#RUN { \
#    echo 'opcache.memory_consumption=128'; \
#    echo 'opcache.interned_strings_buffer=8'; \
#    echo 'opcache.max_accelerated_files=4000'; \
#    echo 'opcache.revalidate_freq=2'; \
#    echo 'opcache.fast_shutdown=1'; \
#    echo 'opcache.enable_cli=1'; \
#} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Verify PHP extensions are enabled
RUN php -m

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create Laravel storage structure if it doesn't exist
RUN mkdir -p /app/storage/framework
RUN mkdir -p /app/storage/framework/sessions
RUN mkdir -p /app/storage/framework/views
RUN mkdir -p /app/storage/framework/cache

# Copy composer.json and composer.lock first to leverage Docker cache
COPY composer*.json ./
COPY . .

ENV APP_KEY=base64:avl6bymXewa9o0RwhWxwhVD+6xnl902zd0/SSFaC7BU=

# Set git to safe directory
RUN git config --global --add safe.directory /app

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage /app/bootstrap/cache \
    && chmod -R +x /app

# Install composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN php artisan config:clear
# Expose port
EXPOSE 8000

# Start FrankenPHP
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
