# use PHP 8.2
FROM php:8.2-fpm

# Install common php extension dependencies
RUN apt-get update && apt-get install -y \
    netcat-openbsd \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    curl \
    gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-ext-install bcmath
    # && pecl install mongodb \
    # && docker-php-ext-enable mongodb

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Set the working directory
COPY . /var/www/app
WORKDIR /var/www/app

RUN chown -R www-data:www-data /var/www/app \
    && chmod -R 775 /var/www/app/storage

# Install composer
COPY --from=composer:2.6.5 /usr/bin/composer /usr/local/bin/composer

# Copy composer.json and package.json to workdir & install dependencies
COPY composer.json ./
COPY package.json ./
RUN composer install && npm install

# Expose a port (if your application runs on a specific port)
EXPOSE 3000

# Set the default command to run php-fpm
CMD ["php-fpm"]
