#PHP - Apache 
FROM php:7.3-apache

RUN apt-get -y update \
&& apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl

RUN docker-php-ext-install mysqli pdo_mysql
RUN a2enmod rewrite
RUN service apache2 restart

RUN rabbitmq-plugins enable rabbitmq_management

COPY src/ /var/www/html/
COPY vhost.conf /etc/apache2/sites-enabled/vhost.conf

#
# Expose port 80
EXPOSE 80
