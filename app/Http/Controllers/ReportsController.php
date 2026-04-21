<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Website;
use App\Models\ServerMetric;
use App\Models\WebsiteCheck;
use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request or default to last 30 days
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $reportType = $request->input('report_type', 'overview');

        // Overview statistics
        $stats = [
            'servers' => [
                'total' => Server::count(),
                'online' => Server::where('status', 'online')->count(),
                'offline' => Server::where('status', 'offline')->count(),
            ],
            'websites' => [
                'total' => Website::count(),
                'up' => Website::where('status', 'up')->count(),
                'down' => Website::where('status', 'down')->count(),
            ],
            'alerts' => [
                'total' => Alert::whereBetween('created_at', [$startDate, $endDate])->count(),
                'critical' => Alert::whereBetween('created_at', [$startDate, $endDate])
                    ->where('severity', 'critical')->count(),
                'resolved' => Alert::whereBetween('created_at', [$startDate, $endDate])
                    ->where('is_resolved', true)->count(),
            ],
            'metrics' => [
                'avg_cpu' => round(ServerMetric::whereBetween('recorded_at', [$startDate, $endDate])
                    ->avg('cpu_usage') ?? 0, 1),
                'avg_memory' => round(ServerMetric::whereBetween('recorded_at', [$startDate, $endDate])
                    ->avg('memory_usage') ?? 0, 1),
                'avg_response_time' => round(WebsiteCheck::whereBetween('checked_at', [$startDate, $endDate])
                    ->avg('response_time') ?? 0, 0),
            ],
        ];

        // Get daily statistics for charts
        $dailyStats = $this->getDailyStats($startDate, $endDate);

        // Get top issues
        $topIssues = Alert::with(['alertable'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('severity', 'critical')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Server performance report
        $serverPerformance = Server::with(['latestMetric'])
            ->get()
            ->map(function ($server) use ($startDate, $endDate) {
                $metrics = ServerMetric::where('server_id', $server->id)
                    ->whereBetween('recorded_at', [$startDate, $endDate])
                    ->selectRaw('
                        AVG(cpu_usage) as avg_cpu,
                        MAX(cpu_usage) as max_cpu,
                        AVG(memory_usage) as avg_memory,
                        MAX(memory_usage) as max_memory,
                        AVG(disk_usage) as avg_disk
                    ')
                    ->first();

                return [
                    'id' => $server->id,
                    'name' => $server->name,
                    'ip' => $server->ip_address,
                    'status' => $server->status,
                    'avg_cpu' => round($metrics->avg_cpu ?? 0, 1),
                    'max_cpu' => round($metrics->max_cpu ?? 0, 1),
                    'avg_memory' => round($metrics->avg_memory ?? 0, 1),
                    'max_memory' => round($metrics->max_memory ?? 0, 1),
                    'avg_disk' => round($metrics->avg_disk ?? 0, 1),
                ];
            });

        // Website uptime report
        $websiteUptime = Website::get()
            ->map(function ($website) use ($startDate, $endDate) {
                $checks = WebsiteCheck::where('website_id', $website->id)
                    ->whereBetween('checked_at', [$startDate, $endDate])
                    ->get();

                $totalChecks = $checks->count();
                $successfulChecks = $checks->where('is_up', true)->count();
                $uptime = $totalChecks > 0 ? ($successfulChecks / $totalChecks) * 100 : 0;

                return [
                    'id' => $website->id,
                    'name' => $website->name,
                    'url' => $website->url,
                    'status' => $website->status,
                    'uptime' => round($uptime, 2),
                    'total_checks' => $totalChecks,
                    'successful_checks' => $successfulChecks,
                    'failed_checks' => $totalChecks - $successfulChecks,
                    'avg_response_time' => round($checks->avg('response_time') ?? 0, 0),
                ];
            });

        return view('reports', compact(
            'stats',
            'dailyStats',
            'topIssues',
            'serverPerformance',
            'websiteUptime',
            'startDate',
            'endDate',
            'reportType'
        ));
    }

    /**
     * Get daily statistics for charts
     */
    private function getDailyStats($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        $days = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            
            $days[] = [
                'date' => $date->format('M d'),
                'alerts' => Alert::whereDate('created_at', $dateStr)->count(),
                'critical_alerts' => Alert::whereDate('created_at', $dateStr)
                    ->where('severity', 'critical')->count(),
                'avg_cpu' => round(ServerMetric::whereDate('recorded_at', $dateStr)
                    ->avg('cpu_usage') ?? 0, 1),
                'avg_memory' => round(ServerMetric::whereDate('recorded_at', $dateStr)
                    ->avg('memory_usage') ?? 0, 1),
            ];
        }

        return $days;
    }

    /**
     * Export report as CSV
     */
    public function export(Request $request)
    {
        $type = $request->input('type', 'servers');
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $filename = "{$type}_report_" . now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($type, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            if ($type === 'servers') {
                fputcsv($file, ['Server Name', 'IP Address', 'Status', 'Avg CPU %', 'Max CPU %', 'Avg Memory %', 'Max Memory %', 'Avg Disk %']);
                
                Server::with(['latestMetric'])->chunk(100, function ($servers) use ($file, $startDate, $endDate) {
                    foreach ($servers as $server) {
                        $metrics = ServerMetric::where('server_id', $server->id)
                            ->whereBetween('recorded_at', [$startDate, $endDate])
                            ->selectRaw('AVG(cpu_usage) as avg_cpu, MAX(cpu_usage) as max_cpu, AVG(memory_usage) as avg_memory, MAX(memory_usage) as max_memory, AVG(disk_usage) as avg_disk')
                            ->first();

                        fputcsv($file, [
                            $server->name,
                            $server->ip_address,
                            $server->status,
                            round($metrics->avg_cpu ?? 0, 1),
                            round($metrics->max_cpu ?? 0, 1),
                            round($metrics->avg_memory ?? 0, 1),
                            round($metrics->max_memory ?? 0, 1),
                            round($metrics->avg_disk ?? 0, 1),
                        ]);
                    }
                });
            } elseif ($type === 'websites') {
                fputcsv($file, ['Website Name', 'URL', 'Status', 'Uptime %', 'Total Checks', 'Successful', 'Failed', 'Avg Response Time (ms)']);
                
                Website::chunk(100, function ($websites) use ($file, $startDate, $endDate) {
                    foreach ($websites as $website) {
                        $checks = WebsiteCheck::where('website_id', $website->id)
                            ->whereBetween('checked_at', [$startDate, $endDate])
                            ->get();

                        $totalChecks = $checks->count();
                        $successfulChecks = $checks->where('is_up', true)->count();
                        $uptime = $totalChecks > 0 ? ($successfulChecks / $totalChecks) * 100 : 0;

                        fputcsv($file, [
                            $website->name,
                            $website->url,
                            $website->status,
                            round($uptime, 2),
                            $totalChecks,
                            $successfulChecks,
                            $totalChecks - $successfulChecks,
                            round($checks->avg('response_time') ?? 0, 0),
                        ]);
                    }
                });
            } elseif ($type === 'alerts') {
                fputcsv($file, ['Date', 'Severity', 'Type', 'Message', 'Resource', 'Resolved', 'Created At']);
                
                Alert::with(['alertable'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at', 'desc')
                    ->chunk(100, function ($alerts) use ($file) {
                        foreach ($alerts as $alert) {
                            fputcsv($file, [
                                $alert->created_at->format('Y-m-d'),
                                $alert->severity,
                                $alert->type,
                                $alert->message,
                                $alert->alertable ? get_class($alert->alertable) . ' #' . $alert->alertable->id : 'N/A',
                                $alert->is_resolved ? 'Yes' : 'No',
                                $alert->created_at->format('Y-m-d H:i:s'),
                            ]);
                        }
                    });
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
