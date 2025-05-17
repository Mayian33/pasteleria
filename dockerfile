# Imagen base con PHP y Apache
FROM php:8.2-apache

# Habilita mod_rewrite de Apache
RUN a2enmod rewrite

# Instala extensiones de PHP necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia el contenido del proyecto al contenedor
COPY . /var/www/html/

# Establece permisos adecuados (opcional, pero recomendado)
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto 80 para Apache
EXPOSE 80
