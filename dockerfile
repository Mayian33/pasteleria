FROM php:apache  
COPY . /var/www/html/  
EXPOSE 80  
# Instalar las extensiones necesarias de PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Cambiar permisos del directorio de trabajo (ejemplo: /var/www/html)
RUN chown -R www-data:www-data /var/www/html
