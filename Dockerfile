# [BASE STAGE]
FROM dunglas/frankenphp as base_adaro

# Install php extensions
RUN install-php-extensions \
    pcntl \
    bcmath \
    pdo_mysql \
    redis-stable \
    zip
    # Add other PHP extensions here...

# Set static APP_KEY
ENV APP_KEY=base64:xvl6bymXewa9o0RwhWxwhVD+6xnl902zd0/SSFaC7BU=

COPY . /app

# Install the composer packages using www-data user
WORKDIR /app
COPY --from=composer:2.8.5 /usr/bin/composer /usr/bin/composer
RUN composer install
# [END BASE STAGE]

# [RELEASE STAGE]
FROM base_adaro as release_adaro
# Prepare the frontend files & caching
EXPOSE 8001
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
# [END RELEASE STAGE]
