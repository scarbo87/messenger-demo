#!/bin/bash

mkdir -p /var/www/symfony
cd /var/www/symfony

composer install --prefer-dist --no-interaction

php -S 0.0.0.0:80 -t public
