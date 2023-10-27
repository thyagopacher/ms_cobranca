#PHP - Apache 
FROM php:8.1-apache

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN apt update && apt install -y unzip 

#Editor de texto para o bash NANO
RUN apt install nano

ENV DEBIAN_FRONTEND noninteractive

#Ajuste do timezone para o padrão Brasil
RUN apt-get install -y tzdata \
    && ln -fs /usr/share/zoneinfo/America/Fortaleza /etc/localtime && dpkg-reconfigure -f noninteractive tzdata

RUN apt-get -y update \
&& apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl \
&& docker-php-ext-install sockets pcntl

# Gestor de JOBs para o Laravel
RUN apt-get update && apt-get install -y openssh-server apache2 supervisor
RUN mkdir -p /var/lock/apache2 /var/run/apache2 /var/run/sshd /var/log/supervisor

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN /usr/bin/supervisord

RUN echo user=root >>  /etc/supervisor/supervisord.conf


#suporte para o REDIS atrelado ao container e PHP
RUN pecl install redis \
&& docker-php-ext-enable redis

#suporte para o MySQL atrelado ao container e PHP
RUN docker-php-ext-install mysqli pdo_mysql

COPY src/ /var/www/html/

RUN rm -r /etc/apache2/sites-available/000-default.conf
COPY ./vhost/ /etc/apache2/sites-available/

RUN a2enmod rewrite
RUN a2enmod headers
RUN a2enmod ssl

RUN a2ensite vhost.conf

# Install Composer

# Install Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

#coloca um padrão melhor para memory do PHP
RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-php-ram-limit.ini

RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'post_max_size = 150M' >> /usr/local/etc/php/conf.d/docker-php-post-limit.ini

RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'upload_max_filesize = 150M' >> /usr/local/etc/php/conf.d/docker-php-upload-limit.ini

#
# Expose port 80
EXPOSE 80
CMD ["/usr/bin/supervisord","-n"]

