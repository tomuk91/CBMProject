#!/usr/bin/env sh
set -e

if [ "${DB_CONNECTION}" = "sqlite" ]; then
  if [ -z "${DB_DATABASE}" ]; then
    export DB_DATABASE="/var/www/html/database/database.sqlite"
  fi
  if [ ! -f "${DB_DATABASE}" ]; then
    mkdir -p "$(dirname "${DB_DATABASE}")"
    touch "${DB_DATABASE}"
  fi
  chown -R www-data:www-data "$(dirname "${DB_DATABASE}")"
  chmod -R ug+rw "$(dirname "${DB_DATABASE}")"
fi

if [ "${RUN_MIGRATIONS}" = "true" ]; then
  php artisan migrate --force
fi

exec apache2-foreground
