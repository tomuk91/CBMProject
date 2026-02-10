#!/usr/bin/env sh
set -e

# Fix Apache MPM conflict
a2dismod mpm_event mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

# Configure Apache to use Railway's PORT variable
if [ -n "${PORT}" ]; then
  echo "Configuring Apache to listen on port ${PORT}"
  sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
  sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf
fi

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

# Always run migrations on Railway
php artisan migrate --force

# Cache config for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ -n "${ADMIN_EMAIL}" ] && [ -n "${ADMIN_PASSWORD}" ]; then
  php artisan user:create-admin "${ADMIN_EMAIL}" --name="${ADMIN_NAME:-Admin}" --password="${ADMIN_PASSWORD}"
fi

exec apache2-foreground
