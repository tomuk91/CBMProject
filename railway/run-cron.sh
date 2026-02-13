#!/bin/bash
# Laravel Scheduler optimized for Railway
# Make sure this file has executable permissions

# Exit on error
set -e

# Log timezone and startup
echo "[$(date)] Starting Laravel Scheduler"
echo "[$(date)] Timezone: $(date +%Z)"

# Run the Laravel scheduler every minute
while true
do
    echo "[$(date)] Running scheduler..."
    php artisan schedule:run --verbose --no-interaction 2>&1
    
    # Log completion
    echo "[$(date)] Scheduler cycle completed. Sleeping for 60 seconds..."
    
    sleep 60
done
