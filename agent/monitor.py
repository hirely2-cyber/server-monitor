#!/usr/bin/env python3
"""
Server Monitoring Agent
Sends system metrics to the monitoring dashboard API

Installation:
    pip install psutil requests

Usage:
    python monitor.py --token YOUR_API_TOKEN --url https://your-domain.com/api
"""

import psutil
import requests
import time
import argparse
import json
import sys
from datetime import datetime

class ServerMonitor:
    def __init__(self, api_url, api_token, interval=60):
        self.api_url = api_url.rstrip('/')
        self.api_token = api_token
        self.interval = interval
        self.headers = {
            'Authorization': f'Bearer {api_token}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }

    def get_metrics(self):
        """Collect system metrics"""
        try:
            # CPU Usage
            cpu_percent = psutil.cpu_percent(interval=1)
            
            # Memory Usage
            memory = psutil.virtual_memory()
            memory_percent = memory.percent
            memory_total = memory.total
            memory_used = memory.used
            
            # Disk Usage (root partition)
            disk = psutil.disk_usage('/')
            disk_percent = disk.percent
            disk_total = disk.total
            disk_used = disk.used
            
            # Network Statistics
            net_io = psutil.net_io_counters()
            network_in = net_io.bytes_recv
            network_out = net_io.bytes_sent
            
            # Load Average (Unix-like systems)
            try:
                load_avg = psutil.getloadavg()
                load_average = f"{load_avg[0]:.2f}, {load_avg[1]:.2f}, {load_avg[2]:.2f}"
            except AttributeError:
                load_average = "N/A"
            
            # System Uptime
            uptime = int(time.time() - psutil.boot_time())
            
            metrics = {
                'cpu_usage': round(cpu_percent, 2),
                'memory_usage': round(memory_percent, 2),
                'memory_total': memory_total,
                'memory_used': memory_used,
                'disk_usage': round(disk_percent, 2),
                'disk_total': disk_total,
                'disk_used': disk_used,
                'network_in': network_in,
                'network_out': network_out,
                'load_average': load_average,
                'uptime': uptime
            }
            
            return metrics
            
        except Exception as e:
            print(f"Error collecting metrics: {e}")
            return None

    def send_metrics(self, metrics):
        """Send metrics to API"""
        try:
            response = requests.post(
                f'{self.api_url}/metrics',
                headers=self.headers,
                json=metrics,
                timeout=10
            )
            
            if response.status_code == 200:
                data = response.json()
                print(f"[{datetime.now().strftime('%Y-%m-%d %H:%M:%S')}] ✓ Metrics sent successfully to {data.get('server', 'server')}")
                return True
            else:
                print(f"[{datetime.now().strftime('%Y-%m-%d %H:%M:%S')}] ✗ API returned status {response.status_code}: {response.text}")
                return False
                
        except requests.exceptions.RequestException as e:
            print(f"[{datetime.now().strftime('%Y-%m-%d %H:%M:%S')}] ✗ Network error: {e}")
            return False

    def send_heartbeat(self):
        """Send heartbeat ping"""
        try:
            response = requests.post(
                f'{self.api_url}/heartbeat',
                headers=self.headers,
                timeout=5
            )
            
            if response.status_code == 200:
                return True
            return False
                
        except requests.exceptions.RequestException:
            return False

    def get_config(self):
        """Fetch configuration from API"""
        try:
            response = requests.get(
                f'{self.api_url}/config',
                headers=self.headers,
                timeout=5
            )
            
            if response.status_code == 200:
                data = response.json()
                print(f"Connected to: {data['server']['name']}")
                print(f"IP: {data['server']['ip_address']}")
                return data.get('config', {})
            else:
                print(f"Failed to fetch config: {response.status_code}")
                return {}
                
        except requests.exceptions.RequestException as e:
            print(f"Network error: {e}")
            return {}

    def run(self):
        """Main monitoring loop"""
        print(f"Starting Server Monitor Agent")
        print(f"API URL: {self.api_url}")
        print(f"Interval: {self.interval} seconds")
        print("-" * 50)
        
        # Get initial config
        config = self.get_config()
        if config:
            self.interval = config.get('metrics_interval', self.interval)
        
        print(f"\nMonitoring started. Press Ctrl+C to stop.\n")
        
        last_heartbeat = 0
        heartbeat_interval = 30
        
        try:
            while True:
                # Collect and send metrics
                metrics = self.get_metrics()
                if metrics:
                    self.send_metrics(metrics)
                
                # Send periodic heartbeat
                current_time = time.time()
                if current_time - last_heartbeat >= heartbeat_interval:
                    self.send_heartbeat()
                    last_heartbeat = current_time
                
                # Wait for next interval
                time.sleep(self.interval)
                
        except KeyboardInterrupt:
            print("\n\nMonitoring stopped by user.")
            sys.exit(0)
        except Exception as e:
            print(f"\nUnexpected error: {e}")
            sys.exit(1)


def main():
    parser = argparse.ArgumentParser(
        description='Server Monitoring Agent - Sends system metrics to dashboard'
    )
    parser.add_argument(
        '--token',
        required=True,
        help='API Token from dashboard (found in server details)'
    )
    parser.add_argument(
        '--url',
        required=True,
        help='API URL (e.g., https://monitor.example.com/api)'
    )
    parser.add_argument(
        '--interval',
        type=int,
        default=60,
        help='Metrics collection interval in seconds (default: 60)'
    )
    
    args = parser.parse_args()
    
    monitor = ServerMonitor(
        api_url=args.url,
        api_token=args.token,
        interval=args.interval
    )
    
    monitor.run()


if __name__ == '__main__':
    main()
