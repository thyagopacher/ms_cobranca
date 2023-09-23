#PHP - Apache 
FROM php:7.3-apache

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN apt update && apt install -y unzip && apt install nano


ENV DEBIAN_FRONTEND noninteractive
RUN apt-get install -y tzdata \
    && ln -fs /usr/share/zoneinfo/America/Fortaleza /etc/localtime && dpkg-reconfigure -f noninteractive tzdata

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

COPY src/ /var/www/html/
COPY ./vhost/ /etc/apache2/sites-available/


RUN a2enmod rewrite
RUN a2enmod headers
RUN a2enmod ssl

# Install Composer

# Install Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN service apache2 restart

#coloca um padrão melhor para memory do PHP
RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-php-ram-limit.ini

#
# Expose port 80
EXPOSE 80
