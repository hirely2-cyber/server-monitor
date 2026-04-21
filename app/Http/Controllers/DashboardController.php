<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Website;
use App\Models\Alert;
use App\Models\WebsiteCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalServers = Server::count();
        $activeServers = Server::where('status', 'online')->count();
        $warningServers = Server::where('status', 'warning')->count();
        $offlineServers = Server::where('status', 'offline')->count();
        
        $totalWebsites = Website::count();
        $websitesUp = Website::where('status', 'up')->count();
        $websitesDown = Website::where('status', 'down')->count();
        $websitesSlow = Website::where('status', 'slow')->count();
        
        $activeAlerts = Alert::where('is_resolved', false)->count();
        $criticalAlerts = Alert::where('is_resolved', false)
            ->where('severity', 'critical')
            ->count();

        // Calculate uptime percentage
        $uptimePercentage = $totalServers > 0 ? 
            round(($activeServers / $totalServers) * 100, 1) : 0;

        // Get average metrics across all servers (from latest metrics)
        $avgMetrics = DB::table('server_metrics as sm1')
            ->select(
                DB::raw('AVG(cpu_usage) as avg_cpu'),
                DB::raw('AVG(memory_usage) as avg_memory'),
                DB::raw('AVG(disk_usage) as avg_disk')
            )
            ->whereRaw('recorded_at = (SELECT MAX(recorded_at) FROM server_metrics sm2 WHERE sm2.server_id = sm1.server_id)')
            ->first();

        $avgCpu = $avgMetrics ? round($avgMetrics->avg_cpu, 1) : 0;
        $avgMemory = $avgMetrics ? round($avgMetrics->avg_memory, 1) : 0;
        $avgDisk = $avgMetrics ? round($avgMetrics->avg_disk, 1) : 0;

        // Get total network traffic (sum of latest metrics)
        $totalTraffic = DB::table('server_metrics as sm1')
            ->select(DB::raw('SUM(network_in + network_out) as total'))
            ->whereRaw('recorded_at = (SELECT MAX(recorded_at) FROM server_metrics sm2 WHERE sm2.server_id = sm1.server_id)')
            ->value('total');

        $totalTrafficGB = $totalTraffic ? round($totalTraffic / (1024 * 1024 * 1024), 2) : 0;

        // Get servers with latest metrics
        $servers = Server::with('latestMetric')
            ->orderBy('status')
            ->orderBy('name')
            ->get()
            ->map(function ($server) {
                $metric = $server->latestMetric;
                return [
                    'id' => $server->id,
                    'name' => $server->name,
                    'location' => $server->location,
                    'ip_address' => $server->ip_address,
                    'status' => $server->status,
                    'last_seen' => $server->last_seen_at?->diffForHumans(),
                    'cpu' => $metric?->cpu_usage ?? 0,
                    'memory' => $metric?->memory_usage ?? 0,
                    'disk' => $metric?->disk_usage ?? 0,
                ];
            });

        // Get recent alerts
        $recentAlerts = Alert::with('alertable')
            ->where('is_resolved', false)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($alert) {
                return [
                    'id' => $alert->id,
                    'type' => $alert->type,
                    'severity' => $alert->severity,
                    'message' => $alert->message,
                    'time' => $alert->created_at->diffForHumans(),
                    'source' => $alert->alertable ? 
                        ($alert->alertable instanceof Server ? $alert->alertable->name : $alert->alertable->name) : 
                        'Unknown',
                ];
            });

        // Get recent website checks
        $recentWebsiteChecks = WebsiteCheck::with('website')
            ->orderBy('checked_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($check) {
                return [
                    'id' => $check->id,
                    'website_name' => $check->website->name,
                    'website_url' => $check->website->url,
                    'status' => $check->status,
                    'http_status' => $check->http_status,
                    'response_time' => $check->response_time,
                    'checked_at' => $check->checked_at->diffForHumans(),
                ];
            });

        // Get system health status
        $systemHealth = 'healthy';
        if ($criticalAlerts > 0 || $offlineServers > 0) {
            $systemHealth = 'critical';
        } elseif ($warningServers > 0 || $websitesDown > 0 || $avgCpu > 80 || $avgMemory > 80) {
            $systemHealth = 'warning';
        }

        return view('dashboard', compact(
            'totalServers',
            'activeServers',
            'warningServers',
            'offlineServers',
            'uptimePercentage',
            'totalTrafficGB',
            'activeAlerts',
            'criticalAlerts',
            'servers',
            'recentAlerts',
            'totalWebsites',
            'websitesUp',
            'websitesDown',
            'websitesSlow',
            'recentWebsiteChecks',
            'avgCpu',
            'avgMemory',
            'avgDisk',
            'systemHealth'
        ));
    }
}
