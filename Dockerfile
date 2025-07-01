# Gunakan image dasar PHP 8.2 dari Alpine Linux yang ringan
FROM php:8.2-fpm-alpine

# Tentukan direktori kerja di dalam kontainer
WORKDIR /var/www/html

# Install dependensi sistem yang dibutuhkan oleh Laravel & ekstensi PHP
RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    postgresql-dev \
    libzip-dev \
    libpng-dev \
    icu-dev \
    jpeg-dev \
    freetype-dev; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    zip \
    intl \
    gd \
    exif \
    bcmath

# Install Composer (manajer paket PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy semua file aplikasi Anda ke dalam kontainer
COPY . .

# Atur kepemilikan file agar bisa ditulis oleh server
RUN chown -R www-data:www-data /var/www/html