FROM php:7.4.1-apache

USER root

# WORKDIR /root
# COPY nodesource_setup.sh ./
# SHELL ["/bin/sh", "-c"] 
# RUN chmod +x nodesource_setup.sh

# CMD ["/nodesource_setup.sh"]
# RUN /bin/bash -c /root/nodesource_setup.sh

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        unzip \        
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete 


COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

COPY composer.json composer.lock ./

RUN composer install --no-scripts --no-autoloader

EXPOSE 8080

# RUN npm install

# COPY package.json package-lock.json webpack.mix.js laravel-echo-server.json .env ./
# # RUN ls
# RUN npm install -g laravel-echo-server
# EXPOSE 8080
# # CMD ["laravel-echo-server","start","-p","6001"]