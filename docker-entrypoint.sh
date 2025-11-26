#!/bin/bash

echo "🚀 Starting deployment tasks..."

# Always run fresh migrations to ensure clean state
echo "📦 Running fresh migrations..."
php artisan migrate:fresh --force

echo "✅ Database ready!"

# Start Apache
echo "🔥 Starting Apache..."
exec apache2-foreground
