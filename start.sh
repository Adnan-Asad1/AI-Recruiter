#!/bin/bash

# Run Laravel migrations automatically before starting the server
php artisan migrate --force

# Clear and cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the Apache server
apache2-foreground
