# Paperglow — DirectAdmin Production Deployment Guide
## Architecture: Laravel 11 + Blade + Livewire 3 + Alpine.js + Tailwind CSS + MariaDB (PHP 8.3)
### Target Host: Shujaa Host Kenya / DirectAdmin

This guide details the complete process for deploying Paperglow onto **DirectAdmin** on **Shujaa Host** using **PHP 8.3** and **MariaDB**, with **zero Node.js runtime** in production.

---

## 1. Architecture Overview

- **Backend:** Laravel 11 running on PHP 8.3 (FastCGI / PHP-FPM)
- **Server-Side UI:** Blade Templates
- **Interactive UI:** Livewire 3 + Alpine.js
- **Styling:** Tailwind CSS
- **Database:** MariaDB 10.6+ (Native DirectAdmin MySQL Management)
- **Web Server:** Apache / LiteSpeed (Configured via `public/.htaccess`)
- **Node.js in Production:** None

---

## 2. Production `.env` File

Place this file at `/home/<user>/domains/paperglow.co.ke/app/.env`:

```ini
APP_NAME=Paperglow
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://paperglow.co.ke
APP_TIMEZONE=Africa/Nairobi

# MariaDB Connection (Created in DirectAdmin)
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=papergl1_paperglow
DB_USERNAME=papergl1_paperglow
DB_PASSWORD=YOUR_STRONG_PASSWORD_HERE
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

---

## 3. SSH Terminal Deployment Commands

Run these commands in order from your SSH terminal on DirectAdmin / Shujaa Host:

```bash
# 1. Navigate to domain directory
cd /home/<user>/domains/paperglow.co.ke

# 2. Clone repository into 'app' folder (or pull updates)
git clone https://github.com/Khisa-manu/paperglow.git app
cd app

# 3. Copy production environment file and edit credentials
cp .env.example .env
nano .env

# 4. Install PHP dependencies with Composer (Optimized, no dev dependencies)
composer install --no-dev --optimize-autoloader

# 5. Generate application encryption key
php artisan key:generate --force

# 6. Execute MariaDB database migrations
php artisan migrate --force

# 7. Seed initial Paperglow Chamas, Clinics, Schools, Admin
php artisan db:seed --force

# 8. Cache Laravel config, routes, and views for lightning-fast PHP 8.3 response
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Set proper folder permissions for DirectAdmin web user
chmod -R 775 storage bootstrap/cache

# 10. Link public_html to app/public (Run once)
cd /home/<user>/domains/paperglow.co.ke
rm -rf public_html
ln -s app/public public_html
```

---

## 4. Apache & LiteSpeed Web Server Configuration (`public/.htaccess`)

The `public/.htaccess` file already provided in the repository contains:
- Automatic 301 redirect to HTTPS on `paperglow.co.ke`
- Front controller routing (`RewriteRule ^ index.php [L]`)
- Authorization headers for Livewire 3
- Protection against accessing hidden files (`.env`, `.git`)
- GZIP/Brotli caching for static images, SVGs, and fonts

No PM2, reverse-proxy (`mod_proxy`), or port 3000 rules are required!
