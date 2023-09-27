#!/bin/sh

composer install

php-fpm

exec "$@"
