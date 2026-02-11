#!/usr/bin/env sh
set -e

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

# Wait for database to be ready (retry up to 30 times with 2s delay = 60s max)
if [ "${DB_CONNECTION}" != "sqlite" ]; then
  echo "Waiting for database connection..."
  MAX_RETRIES=30
  RETRY_COUNT=0
  until php artisan db:monitor --databases="${DB_CONNECTION:-mysql}" > /dev/null 2>&1 || php -r "
    \$host = getenv('DB_HOST') ?: '127.0.0.1';
    \$port = getenv('DB_PORT') ?: '3306';
    \$conn = @fsockopen(\$host, \$port, \$errno, \$errstr, 5);
    if (\$conn) { fclose(\$conn); exit(0); }
    exit(1);
  "; do
    RETRY_COUNT=$((RETRY_COUNT + 1))
    if [ "$RETRY_COUNT" -ge "$MAX_RETRIES" ]; then
      echo "ERROR: Could not connect to database after ${MAX_RETRIES} attempts. Starting without migrations."
      break
    fi
    echo "Database not ready yet (attempt ${RETRY_COUNT}/${MAX_RETRIES}). Retrying in 2s..."
    sleep 2
  done
  echo "Database connection established."
fi

# Run migrations
php artisan migrate --force || echo "WARNING: Migration failed, continuing startup..."

# Cache config for performance (clear first to ensure fresh config)
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ -n "${ADMIN_EMAIL}" ] && [ -n "${ADMIN_PASSWORD}" ]; then
  php artisan user:create-admin "${ADMIN_EMAIL}" --name="${ADMIN_NAME:-Admin}" --password="${ADMIN_PASSWORD}"
fi

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
