FROM dunglas/frankenphp:1-php8.3 as base

# Buat direktori untuk menyimpan sertifikat
WORKDIR /usr/local/share/ca-certificates/extra

# Download sertifikat dari URL yang diberikan
RUN curl -sL -o e5.pem https://letsencrypt.org/certs/2024/e5.pem \
    && curl -sL -o e6.pem https://letsencrypt.org/certs/2024/e6.pem \
    && curl -sL -o r10.pem https://letsencrypt.org/certs/2024/r10.pem \
    && curl -sL -o r11.pem https://letsencrypt.org/certs/2024/r11.pem \
    && curl -sL -o isrg-root-x2.pem https://letsencrypt.org/certs/isrg-root-x2.pem \
    && curl -sL -o root-usertrust.pem https://comodoca.my.salesforce.com/sfc/dist/version/download/?oid=00D1N000002Ljih\&ids=0683l00000G9fM4\&d=%2Fa%2F3l000000VbFv%2FEWLhAEEonKwYhE.ECAMo57Mhe66ulQN9qXphqcoheSU\&asPdf=false \
    && curl -sL -o aaa-cert.pem https://comodoca.my.salesforce.com/sfc/dist/version/download/?oid=00D1N000002Ljih\&ids=0683l00000N5mSWAAZ\&d=/a/3l000000sYVG/4l82xrBbMv8Ndh.SBoUvQs0BjYk_pJlb4Sa92KfrsxY

# Konversi ke format CRT dan pindahkan ke direktori yang digunakan oleh sistem
RUN openssl x509 -outform PEM -in e5.pem -out /usr/local/share/ca-certificates/e5.crt && \
    openssl x509 -outform PEM -in e6.pem -out /usr/local/share/ca-certificates/e6.crt && \
    openssl x509 -outform PEM -in r10.pem -out /usr/local/share/ca-certificates/r10.crt && \
    openssl x509 -outform PEM -in r11.pem -out /usr/local/share/ca-certificates/r11.crt && \
    openssl x509 -outform PEM -in isrg-root-x2.pem -out /usr/local/share/ca-certificates/isrg-root-x2.crt && \
    openssl x509 -outform PEM -in root-usertrust.pem -out /usr/local/share/ca-certificates/root-usertrust.crt && \
    openssl x509 -outform PEM -in aaa-cert.pem -out /usr/local/share/ca-certificates/aaa-cert.crt

# Update sertifikat CA di container
RUN update-ca-certificates

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

RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs
RUN npm install --global yarn
RUN yarn cache clean
RUN yarn install
RUN yarn build


FROM base as release
# Prepare the frontend files & caching
EXPOSE 8000
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]

