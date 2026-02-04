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

if [ -n "${ADMIN_EMAIL}" ] && [ -n "${ADMIN_PASSWORD}" ]; then
  php artisan user:create-admin "${ADMIN_EMAIL}" --name="${ADMIN_NAME:-Admin}" --password="${ADMIN_PASSWORD}"
fi

exec apache2-foreground
