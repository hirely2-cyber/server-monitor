<?php

namespace Database\Seeders;

use App\Models\Server;
use App\Models\Website;
use App\Models\ServerMetric;
use App\Models\WebsiteCheck;
use App\Models\Alert;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MonitoringSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 servers
        $servers = [
            [
                'name' => 'VPS Singapore 1',
                'hostname' => 'sg1.example.com',
                'ip_address' => '103.28.36.10',
                'location' => 'Singapore',
                'provider' => 'DigitalOcean',
                'os' => 'Ubuntu 22.04 LTS',
                'status' => 'online',
                'last_seen_at' => now(),
            ],
            [
                'name' => 'VPS USA East',
                'hostname' => 'us-east.example.com',
                'ip_address' => '198.51.100.45',
                'location' => 'New York, USA',
                'provider' => 'Linode',
                'os' => 'Ubuntu 22.04 LTS',
                'status' => 'online',
                'last_seen_at' => now()->subMinutes(2),
            ],
            [
                'name' => 'VPS Europe',
                'hostname' => 'eu1.example.com',
                'ip_address' => '185.125.190.75',
                'location' => 'Frankfurt, Germany',
                'provider' => 'Hetzner',
                'os' => 'Debian 11',
                'status' => 'warning',
                'last_seen_at' => now()->subMinutes(5),
            ],
            [
                'name' => 'VPS Jakarta',
                'hostname' => 'jkt1.example.com',
                'ip_address' => '202.152.180.25',
                'location' => 'Jakarta, Indonesia',
                'provider' => 'IDCloudHost',
                'os' => 'Ubuntu 20.04 LTS',
                'status' => 'online',
                'last_seen_at' => now()->subSeconds(30),
            ],
            [
                'name' => 'VPS Australia',
                'hostname' => 'au1.example.com',
                'ip_address' => '203.45.128.90',
                'location' => 'Sydney, Australia',
                'provider' => 'Vultr',
                'os' => 'CentOS 8',
                'status' => 'offline',
                'last_seen_at' => now()->subHours(2),
            ],
        ];

        foreach ($servers as $serverData) {
            $server = Server::create($serverData);

            // Create latest metrics for each server
            if ($server->status !== 'offline') {
                ServerMetric::create([
                    'server_id' => $server->id,
                    'cpu_usage' => rand(10, 85),
                    'memory_usage' => rand(30, 90),
                    'memory_total' => rand(2048, 16384),
                    'memory_used' => rand(1024, 8192),
                    'disk_usage' => rand(20, 95),
                    'disk_total' => rand(50, 500),
                    'disk_used' => rand(10, 400),
                    'network_in' => rand(100, 5000) / 100,
                    'network_out' => rand(100, 5000) / 100,
                    'load_average' => rand(5, 30) / 10 . ', ' . rand(5, 30) / 10 . ', ' . rand(5, 30) / 10,
                    'uptime' => rand(86400, 2592000),
                    'recorded_at' => now(),
                ]);

                // Create historical metrics (last 10 records)
                for ($i = 1; $i <= 10; $i++) {
                    ServerMetric::create([
                        'server_id' => $server->id,
                        'cpu_usage' => rand(10, 80),
                        'memory_usage' => rand(30, 85),
                        'memory_total' => rand(2048, 16384),
                        'memory_used' => rand(1024, 8192),
                        'disk_usage' => rand(20, 90),
                        'disk_total' => rand(50, 500),
                        'disk_used' => rand(10, 400),
                        'network_in' => rand(100, 5000) / 100,
                        'network_out' => rand(100, 5000) / 100,
                        'load_average' => rand(5, 30) / 10 . ', ' . rand(5, 30) / 10 . ', ' . rand(5, 30) / 10,
                        'uptime' => rand(86400, 2592000),
                        'recorded_at' => now()->subMinutes($i * 5),
                    ]);
                }
            }
        }

        // Create websites for each server
        $websiteTemplates = [
            ['name' => 'Toko Online', 'type' => 'laravel', 'url_pattern' => 'shop'],
            ['name' => 'Blog Perusahaan', 'type' => 'wordpress', 'url_pattern' => 'blog'],
            ['name' => 'Landing Page', 'type' => 'static', 'url_pattern' => 'landing'],
            ['name' => 'Portal Berita', 'type' => 'laravel', 'url_pattern' => 'news'],
            ['name' => 'API Gateway', 'type' => 'laravel', 'url_pattern' => 'api'],
        ];

        $statuses = ['up', 'up', 'up', 'up', 'down', 'slow'];

        foreach (Server::where('status', '!=', 'offline')->get() as $server) {
            $numWebsites = rand(2, 4);
            foreach (array_slice($websiteTemplates, 0, $numWebsites) as $template) {
                $status = $statuses[array_rand($statuses)];
                $website = Website::create([
                    'server_id' => $server->id,
                    'name' => $template['name'],
                    'url' => 'https://' . $template['url_pattern'] . '.' . strtolower(str_replace(' ', '', $server->location)) . '.example.com',
                    'type' => $template['type'],
                    'document_root' => '/var/www/' . $template['url_pattern'],
                    'status' => $status,
                    'http_status' => $status === 'down' ? 503 : 200,
                    'response_time' => $status === 'slow' ? rand(3000, 5000) : rand(100, 800),
                    'ssl_expiry_date' => now()->addDays(rand(30, 365)),
                    'last_checked_at' => now()->subMinutes(rand(1, 5)),
                ]);

                // Create check history
                for ($i = 0; $i < 5; $i++) {
                    WebsiteCheck::create([
                        'website_id' => $website->id,
                        'status' => $i === 0 && $status === 'down' ? 'down' : 'up',
                        'http_status' => $i === 0 && $status === 'down' ? 503 : 200,
                        'response_time' => rand(100, 1500),
                        'checked_at' => now()->subMinutes($i * 10),
                    ]);
                }
            }
        }

        // Create alerts
        $alertTypes = [
            ['type' => 'high_cpu', 'severity' => 'warning', 'message' => 'CPU usage above 80%'],
            ['type' => 'high_memory', 'severity' => 'critical', 'message' => 'Memory usage critical: 95%'],
            ['type' => 'disk_full', 'severity' => 'critical', 'message' => 'Disk space running low: 92%'],
            ['type' => 'website_down', 'severity' => 'critical', 'message' => 'Website is unreachable'],
            ['type' => 'ssl_expiring', 'severity' => 'warning', 'message' => 'SSL certificate expires in 15 days'],
        ];

        // Server alerts
        foreach (Server::where('status', 'warning')->get() as $server) {
            Alert::create([
                'alertable_type' => Server::class,
                'alertable_id' => $server->id,
                'type' => 'high_memory',
                'severity' => 'warning',
                'message' => 'High memory usage detected on ' . $server->name,
                'is_resolved' => false,
            ]);
        }

        // Website alerts
        foreach (Website::where('status', 'down')->get() as $website) {
            Alert::create([
                'alertable_type' => Website::class,
                'alertable_id' => $website->id,
                'type' => 'website_down',
                'severity' => 'critical',
                'message' => $website->name . ' is currently unreachable',
                'is_resolved' => false,
            ]);
        }
    }
}
