<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Website;
use App\Models\ServerMetric;
use App\Models\WebsiteCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        // Get all servers with their latest metrics
        $servers = Server::with(['latestMetric', 'alerts' => function ($query) {
            $query->where('is_resolved', false)
                  ->orderBy('created_at', 'desc');
        }])->get();

        // Get all websites with their latest checks
        $websites = Website::with(['latestCheck', 'alerts' => function ($query) {
            $query->where('is_resolved', false)
                  ->orderBy('created_at', 'desc');
        }])->get();

        // Get statistics
        $stats = [
            'servers' => [
                'total' => $servers->count(),
                'online' => $servers->where('status', 'online')->count(),
                'warning' => $servers->where('status', 'warning')->count(),
                'offline' => $servers->where('status', 'offline')->count(),
            ],
            'websites' => [
                'total' => $websites->count(),
                'up' => $websites->where('status', 'up')->count(),
                'slow' => $websites->where('status', 'slow')->count(),
                'down' => $websites->where('status', 'down')->count(),
            ],
        ];

        return view('monitoring', compact('servers', 'websites', 'stats'));
    }

    /**
     * Get real-time metrics for AJAX updates
     */
    public function getMetrics()
    {
        $servers = Server::with('latestMetric')
            ->get()
            ->map(function ($server) {
                $metric = $server->latestMetric;
                return [
                    'id' => $server->id,
                    'name' => $server->name,
                    'status' => $server->status,
                    'cpu' => $metric ? round($metric->cpu_usage, 1) : 0,
                    'memory' => $metric ? round($metric->memory_usage, 1) : 0,
                    'disk' => $metric ? round($metric->disk_usage, 1) : 0,
                    'last_seen' => $server->last_seen_at ? $server->last_seen_at->diffForHumans() : 'Never',
                ];
            });

        return response()->json($servers);
    }

    /**
     * Get server details
     */
    public function serverDetails($id)
    {
        $server = Server::with(['latestMetric', 'alerts' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }])->findOrFail($id);

        // Get metrics history (last 24 hours)
        $metricsHistory = ServerMetric::where('server_id', $id)
            ->where('recorded_at', '>=', now()->subHours(24))
            ->orderBy('recorded_at', 'asc')
            ->get()
            ->map(function ($metric) {
                return [
                    'time' => $metric->recorded_at->format('H:i'),
                    'cpu' => round($metric->cpu_usage, 1),
                    'memory' => round($metric->memory_usage, 1),
                    'disk' => round($metric->disk_usage, 1),
                ];
            });

        return response()->json([
            'server' => $server,
            'history' => $metricsHistory,
        ]);
    }

    /**
     * Get website details
     */
    public function websiteDetails($id)
    {
        $website = Website::with(['latestCheck', 'alerts' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }])->findOrFail($id);

        // Get check history (last 24 hours)
        $checkHistory = WebsiteCheck::where('website_id', $id)
            ->where('checked_at', '>=', now()->subHours(24))
            ->orderBy('checked_at', 'asc')
            ->get()
            ->map(function ($check) {
                return [
                    'time' => $check->checked_at->format('H:i'),
                    'status' => $check->status,
                    'response_time' => $check->response_time,
                    'http_code' => $check->http_code,
                ];
            });

        return response()->json([
            'website' => $website,
            'history' => $checkHistory,
        ]);
    }
}
