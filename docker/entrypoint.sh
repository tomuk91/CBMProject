#!/usr/bin/env sh
set -e

# Configure Apache to use Railway's PORT (default to 80)
if [ -z "$PORT" ]; then
  export PORT=80
fi

echo "Configuring Apache to listen on port ${PORT}"
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-enabled/*.conf

# Fix Apache MPM conflict
a2dismod mpm_event mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

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

# Cache config for performance (clear first to ensure fresh config)
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ -n "${ADMIN_EMAIL}" ] && [ -n "${ADMIN_PASSWORD}" ]; then
  php artisan user:create-admin "${ADMIN_EMAIL}" --name="${ADMIN_NAME:-Admin}" --password="${ADMIN_PASSWORD}"
fi

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
