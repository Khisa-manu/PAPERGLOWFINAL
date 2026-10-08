# Paperglow — DirectAdmin & Shujaa Host Production Deployment Guide

## Production Architecture Summary

| Component | Production Stack |
| :--- | :--- |
| **Backend Framework** | **Laravel 11** (PHP 8.3) |
| **Server-Side UI** | **Blade Templates** |
| **Interactive Reactivity** | **Livewire 3** + **Alpine.js** |
| **Styling** | **Tailwind CSS** (Standalone / Production compiled) |
| **Database** | **MariaDB 10.6+ / MySQL 8.0** (InnoDB, utf8mb4) |
| **Hosting Platform** | **DirectAdmin** on **Shujaa Host Kenya** |
| **Web Server** | **Apache / LiteSpeed** with PHP 8.3-FPM |
| **Node.js in Production** | **NONE (0%)** — No PM2, No Express, No Node daemons |

---

## 1. DirectAdmin Setup on Shujaa Host

### Step 1.1: Ensure PHP 8.3 is Selected
1. Log in to your Shujaa Host DirectAdmin Control Panel at `https://paperglow.co.ke:2222` (or your Shujaa server hostname).
2. Go to **Extra Features** &rarr; **Select PHP Version** (or **Domain Setup** &rarr; `paperglow.co.ke` &rarr; **PHP Version Selector**).
3. Select **PHP 8.3** as the primary PHP version.
4. Ensure the following PHP extensions are enabled (standard on Shujaa Host):
   - `pdo_mysql` or `pdo_mariadb`
   - `mbstring`
   - `openssl`
   - `xml` / `dom`
   - `curl`
   - `bcmath`
   - `ctype`
   - `fileinfo`
   - `tokenizer`
   - `zip`
   - `gd` or `imagick`

---

### Step 1.2: Create MariaDB Database & User
1. In DirectAdmin, go to **Account Manager** &rarr; **MySQL Management**.
2. Click **Create New Database**.
3. Enter database details (example):
   - Database Name: `papergl1_paperglow`
   - Database Username: `papergl1_paperglow`
   - Database Password: `<Generate Strong Password>`
4. Note these credentials for your `.env` file.

---

### Step 1.3: Document Root Mapping Options

On DirectAdmin, web traffic for your domain resolves to:
`/home/<user>/domains/paperglow.co.ke/public_html`

Laravel serves public assets and `index.php` from:
`/home/<user>/domains/paperglow.co.ke/app/public`

Choose **Method A (Recommended Symlink)** or **Method B (Subfolder)**:

#### Method A: Clean Symlink (Recommended)
In your SSH terminal on Shujaa Host:
```bash
cd /home/<user>/domains/paperglow.co.ke

# Back up or remove default empty public_html
rm -rf public_html

# Create symbolic link pointing public_html directly to Laravel's public directory
ln -s app/public public_html
```

#### Method B: DirectAdmin Custom HTTPD Configuration
If your DirectAdmin account has Custom HTTPD access:
1. Go to **Server Manager** &rarr; **Custom HTTPD Configurations** &rarr; `paperglow.co.ke`.
2. Change the DocumentRoot to:
   ```apache
   |?DOCROOT=/home/<user>/domains/paperglow.co.ke/app/public|
   ```

---

## 2. SSH Deployment Commands

Log into your Shujaa Host terminal via SSH:

```bash
# 1. Navigate to your domain directory
cd /home/<user>/domains/paperglow.co.ke

# 2. Clone or pull your Paperglow repository into 'app' folder
git clone https://github.com/Khisa-manu/paperglow.git app
cd app

# 3. Create production .env file
cp .env.example .env
nano .env
```

Update your `.env` with your Shujaa Host database credentials:
```ini
APP_NAME=Paperglow
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://paperglow.co.ke

DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=papergl1_paperglow
DB_USERNAME=papergl1_paperglow
DB_PASSWORD=YOUR_DB_PASSWORD_HERE
```

```bash
# 4. Install PHP dependencies via Composer (No dev dependencies)
composer install --no-dev --optimize-autoloader

# 5. Generate secure Laravel encryption key
php artisan key:generate --force

# 6. Run MariaDB migrations
php artisan migrate --force

# 7. Seed initial Paperglow Kenyan Chamas, Clinics, Schools & Admin
php artisan db:seed --force

# 8. Optimize Laravel for maximum production speed (OPcache + Route/Config/View Caching)
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan livewire:publish --assets

# 9. Set correct Linux permissions
chmod -R 775 storage bootstrap/cache
```

---

## 3. DirectAdmin Cron Job (Scheduled Tasks)

To run scheduled automated tasks (such as Chama loan interest calculations, fee balance notifications, and database audits):

1. In DirectAdmin, go to **Advanced Features** &rarr; **Cron Jobs**.
2. Click **Create Cron Job**.
3. Set time to every minute (`* * * * *`).
4. Set command:
   ```bash
   /usr/local/bin/php /home/<user>/domains/paperglow.co.ke/app/artisan schedule:run >> /dev/null 2>&1
   ```
   *(Note: verify your PHP 8.3 CLI binary path via `which php` or `/usr/local/php83/bin/php`)*

---

## 4. Free SSL Certificate (Let's Encrypt)

1. In DirectAdmin, navigate to **Account Manager** &rarr; **SSL Certificates**.
2. Select **Free & automatic certificate from Let's Encrypt**.
3. Check `paperglow.co.ke` and `www.paperglow.co.ke`.
4. Click **Save**.
5. The `public/.htaccess` file automatically forces HTTPS on all requests.

---

## 5. Verifying Zero Node.js in Production

To confirm that no Node.js/Express daemons are needed or running:
1. Check process list in SSH: `ps aux | grep node` (should be empty).
2. Livewire 3 handles all dynamic user interactions over native HTTPS POST requests (`/livewire/update`) to PHP 8.3.
3. Alpine.js runs lightweight client-side reactivity inside the browser without Node.js.
4. MariaDB handles all tenant persistence with standard ACID transactions.
