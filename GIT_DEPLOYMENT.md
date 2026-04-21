# 🚀 Git Deployment Guide - Server Monitor

Panduan lengkap untuk deploy server monitoring system menggunakan Git workflow dari development ke production server.

---

## 📋 Prerequisites

### Local (Development):
- ✅ Git installed
- ✅ GitHub/GitLab account
- ✅ SSH key setup

### VPS (Production):
- ✅ Git installed
- ✅ aaPanel setup
- ✅ Web server configured
- ✅ MySQL database created
- ✅ PHP 8.2+ installed

---

## 🎯 Workflow Overview

```
Local Dev (Windows) 
    ↓ git push
GitHub/GitLab Repository
    ↓ git pull
Production Server (VPS)
```

---

## 🔧 Setup Git Repository (First Time)

### 1️⃣ Initialize Git di Local

```powershell
# Navigate ke project directory
cd "g:\Laravel Project\WebServer-Monitoring\server-monitor"

# Initialize Git (kalau belum)
git init

# Create .gitignore (jika belum ada)
# File sudah ada di Laravel by default
```

### 2️⃣ Create `.gitignore` (Pastikan sudah ada)

Pastikan file `.gitignore` mencakup:

```gitignore
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log
/.fleet
/.idea
/.vscode
```

**⚠️ PENTING:** `.env` harus di-ignore! Jangan commit credential!

### 3️⃣ Initial Commit

```powershell
# Add all files
git add .

# Commit
git commit -m "Initial commit: Server Monitoring System"
```

### 4️⃣ Create GitHub/GitLab Repository

**Option A: GitHub**
1. Buka https://github.com/new
2. Create repository: `server-monitoring`
3. Jangan centang "Initialize with README" (sudah ada local)
4. Copy HTTPS atau SSH URL

**Option B: GitLab**
1. Buka https://gitlab.com/projects/new
2. Create project: `server-monitoring`
3. Copy HTTPS atau SSH URL

### 5️⃣ Push ke Remote Repository

```powershell
# Add remote (ganti dengan URL kamu!)
git remote add origin https://github.com/username/server-monitoring.git

# atau SSH:
# git remote add origin git@github.com:username/server-monitoring.git

# Push ke remote
git branch -M main
git push -u origin main
```

---

## 🖥️ Setup di Production Server (VPS)

### 1️⃣ SSH ke VPS

```bash
ssh root@your-vps-ip

# atau
ssh username@your-vps-ip -p 22
```

### 2️⃣ Install Git (jika belum ada)

```bash
# Ubuntu/Debian
apt update
apt install git -y

# CentOS/RHEL
yum install git -y
```

### 3️⃣ Generate SSH Key untuk Git (Optional, untuk Private Repo)

```bash
# Generate SSH key
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"

# Copy public key
cat ~/.ssh/id_rsa.pub

# Paste ke GitHub: Settings → SSH Keys → Add SSH Key
# Paste ke GitLab: Preferences → SSH Keys → Add Key
```

### 4️⃣ Clone Repository

```bash
# Navigate ke web directory (aaPanel default)
cd /www/wwwroot

# Clone repository (HTTPS - untuk public repo)
git clone https://github.com/username/server-monitoring.git devgrup.app

# atau SSH (untuk private repo)
# git clone git@github.com:username/server-monitoring.git devgrup.app

# Enter directory
cd devgrup.app
```

### 5️⃣ Setup Environment

```bash
# Copy .env file
cp .env.example .env

# Edit .env dengan credentials production
nano .env
```

**Konfigurasi minimal `.env` production:**

```env
APP_NAME="Server Monitor"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://devgrup.app

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=server_monitoring_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

QUEUE_CONNECTION=database

# Telegram
NOTIFICATIONS_TELEGRAM_ENABLED=true
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_CHAT_ID=your_chat_id
```

### 6️⃣ Install Dependencies

```bash
# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Install NPM dependencies dan build assets
npm install
npm run build

# Set permissions
chown -R www:www /www/wwwroot/devgrup.app
chmod -R 775 storage bootstrap/cache
```

### 7️⃣ Setup Laravel

```bash
# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 🔄 Deployment Workflow (Update Code)

### Local Development

```powershell
# 1. Make changes di local
# ... edit files ...

# 2. Test di local
php artisan serve

# 3. Commit changes
git add .
git commit -m "Add SSH and Panel credentials feature"

# 4. Push ke remote
git push origin main
```

### Production Server (Pull Update)

```bash
# SSH ke VPS
ssh root@your-vps-ip

# Navigate ke project
cd /www/wwwroot/devgrup.app

# Backup current state (optional tapi recommended!)
tar -czf ../backup-$(date +%Y%m%d-%H%M%S).tar.gz .

# Put app in maintenance mode
php artisan down

# Pull latest changes from Git
git pull origin main

# Update dependencies (jika ada perubahan)
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Run new migrations (jika ada)
php artisan migrate --force

# Clear dan rebuild cache
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Set permissions
chown -R www:www /www/wwwroot/devgrup.app
chmod -R 775 storage bootstrap/cache

# Restart queue workers (jika pakai supervisor)
supervisorctl restart server-monitor-queue:*

