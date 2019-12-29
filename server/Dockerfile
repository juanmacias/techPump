FROM php:7.4.1-apache-buster

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Opcache
RUN docker-php-ext-install opcache

# Install basic tools

RUN apt-get update && apt-get install -y wget
RUN apt-get install -y vim git

# Install composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer creates=/usr/local/bin/composer

# Install apache modules

RUN a2enmod rewrite vhost_alias  && service apache2 restart
