FROM php:7.2-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y zlib1g-dev \
    && docker-php-ext-install pdo pdo_mysql zip

ADD start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

WORKDIR /var/www/symfony
EXPOSE 80

ENTRYPOINT ["/usr/local/bin/start.sh"]
