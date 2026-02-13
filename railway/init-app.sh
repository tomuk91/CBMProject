#!/bin/bash
# Laravel initialization script for Railway deployments
# Make sure this file has executable permissions

# Exit the script if any command fails
set -e

echo "[$(date)] Starting application initialization..."

# Run migrations
echo "[$(date)] Running database migrations..."
php artisan migrate --force --isolated 2>&1

# Clear all caches
echo "[$(date)] Clearing caches..."
php artisan optimize:clear 2>&1

# Cache the various components of the Laravel application
echo "[$(date)] Caching configuration..."
php artisan config:cache 2>&1

echo "[$(date)] Caching events..."
php artisan event:cache 2>&1

echo "[$(date)] Caching routes..."
php artisan route:cache 2>&1

echo "[$(date)] Caching views..."
php artisan view:cache 2>&1

# Create storage link if it doesn't exist
if [ ! -L public/storage ]; then
    echo "[$(date)] Creating storage link..."
    php artisan storage:link 2>&1
fi

echo "[$(date)] Application initialization completed successfully!"
