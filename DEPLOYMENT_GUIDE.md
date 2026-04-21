# 🚀 Server Deployment Guide - Server Monitor

## 📋 Requirements

- PHP 8.2 atau lebih tinggi
- MySQL 5.7+ / MariaDB 10.3+
- Composer
- Node.js & NPM (untuk build assets)
- Cron access (untuk scheduled tasks)

---

## ⚙️ Setup Cron Jobs (WAJIB!)

### 1️⃣ Laravel Scheduler

Sistem monitoring ini menggunakan Laravel Scheduler untuk:
- ✅ Check website health setiap menit
- ✅ Check server offline setiap 5 menit
- ✅ Cleanup data lama (sesuai retention settings)

### Option A: Menggunakan aaPanel (Recommended untuk Shared Hosting)

**1. Login ke aaPanel Dashboard**

**2. Masuk ke Menu Cron:**
   - Klik **Cron** di sidebar kiri

**3. Klik tombol "Add Cron"**

**4. Isi form dengan data berikut:**

| Field | Value |
|-------|-------|
| **Cron Name** | Server Monitor Scheduler |
| **Execution Cycle** | **Every minute** atau pilih **Custom** |
| **Custom Cron** | `* * * * *` (jika pilih custom) |
| **Script Type** | **Shell Script** |
| **Script Content** | `cd /www/wwwroot/devgrup.app && /www/server/php/83/bin/php artisan schedule:run >> /dev/null 2>&1` |

**⚠️ PENTING:** 
- Ganti `/www/wwwroot/devgrup.app` dengan path project Anda!
- Ganti `/www/server/php/83/bin/php` sesuai versi PHP Anda (83 = PHP 8.3, 82 = PHP 8.2, dst)

**5. Klik "Save"**

**6. Verifikasi:** Cron akan muncul di list dengan status "Running"

**Screenshot Example:**
```
Name: Server Monitor Scheduler
Cycle: * * * * * (Every minute)
Script: cd /www/wwwroot/devgrup.app && /www/server/php/83/bin/php artisan schedule:run >> /dev/null 2>&1
Status: ✅ Running
```

### Option B: Setup Manual via SSH (VPS/Dedicated Server)

**Setup crontab:**

```bash
crontab -e
```

**Tambahkan baris ini:**

```cron
* * * * * cd /path/to/server-monitor && php artisan schedule:run >> /dev/null 2>&1
```

**Ganti `/path/to/server-monitor` dengan path project Anda!**

Contoh:
```cron
* * * * * cd /var/www/server-monitor && php artisan schedule:run >> /dev/null 2>&1
```

### Verifikasi Cron Sudah Jalan:

```bash
# Cek cron logs
tail -f storage/logs/laravel.log

# Test manual schedule
php artisan schedule:run
```

---

## 🔄 Queue Worker Setup (WAJIB untuk Notifications!)

Queue worker diperlukan untuk:
- ✅ Mengirim notifikasi Telegram/Email/Slack
- ✅ Process background jobs
- ✅ Check website health secara async

### Option A: Using aaPanel (Recommended untuk Shared Hosting)

**Menggunakan Supervisor di aaPanel:**

**1. Install Supervisor dari aaPanel:**
   - Klik **App Store** di sidebar
   - Cari **"Supervisor"**
   - Klik **Install**

**2. Setup Queue Worker:**
   - Buka **App Store** → **Supervisor** → **Settings**
   - Klik **Add Daemon**

**3. Isi form dengan data:**

| Field | Value |
|-------|-------|
| **Name** | `server-monitor-queue` |
| **Run Directory** | `/www/wwwroot/devgrup.app` |
| **Start Command** | `/www/server/php/83/bin/php artisan queue:work database --sleep=3 --tries=3 --max-time=3600` |
| **Processes** | `2` |
| **User** | `www` (atau user aaPanel Anda) |

**⚠️ PENTING:** Sesuaikan `/www/server/php/83/bin/php` dengan versi PHP Anda!

**4. Klik "OK"**

**5. Start daemon:** Toggle switch ke **ON**

**Verifikasi:**
```bash
# Via SSH
supervisorctl status
# Harus muncul: server-monitor-queue  RUNNING
```

### Option B: Using Supervisor Manual (VPS/Dedicated)

**1. Install Supervisor:**

```bash
sudo apt-get install supervisor
```

**2. Buat config file:**

```bash
sudo nano /etc/supervisor/conf.d/server-monitor-worker.conf
```

**3. Paste config ini:**

```ini
[program:server-monitor-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/server-monitor/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/server-monitor/storage/logs/worker.log
stopwaitsecs=3600
```

