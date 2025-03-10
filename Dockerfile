FROM dunglas/frankenphp:latest

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer.json and composer.lock first to leverage Docker cache
COPY composer*.json ./

# Set git to safe directory
RUN git config --global --add safe.directory /var/www/html

# Install composer dependencies
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader

# Copy the rest of the application
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R +x /var/www/html

# Finish composer
RUN composer dump-autoload --no-dev --optimize

# Generate config file for FrankenPHP
RUN echo "worker ./public/index.php" > Caddyfile

# Generate application key
RUN php artisan key:generate

# Expose port
EXPOSE 80 443

# Start FrankenPHP
CMD ["frankenphp", "run", "--config", "Caddyfile"]
