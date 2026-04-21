<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Models\ServerMetric;
use App\Jobs\ProcessServerMetrics;
use Illuminate\Http\Request;

class MetricsController extends Controller
{
    public function store(Request $request)
    {
        // Validate API token
        $server = $this->authenticateServer($request);
        
        if (!$server) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API token'
            ], 401);
        }

        // Validate incoming data
        $validated = $request->validate([
            'cpu_usage' => 'nullable|numeric|min:0|max:100',
            'memory_usage' => 'nullable|numeric|min:0|max:100',
            'memory_total' => 'nullable|integer|min:0',
            'memory_used' => 'nullable|integer|min:0',
            'disk_usage' => 'nullable|numeric|min:0|max:100',
            'disk_total' => 'nullable|integer|min:0',
            'disk_used' => 'nullable|integer|min:0',
            'network_in' => 'nullable|numeric|min:0',
            'network_out' => 'nullable|numeric|min:0',
            'load_average' => 'nullable|string',
            'uptime' => 'nullable|integer|min:0',
        ]);

        // Create metric record
        $metric = ServerMetric::create([
            'server_id' => $server->id,
            'cpu_usage' => $validated['cpu_usage'] ?? null,
            'memory_usage' => $validated['memory_usage'] ?? null,
            'memory_total' => $validated['memory_total'] ?? null,
            'memory_used' => $validated['memory_used'] ?? null,
            'disk_usage' => $validated['disk_usage'] ?? null,
            'disk_total' => $validated['disk_total'] ?? null,
            'disk_used' => $validated['disk_used'] ?? null,
            'network_in' => $validated['network_in'] ?? null,
            'network_out' => $validated['network_out'] ?? null,
            'load_average' => $validated['load_average'] ?? null,
            'uptime' => $validated['uptime'] ?? null,
            'recorded_at' => now(),
        ]);

        // Update server last_seen_at
        $server->update([
            'last_seen_at' => now(),
        ]);

        // Dispatch job to process metrics and create alerts
        ProcessServerMetrics::dispatch($server, $metric);

        return response()->json([
            'success' => true,
            'message' => 'Metrics received successfully',
            'server' => $server->name,
        ], 200);
    }

    public function heartbeat(Request $request)
    {
        // Validate API token
        $server = $this->authenticateServer($request);
        
        if (!$server) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API token'
            ], 401);
        }

        // Update last_seen_at
        $server->update([
            'last_seen_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Heartbeat received',
            'server' => $server->name,
            'time' => now()->toIso8601String(),
        ], 200);
    }

    public function config(Request $request)
    {
        // Validate API token
        $server = $this->authenticateServer($request);
        
        if (!$server) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API token'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'server' => [
                'id' => $server->id,
                'name' => $server->name,
                'hostname' => $server->hostname,
                'ip_address' => $server->ip_address,
            ],
            'config' => [
                'metrics_interval' => 60, // seconds
                'heartbeat_interval' => 30, // seconds
                'enable_network_monitoring' => true,
                'enable_disk_monitoring' => true,
            ],
        ], 200);
    }

    /**
     * Authenticate server by API token
     */
    private function authenticateServer(Request $request)
    {
        $token = $request->header('Authorization');
        
        if (!$token || !str_starts_with($token, 'Bearer ')) {
            return null;
        }

        $apiToken = substr($token, 7); // Remove 'Bearer ' prefix
        return Server::where('api_token', $apiToken)->first();
    }
}
