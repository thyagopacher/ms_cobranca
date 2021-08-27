
FROM php:7.2-apache

COPY src/ /var/www/html/


#
# Expose port 80
EXPOSE 80

