#!/bin/bash

# Create SQLite database file if it doesn't exist
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
    echo "SQLite database created."
fi

# Fix permissions
chown www-data:www-data /var/www/html/database/database.sqlite
chmod 664 /var/www/html/database/database.sqlite

# Clear any stale cached config (important on Render)
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run Laravel migrations automatically before starting the server
php artisan migrate --force

# Start the Apache server
apache2-foreground

