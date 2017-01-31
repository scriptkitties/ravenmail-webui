#! /usr/bin/env sh

php artisan cache:clear && \
	composer dump-autoload && \
	php artisan migrate:refresh --seed && \
	phpunit

