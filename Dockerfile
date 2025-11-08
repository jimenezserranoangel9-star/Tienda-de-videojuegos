FROM php:8.2-apache

# Instala extensiones de PDO y MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Habilita el módulo rewrite (opcional, útil para frameworks)
RUN a2enmod rewrite

# Copia el contenido de tu proyecto
COPY ./www /var/www/html/

# Da permisos correctos
RUN chown -R www-data:www-data /var/www/html