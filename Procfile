# Procfile for Railway
# This file defines process types for your application
# 
# To use this, create separate Railway services:
# 1. Web service: uses the nixpacks.toml start command
# 2. Worker service: set start command to "bash railway/run-worker.sh"
# 3. Cron service: set start command to "bash railway/run-cron.sh"

web: php artisan serve --host=0.0.0.0 --port=$PORT
worker: bash railway/run-worker.sh
cron: bash railway/run-cron.sh
