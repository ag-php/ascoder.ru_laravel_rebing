#!/bin/bash

git pull origin main
composer install
npm install
php artisan migrate
php artisan storage:link
php artisan optimize
npm run prod
