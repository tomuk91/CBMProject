#!/bin/bash
# Queue worker optimized for Railway
# Make sure this file has executable permissions

# Run with restart limits to prevent memory leaks
# --verbose: Output detailed logs to stdout for Railway
# --tries=3: Retry failed jobs 3 times
# --timeout=90: Max 90 seconds per job
# --sleep=3: Sleep 3 seconds when queue is empty (reduces database polling)
# --max-time=3600: Restart worker after 1 hour (prevents memory accumulation)

php artisan queue:work \
  --verbose \
  --tries=3 \
  --timeout=90 \
  --sleep=3 \
  --max-time=3600 \
  2>&1
