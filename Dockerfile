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
    npm

# Instala extensiones PHP necesarias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Configura el directorio de trabajo
WORKDIR /var/www

# Clona tu proyecto desde el repositorio
RUN git clone https://github.com/sharvel-irigoyen/financia-pro.git

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


