#!/bin/bash
# Make sure this file has executable permissions

# This command runs the queue worker
# An alternative is to use the php artisan queue:listen command
php artisan queue:work --verbose --tries=3 --timeout=90
