# Dockerfile (Versi Perbaikan untuk Build)
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Install dependensi sistem & ekstensi PHP yang dibutuhkan
RUN apk add --no-cache \
    git curl zip unzip postgresql-dev libzip-dev libpng-dev icu-dev jpeg-dev freetype-dev; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j$(nproc) pdo pdo_pgsql zip intl gd exif bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --- Perubahan Penting di Sini ---

# 1. Copy file composer terlebih dahulu untuk optimasi cache
COPY composer.json composer.lock ./

# 2. Jalankan composer install SEBELUM meng-copy sisa file
RUN composer install --no-dev --no-interaction --optimize-autoloader

# 3. Baru copy sisa kode aplikasi Anda
COPY . .

# Atur kepemilikan file agar bisa ditulis oleh server
RUN chown -R www-data:www-data /var/www/html

# Expose port yang akan digunakan oleh artisan serve
EXPOSE 8080

# Perintah untuk menyalakan server saat kontainer berjalan
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8080"]