FROM php:8.4-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/todo-app/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update \
    && apt-get -y install vim wget unzip lsb-release libicu-dev libfreetype6-dev libjpeg62-turbo-dev libzip-dev libsqlite3-dev \
    && docker-php-ext-install pdo_mysql pdo_sqlite mysqli intl gd zip

RUN a2enmod rewrite

# Composerをインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer