FROM php:8.2-apache

# Install PHP MySQL extension
RUN docker-php-ext-install mysqli pdo pdo_mysql
# Enable Apache SSL and rewrite module
RUN a2enmod rewrite

# Optional: Copy your custom conf if you want to build it in (or use bind mount in compose)
# COPY ../apache-config/mysite.conf /etc/apache2/sites-available/mysite.conf
