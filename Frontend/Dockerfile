FROM php:8.0-apache
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY Frontend/PCS_PRESTATAIRE/ /var/www/html/pcs_prestataire/
COPY Frontend/Site/ /var/www/html/site/
EXPOSE 80
