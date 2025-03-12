FROM dunglas/frankenphp

# Set working directory
WORKDIR /app

# Install dependencies including Node.js and npm
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

# Install more modern Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

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

# Create Laravel storage structure if it doesn't exist
RUN mkdir -p /app/storage/framework
RUN mkdir -p /app/storage/framework/sessions
RUN mkdir -p /app/storage/framework/views
RUN mkdir -p /app/storage/framework/cache

# Copy package.json and package-lock.json first to leverage Docker cache
COPY package*.json ./
RUN npm install

# Copy composer files
COPY composer*.json ./
RUN composer install --no-scripts --no-autoloader --no-interaction

# Copy the rest of the application
COPY . .

# Generate application key if not set
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

# Build frontend assets
RUN npm run build

# Expose port
EXPOSE 8000

# Start FrankenPHP
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
