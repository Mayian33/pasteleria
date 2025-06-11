FROM php:apache

# Install dependencies
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite
COPY ./var/www/html/

# Enable permissions 
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
