#!/bin/bash

set -e

cd /home/gens7193/public_html/panel-admin.gen-zi.id

echo "Pull latest code..."
git pull origin master

echo "Clear old Laravel bootstrap cache..."
rm -f bootstrap/cache/*.php

echo "Install dependencies..."
~/bin/composer install --no-dev --no-scripts --optimize-autoloader

echo "Laravel cache..."
/usr/local/bin/php artisan config:clear
/usr/local/bin/php artisan cache:clear
/usr/local/bin/php artisan view:clear

echo "Database migration..."
/usr/local/bin/php artisan migrate --force

echo "Done."