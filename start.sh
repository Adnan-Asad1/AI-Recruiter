#!/bin/bash

# Create SQLite database file if it doesn't exist
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
    echo "SQLite database created."
fi

# Fix permissions
chown www-data:www-data /var/www/html/database/database.sqlite
chmod 664 /var/www/html/database/database.sqlite

# Run Laravel migrations automatically before starting the server
php artisan migrate --force

# Clear and cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the Apache server
apache2-foreground
