#PHP - Apache 
FROM php:7.3-apache

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN apt-get update \
    && apt-get install -y \
        librabbitmq-dev \
        libssh-dev \
    && docker-php-ext-install \
        bcmath \
        sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

RUN apt update && apt install -y unzip

RUN apt-get -y update \
&& apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl \
&& docker-php-ext-install sockets pcntl

#install some base extensions
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip

RUN docker-php-ext-install mysqli pdo_mysql
RUN a2enmod rewrite
RUN service apache2 restart

COPY src/ /var/www/html/
COPY vhost.conf /etc/apache2/sites-enabled/vhost.conf

# Install Composer

# Install Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
#
# Expose port 80
EXPOSE 80
