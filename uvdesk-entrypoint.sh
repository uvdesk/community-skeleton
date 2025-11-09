#!/bin/bash
set -e

echo "Starting UVDesk installation process..."

# Increase PHP memory limit for installation
export COMPOSER_MEMORY_LIMIT=-1
export PHP_MEMORY_LIMIT=512M

# Wait for database to be ready
echo "Waiting for database to be ready..."
while ! mysqladmin ping -h"db" -u"uvdesk" -p"uvdesk@2025" --silent; do
    sleep 2
done

echo "Database is ready!"

cd /var/www/html

# Create necessary directories
mkdir -p public/uploads var/cache var/log config/packages

# Step 1: Install UVDesk if not present
if [ ! -f composer.json ]; then
    echo "Installing UVDesk Community..."
    COMPOSER_MEMORY_LIMIT=-1 composer create-project uvdesk/community-skeleton . --stability=dev --no-interaction
fi

# Step 2: Install dependencies
if [ ! -d vendor ]; then
    echo "Installing dependencies..."
    COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction
fi

# Step 3: Set environment to development
echo "Configuring environment..."
if [ -f .env ]; then
    sed -i 's/APP_ENV=prod/APP_ENV=dev/g' .env
else
    echo "APP_ENV=dev" > .env
fi

echo "PHP_MEMORY_LIMIT=512M" >> .env

# Step 4: Create and update database
echo "Creating and updating database..."
php -d memory_limit=512M bin/console doctrine:database:create --if-not-exists --no-interaction
php -d memory_limit=512M bin/console doctrine:schema:update --complete --force --no-interaction
echo "Database schema updated!"

# Step 5: Fix permissions
echo "Setting up file permissions..."
touch .env
touch config/packages/uvdesk.yaml 2>/dev/null || true
touch config/packages/uvdesk_mailbox.yaml 2>/dev/null || true

chmod -R 777 var/ public/uploads/ config/
chmod 777 .env
chown -R www-data:www-data /var/www/html/

# Step 6: Clear cache
echo "Clearing cache..."
php -d memory_limit=512M bin/console cache:clear

echo "UVDesk setup completed successfully! Access via your browser to continue setup."

# Start Apache in foreground
exec apache2-foreground
