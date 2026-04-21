# Telegram Bot Setup Guide

## 📱 Cara Setup Telegram Bot untuk Notifikasi

### Step 1: Buat Telegram Bot
1. Buka Telegram dan cari **@BotFather**
2. Kirim command `/newbot`
3. Ikuti instruksi untuk memberi nama bot
4. BotFather akan memberikan **Bot Token** seperti:
   ```
   123456789:ABCdefGHIjklMNOpqrsTUVwxyz1234567890
   ```
5. **SIMPAN TOKEN INI!** Akan digunakan di `.env`

### Step 2: Dapatkan Chat ID

#### Option A: Menggunakan Bot sendiri (untuk personal notification)
1. Cari bot Anda di Telegram (username yang dibuat tadi)
2. Klik **Start** atau kirim pesan `/start`
3. Buka URL berikut di browser (ganti `YOUR_BOT_TOKEN`):
   ```
   https://api.telegram.org/botYOUR_BOT_TOKEN/getUpdates
   ```
4. Cari `"chat":{"id":` dalam response
5. Ambil angka setelah `"id":` (contoh: `123456789`)
6. **SIMPAN CHAT ID INI!**

#### Option B: Menggunakan Group (untuk team notification)
1. Buat Telegram Group
2. Tambahkan bot Anda ke group (invite by username)
3. **PENTING:** Beri admin rights ke bot
4. Kirim pesan `/start` di group
5. Buka URL berikut (ganti `YOUR_BOT_TOKEN`):
   ```
   https://api.telegram.org/botYOUR_BOT_TOKEN/getUpdates
   ```
6. Cari `"chat":{"id":` dalam response (biasanya angka negatif untuk group)
7. Ambil angka termasuk minus (contoh: `-1001234567890`)
8. **SIMPAN CHAT ID INI!**

### Step 3: Konfigurasi Laravel

1. Buka file `.env` di project Anda
2. Tambahkan konfigurasi berikut:
   ```env
   NOTIFICATIONS_TELEGRAM_ENABLED=true
   TELEGRAM_BOT_TOKEN=123456789:ABCdefGHIjklMNOpqrsTUVwxyz1234567890
   TELEGRAM_CHAT_ID=123456789
   ```

3. **Jika menggunakan group, chat_id harus dengan minus:**
   ```env
   TELEGRAM_CHAT_ID=-1001234567890
   ```

### Step 4: Test Notification

1. Login ke aplikasi Server Monitor
2. Pergi ke **Settings** page
3. Scroll ke section **Telegram Notifications**
4. Toggle **Enable** switch
5. Paste **Bot Token** dan **Chat ID** yang sudah didapat
6. Klik tombol **Save Settings**
7. Klik tombol **Test Telegram Notification**
8. Cek Telegram, Anda harus menerima pesan test! 🎉

---

## ⚙️ Konfigurasi Lanjutan

### Mengatur Severity Level
Edit file `config/notifications.php`:
```php
'notify_on_severity' => ['critical', 'warning'], // Hanya kirim untuk critical & warning
```

### Mengatur Throttle (Anti-Spam)
```php
'throttle_minutes' => 30, // Kirim max 1 notif per 30 menit untuk issue yang sama
```

---

## 🔧 Troubleshooting

### Error: "Telegram bot token or chat ID is not configured"
- Pastikan `.env` sudah di-update dengan benar
- Jalankan `php artisan config:clear`
- Restart queue worker jika menggunakan queue

### Error: "Bad Request: chat not found"
- Chat ID salah atau bot belum di-start
- Untuk personal: Klik Start di bot Anda
- Untuk group: Pastikan bot sudah di-invite dan diberi admin rights

### Error: "Unauthorized"
- Bot Token salah
- Double check token dari BotFather

### Tidak menerima notifikasi otomatis
- Pastikan `NOTIFICATIONS_TELEGRAM_ENABLED=true` di `.env`
- Jalankan `php artisan config:clear`
- Cek log di `storage/logs/laravel.log`
- Pastikan queue worker berjalan: `php artisan queue:work`

---

## 📝 Format Notifikasi

Notifikasi yang dikirim akan berformat:
```
🔴 CRITICAL Alert

Type: Server Down
Message: Server web-server-1 is not responding
Resource: Server - web-server-1

Created: 2026-04-21 15:30:45
```

Emoji berdasarkan severity:
- 🔴 Critical
- ⚠️ Warning
- ℹ️ Info

---

## 🎯 Tips

1. **Gunakan Group untuk Team**: Semua anggota team bisa menerima notifikasi
2. **Set Bot as Admin**: Agar bot bisa kirim pesan tanpa batasan
3. **Test Dulu**: Selalu test notifikasi sebelum production
4. **Monitor Logs**: Cek `storage/logs/laravel.log` untuk debug issues

---

**Need Help?** Check Laravel documentation atau hubungi developer! 🚀