# Bring app back online
php artisan up
```

---

## 🤖 Automated Deployment Script

Buat script untuk auto-deploy! Lebih cepat dan aman.

### Create `deploy.sh` di VPS:

```bash
nano /www/wwwroot/devgrup.app/deploy.sh
```

**Paste script ini:**

```bash
#!/bin/bash

# Server Monitor - Auto Deploy Script
# Usage: ./deploy.sh

set -e

PROJECT_PATH="/www/wwwroot/devgrup.app"
TIMESTAMP=$(date +%Y%m%d-%H%M%S)
BACKUP_PATH="/www/backup"

echo "🚀 Starting deployment..."

# Navigate to project
cd $PROJECT_PATH

# Create backup
echo "📦 Creating backup..."
mkdir -p $BACKUP_PATH
tar -czf $BACKUP_PATH/backup-$TIMESTAMP.tar.gz .
echo "✓ Backup saved: $BACKUP_PATH/backup-$TIMESTAMP.tar.gz"

# Maintenance mode
echo "🔧 Entering maintenance mode..."
php artisan down

# Pull latest code
echo "⬇️  Pulling latest code from Git..."
git pull origin main

# Install/Update dependencies
echo "📚 Installing dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction
npm install --silent
npm run build

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Clear and cache
echo "🧹 Clearing and rebuilding cache..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Fix permissions
echo "🔐 Setting permissions..."
chown -R www:www $PROJECT_PATH
chmod -R 775 storage bootstrap/cache

# Restart queue workers
echo "♻️  Restarting queue workers..."
if command -v supervisorctl &> /dev/null; then
    supervisorctl restart server-monitor-queue:* || true
fi

# Exit maintenance mode
echo "✅ Bringing application online..."
php artisan up

echo ""
echo "🎉 Deployment completed successfully!"
echo "📅 Timestamp: $TIMESTAMP"
echo "💾 Backup: $BACKUP_PATH/backup-$TIMESTAMP.tar.gz"
echo ""
```

### Make executable:

```bash
chmod +x /www/wwwroot/devgrup.app/deploy.sh
```

### Deploy dengan 1 command:

```bash
cd /www/wwwroot/devgrup.app
./deploy.sh
```

---

## 🔄 Rollback (Kalau Ada Masalah)

### Quick Rollback:

```bash
# Stop app
php artisan down

# Restore dari backup
cd /www/wwwroot
rm -rf devgrup.app
tar -xzf /www/backup/backup-TIMESTAMP.tar.gz -C devgrup.app

# Clear cache
cd devgrup.app
php artisan config:clear
php artisan cache:clear

# Bring back online
php artisan up
```

### Git Rollback:

```bash
# Lihat commit history
git log --oneline

# Rollback ke commit tertentu
git reset --hard COMMIT_HASH

# atau rollback 1 commit
git reset --hard HEAD~1

# Then run deploy
./deploy.sh
```

---

## 🎯 Best Practices

### ✅ DO:
- ✅ Selalu commit dengan message yang jelas
- ✅ Test di local sebelum push
- ✅ Backup database sebelum deploy
- ✅ Gunakan deployment script
- ✅ Monitor logs setelah deploy: `tail -f storage/logs/laravel.log`
- ✅ Test functionality setelah deploy
- ✅ Keep `.env` file secure (jangan commit!)

### ❌ DON'T:
- ❌ Commit file `.env`
- ❌ Push tanpa test
- ❌ Deploy tanpa backup
- ❌ Lupa run migrations
- ❌ Lupa clear cache
- ❌ Deploy di jam sibuk (deploy malam hari!)

---

## 🔍 Troubleshooting

### Issue: Git pull error (conflict)

```bash
# Lihat status
git status

# Option 1: Keep remote (discard local changes)
git reset --hard origin/main

# Option 2: Stash local changes
git stash
git pull origin main
git stash pop
```

### Issue: Permission denied

```bash
chown -R www:www /www/wwwroot/devgrup.app
chmod -R 775 storage bootstrap/cache
```

### Issue: Route not found after deploy

```bash
php artisan route:clear
php artisan route:cache
```

### Issue: Config cached

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 📝 Deployment Checklist

Sebelum deploy, pastikan:

- [ ] All changes committed dan pushed ke Git
- [ ] Test di local environment
- [ ] Backup database di production
- [ ] Backup files di production
- [ ] Check `.env` production sudah benar
- [ ] Run deployment script
- [ ] Test functionality setelah deploy
- [ ] Monitor logs untuk errors
- [ ] Verify queue workers running
- [ ] Test Telegram notifications

---

## 🎓 Git Commands Cheatsheet

```bash
# Status
git status

# Add files
git add .                    # Add semua files
git add filename.php         # Add specific file

# Commit
git commit -m "message"

# Push
git push origin main

# Pull
git pull origin main

# View history
git log --oneline

# View branches
git branch

# Create new branch
git checkout -b feature-name

# Switch branch
git checkout main

# Merge branch
git merge feature-name

# Discard local changes
git reset --hard origin/main
```

---

## 🆘 Need Help?

Kalau ada error saat deploy:

1. Check Laravel logs: `tail -f storage/logs/laravel.log`
2. Check Nginx/Apache logs: `tail -f /var/log/nginx/error.log`
3. Check permissions: `ls -la storage`
4. Verify `.env` config
5. Try manual commands dari deployment script satu-satu

**Good luck! 🚀**
