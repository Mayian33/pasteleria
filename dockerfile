FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html/

# Habilitar módulo rewrite (opcional pero útil)
RUN a2enmod rewrite

# Exponer el puerto 80
EXPOSE 80
