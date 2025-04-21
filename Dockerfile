# Usamos la imagen base de PHP 7.4 con Apache
FROM php:7.4-apache

# Habilitar módulo de reescritura de Apache para CodeIgniter
RUN a2enmod rewrite

# Instalar dependencias del sistema (incluyendo cliente MySQL)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-install \
    mysqli \
    pdo_mysql \
    zip

# Copiar archivos de tu proyecto al contenedor
COPY ./ /var/www/html/

# Establecer permisos (ajustar según necesidades específicas)
RUN chown -R www-data:www-data /var/www/html

# Habilitar visualización de errores (solo desarrollo)
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/errors.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini