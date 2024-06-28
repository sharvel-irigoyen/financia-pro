# Usa la imagen base de PHP con FPM
FROM php:8.2-fpm

# Instala dependencias y extensiones necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nodejs \
    npm \
    nano

# Instala extensiones PHP necesarias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

# Instala Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Configura el directorio de trabajo
# WORKDIR /var/www

# Clona tu proyecto desde el repositorio
# RUN git clone https://github.com/sharvel-irigoyen/financia-pro.git

# Instala las dependencias de Composer
WORKDIR /var/www/financia-pro
RUN composer install

# Copia el archivo de entorno
COPY .env.example .env

# Genera la clave de la aplicación
RUN php artisan key:generate

# Crea el enlace simbólico para el almacenamiento
RUN php artisan storage:link

# Instala las dependencias de npm
RUN npm install

# Compila los assets
RUN npm run build

# Expone el puerto 9000
EXPOSE 9000
