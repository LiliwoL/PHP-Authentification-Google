# Dockerfile
FROM php:8.3-apache

ARG user_id=1000
RUN usermod -u $user_id www-data

EXPOSE 80

WORKDIR /var/www/html


# Configuration Apache
COPY Docker/config/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY Docker/config/apache.conf /etc/apache2/conf-available/docker-app.conf

# Gestion des erreurs
COPY Docker/errors /errors

# Copie des sources
COPY ./app/ /var/www/html

# Activation de la config
RUN a2enmod rewrite remoteip && \
    a2enconf docker-app

# Installation des dépendances et composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN apt-get update -qq && \
    apt-get install -qy \
    git \
    gnupg \
    unzip \
    sqlite3 \
    zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Configuration PHP
#RUN docker-php-ext-install -j$(nproc) pdo_sqlite
COPY Docker/config/php.ini /usr/local/etc/php/conf.d/app.ini


# Dépendances Composer
RUN cd /var/www/html/PHP-Authentification-Google
RUN composer install --no-dev --no-interaction --no-autoloader --no-scripts
RUN composer dump-autoload --optimize