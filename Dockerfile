FROM dunglas/frankenphp:latest

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

# Set PHP.ini configurations
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Verify PHP extensions are enabled
RUN php -m

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer.json and composer.lock first to leverage Docker cache
COPY composer*.json ./
COPY . .

# Set git to safe directory
RUN git config --global --add safe.directory /var/www/html

# Create Laravel storage structure if it doesn't exist
RUN mkdir -p storage/framework/{sessions,views,cache}

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage /app/bootstrap/cache \
    && chmod -R +x /app

# Install composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs

# Generate application key if not exists
#RUN php artisan key:generate --force

# Expose port
EXPOSE 8000

# Start FrankenPHP
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]