**Ganti:**
- `/var/www/server-monitor` dengan path project Anda
- `www-data` dengan user web server Anda

**4. Update & start supervisor:**

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start server-monitor-worker:*
```

**5. Check status:**

```bash
sudo supervisorctl status server-monitor-worker:*
```

### Option B: Using systemd

**1. Buat service file:**

```bash
sudo nano /etc/systemd/system/server-monitor-queue.service
```

**2. Paste config:**

```ini
[Unit]
Description=Server Monitor Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/server-monitor/artisan queue:work database --sleep=3 --tries=3

[Install]
WantedBy=multi-user.target
```

**3. Enable & start:**

```bash
sudo systemctl daemon-reload
sudo systemctl enable server-monitor-queue
sudo systemctl start server-monitor-queue
sudo systemctl status server-monitor-queue
```

### Option C: Using screen (Quick & Simple)

**Hanya untuk testing, TIDAK untuk production!**

```bash
screen -dmS queue-worker php artisan queue:work database --sleep=3 --tries=3

# Check status
screen -ls

# Attach to see logs
screen -r queue-worker

# Detach: Ctrl+A then D
```

---

## 📦 Full Deployment Steps

### 1. Clone & Setup Project

```bash
# Clone project
cd /var/www
git clone <repository-url> server-monitor
cd server-monitor

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Set permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 2. Configure Environment

```bash
# Copy .env file
cp .env.example .env
nano .env
```

**Update minimal config:**

```env
APP_NAME="Server Monitor"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=server_monitoring_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

QUEUE_CONNECTION=database

# Telegram (isi setelah setup bot)
NOTIFICATIONS_TELEGRAM_ENABLED=true
TELEGRAM_BOT_TOKEN=your_bot_token_here
TELEGRAM_CHAT_ID=your_chat_id_here
```

### 3. Generate Key & Migrate Database

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed # Optional: seed sample data
```

### 4. Optimize Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 5. Setup Web Server

**Nginx Example:**

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/server-monitor/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**Reload Nginx:**

```bash
sudo nginx -t
sudo systemctl reload nginx
```

### 6. Setup SSL (Optional tapi Recommended)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

---

## 🔍 Monitoring & Troubleshooting

### Check Queue Jobs

```bash
# Check pending jobs
php artisan queue:monitor database

# Check failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all
```

### Check Scheduled Tasks

```bash
# List all scheduled tasks
php artisan schedule:list

# Test schedule manually
php artisan schedule:run
```

### Check Logs

```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Queue worker logs (if using supervisor)
tail -f storage/logs/worker.log

# Nginx error logs
sudo tail -f /var/log/nginx/error.log
```

### Common Issues

**❌ Cron tidak jalan:**
```bash
# Pastikan cron service aktif
sudo systemctl status cron

# Cek cron logs
grep CRON /var/log/syslog
```

**❌ Queue worker mati:**
```bash
# Restart supervisor
sudo supervisorctl restart server-monitor-worker:*

# Atau restart systemd
sudo systemctl restart server-monitor-queue
```

**❌ Permission errors:**
```bash
sudo chown -R www-data:www-data /var/www/server-monitor
sudo chmod -R 775 storage bootstrap/cache
```

---

## 🎯 Checklist Deployment

- [ ] Project di-clone dan dependencies installed
- [ ] `.env` dikonfigurasi dengan benar
- [ ] Database dimigrate
- [ ] Laravel di-optimize (cache config/route/view)
- [ ] Web server (Nginx/Apache) configured
- [ ] **Cron job untuk scheduler sudah di-setup**
- [ ] **Queue worker sudah running (supervisor/systemd)**
- [ ] SSL certificate installed (optional)
- [ ] Telegram bot configured dan di-test
- [ ] Firewall configured (allow HTTP/HTTPS)
- [ ] Storage permissions set correctly

---

## 📝 Maintenance Commands

```bash
# Clear all cache
php artisan optimize:clear

# Rebuild cache
php artisan optimize

# Cleanup old monitoring data
php artisan tinker
>>> \App\Http\Controllers\SettingsController::cleanupOldData()

# Restart queue worker
sudo supervisorctl restart server-monitor-worker:*
```

---

## ⚡ Performance Tips

1. **Enable OPCache** di php.ini:
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
```

2. **Use Redis untuk cache & queue** (optional):
```env
CACHE_STORE=redis
QUEUE_CONNECTION=redis
```

3. **Monitor server resources**:
```bash
# CPU & Memory
htop

# Disk space
df -h

# Queue worker memory
ps aux | grep queue:work
```

---

**Need Help?** Check logs dan dokumentasi Laravel! 🚀
