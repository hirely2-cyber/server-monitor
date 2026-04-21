#!/bin/bash
#
# Server Monitoring Agent - Bash Version
# Sends system metrics to the monitoring dashboard API
#
# Usage:
#   ./monitor.sh YOUR_API_TOKEN https://your-domain.com/api
#
# Install to run every minute via cron:
#   crontab -e
#   * * * * * /path/to/monitor.sh YOUR_TOKEN https://your-domain.com/api >> /var/log/monitor.log 2>&1

# Configuration
API_TOKEN="$1"
API_URL="$2"

if [ -z "$API_TOKEN" ] || [ -z "$API_URL" ]; then
    echo "Usage: $0 <API_TOKEN> <API_URL>"
    echo "Example: $0 abc123... https://monitor.example.com/api"
    exit 1
fi

# Remove trailing slash from URL
API_URL="${API_URL%/}"

# Get CPU usage (average over 1 second)
CPU_USAGE=$(top -bn2 -d 1 | grep "Cpu(s)" | tail -1 | sed "s/.*, *\([0-9.]*\)%* id.*/\1/" | awk '{print 100 - $1}')

# Get Memory usage
MEMORY_INFO=$(free -b | grep Mem)
MEMORY_TOTAL=$(echo $MEMORY_INFO | awk '{print $2}')
MEMORY_USED=$(echo $MEMORY_INFO | awk '{print $3}')
MEMORY_USAGE=$(awk "BEGIN {printf \"%.2f\", ($MEMORY_USED/$MEMORY_TOTAL)*100}")

# Get Disk usage (root partition)
DISK_INFO=$(df -B1 / | tail -1)
DISK_TOTAL=$(echo $DISK_INFO | awk '{print $2}')
DISK_USED=$(echo $DISK_INFO | awk '{print $3}')
DISK_USAGE=$(echo $DISK_INFO | awk '{print $5}' | sed 's/%//')

# Get Network statistics
NETWORK_INFO=$(cat /proc/net/dev | grep -E '(eth0|ens|enp)' | head -1)
NETWORK_IN=$(echo $NETWORK_INFO | awk '{print $2}')
NETWORK_OUT=$(echo $NETWORK_INFO | awk '{print $10}')

# Get Load average
LOAD_AVERAGE=$(uptime | awk -F'load average:' '{print $2}' | xargs)

# Get System uptime (in seconds)
UPTIME=$(cat /proc/uptime | awk '{print int($1)}')

# Build JSON payload
JSON_PAYLOAD=$(cat <<EOF
{
    "cpu_usage": $CPU_USAGE,
    "memory_usage": $MEMORY_USAGE,
    "memory_total": $MEMORY_TOTAL,
    "memory_used": $MEMORY_USED,
    "disk_usage": $DISK_USAGE,
    "disk_total": $DISK_TOTAL,
    "disk_used": $DISK_USED,
    "network_in": $NETWORK_IN,
    "network_out": $NETWORK_OUT,
    "load_average": "$LOAD_AVERAGE",
    "uptime": $UPTIME
}
EOF
)

# Send metrics to API
RESPONSE=$(curl -s -X POST \
    -H "Authorization: Bearer $API_TOKEN" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d "$JSON_PAYLOAD" \
    "$API_URL/metrics")

# Check response
if echo "$RESPONSE" | grep -q '"success":true'; then
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] ✓ Metrics sent successfully"
    exit 0
else
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] ✗ Failed to send metrics"
    echo "$RESPONSE"
    exit 1
fi
