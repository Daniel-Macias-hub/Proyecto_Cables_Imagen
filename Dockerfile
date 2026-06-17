FROM php:8.1-apache

# Habilitar PDO y PDO_MYSQL para el shim
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite de Apache si se necesita a futuro
RUN a2enmod rewrite

# Copiar configuración personalizada de PHP
COPY .user.ini /usr/local/etc/php/conf.d/user.ini

WORKDIR /var/www/html/
