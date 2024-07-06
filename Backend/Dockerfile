FROM php:8.0-apache
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY Backend/API/ /var/www/html/api/
COPY Backend/PCS_ADMIN/ /var/www/html/pcs_admin/
EXPOSE 80
