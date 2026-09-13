#!/bin/bash
set -e

sed -i "s/Listen 80/Listen ${PORT:-8080}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT:-8080}/g" /etc/apache2/sites-available/*.conf

if [ "$#" -eq 0 ]; then
  php artisan migrate --force
  exec apache2-foreground
else
  exec "$@"
fi