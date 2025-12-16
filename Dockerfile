FROM php:8.2-apache

# Enable rewrite
RUN a2enmod rewrite

# Cài extension MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy toàn bộ project vào Apache
COPY . /var/www/html/

# Set quyền
RUN chown -R www-data:www-data /var/www/html
