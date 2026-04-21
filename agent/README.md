# Server Monitoring Agent

Agent scripts untuk mengirim system metrics dari VPS/Server ke monitoring dashboard.

## 📋 Prerequisites

### Python Agent
- Python 3.6+
- pip packages: `psutil`, `requests`

### Bash Agent
- Linux/Unix system
- curl
- Standard Unix utilities (top, free, df, uptime)

---

## 🐍 Python Agent (Recommended)

### Installation

1. **Install Python dependencies:**
```bash
pip3 install psutil requests
```

2. **Download agent script:**
```bash
wget https://your-domain.com/agent/monitor.py
chmod +x monitor.py
```

3. **Get your API Token:**
   - Login to monitoring dashboard
   - Go to Servers → Click your server
   - Copy the API Token

### Usage

**Run once (testing):**
```bash
python3 monitor.py \
  --token YOUR_API_TOKEN \
  --url https://your-domain.com/api
```

**Run with custom interval:**
```bash
python3 monitor.py \
  --token YOUR_API_TOKEN \
  --url https://your-domain.com/api \
  --interval 30
```

### Run as Systemd Service (Auto-start)

1. **Create service file:**
```bash
sudo nano /etc/systemd/system/server-monitor.service
```

2. **Add configuration:**
```ini
[Unit]
Description=Server Monitoring Agent
After=network.target

[Service]
Type=simple
User=root
WorkingDirectory=/opt/monitoring
ExecStart=/usr/bin/python3 /opt/monitoring/monitor.py \
  --token YOUR_API_TOKEN \
  --url https://your-domain.com/api \
  --interval 60
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
```

3. **Enable and start service:**
```bash
sudo systemctl daemon-reload
sudo systemctl enable server-monitor
sudo systemctl start server-monitor
sudo systemctl status server-monitor
```

4. **View logs:**
```bash
sudo journalctl -u server-monitor -f
```

---

## 🐚 Bash Agent (Alternative)

### Installation

1. **Download script:**
```bash
wget https://your-domain.com/agent/monitor.sh
chmod +x monitor.sh
```

2. **Test run:**
```bash
./monitor.sh YOUR_API_TOKEN https://your-domain.com/api
```

### Setup Cron Job (Run every minute)

1. **Edit crontab:**
```bash
crontab -e
```

2. **Add line:**
```bash
* * * * * /opt/monitoring/monitor.sh YOUR_TOKEN https://your-domain.com/api >> /var/log/monitor.log 2>&1
```

3. **View logs:**
```bash
tail -f /var/log/monitor.log
```

---

## 📊 Metrics Collected

| Metric | Description |
|--------|-------------|
| `cpu_usage` | CPU usage percentage (0-100%) |
| `memory_usage` | Memory usage percentage (0-100%) |
| `memory_total` | Total RAM in bytes |
| `memory_used` | Used RAM in bytes |
| `disk_usage` | Disk usage percentage (0-100%) |
| `disk_total` | Total disk space in bytes |
| `disk_used` | Used disk space in bytes |
| `network_in` | Network bytes received |
| `network_out` | Network bytes sent |
| `load_average` | System load average (1, 5, 15 min) |
| `uptime` | System uptime in seconds |

---

## 🔒 Security

- **API Token** adalah credentials yang sensitive - jangan share!
- Gunakan HTTPS untuk API endpoint
- Store token dengan aman (environment variables atau secure files)
- Rotate token secara berkala dari dashboard

---

## 🛠️ Troubleshooting

### Connection refused
```bash
# Check if API URL is correct
curl -I https://your-domain.com/api/heartbeat

# Check firewall
sudo ufw status
```

### Invalid API token (401)
```bash
# Verify token in dashboard
# Regenerate token if needed
```

### Permission denied
```bash
# Run with sudo or fix permissions
sudo python3 monitor.py --token ... --url ...
```

### Python modules not found
```bash
# Install dependencies
pip3 install --upgrade psutil requests
```

---

## 📝 API Endpoints

### POST /api/metrics
Send server metrics (called every minute by agent)

**Headers:**
```
Authorization: Bearer YOUR_API_TOKEN
Content-Type: application/json
```

**Body:**
```json
{
  "cpu_usage": 45.2,
  "memory_usage": 62.8,
  "memory_total": 8589934592,
  "memory_used": 5395341312,
  "disk_usage": 38.5,
  "disk_total": 107374182400,
  "disk_used": 41343156224,
  "network_in": 1234567890,
  "network_out": 987654321,
  "load_average": "0.52, 0.58, 0.59",
  "uptime": 864000
}
```

**Response:**
```json
{
  "success": true,
  "message": "Metrics received successfully",
  "server": "VPS Singapore 1"
}
```

### POST /api/heartbeat
Simple ping to update last_seen_at

### GET /api/config
Get agent configuration from server

---

## 💡 Tips

1. **Use Python agent** untuk production (lebih reliable dan feature-rich)
2. **Bash script** cocok untuk quick setup atau resource-constrained systems
3. Set interval sesuai kebutuhan: 30s (high-frequency), 60s (balanced), 300s (low-frequency)
4. Monitor agent logs untuk troubleshooting
5. Use systemd service untuk auto-restart jika agent crash

---

## 📞 Support

Jika ada masalah:
1. Check agent logs
2. Verify API token masih valid
3. Test network connectivity ke dashboard
4. Check server status di dashboard

**Happy Monitoring! 🚀**
