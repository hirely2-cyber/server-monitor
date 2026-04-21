<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Services\NotificationService;

class SettingsController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        // Get current settings from cache/config
        $settings = [
            'monitoring' => [
                'check_interval' => config('monitoring.check_interval', 5),
                'alert_threshold_cpu' => config('monitoring.alert_threshold_cpu', 80),
                'alert_threshold_memory' => config('monitoring.alert_threshold_memory', 85),
                'alert_threshold_disk' => config('monitoring.alert_threshold_disk', 90),
                'website_timeout' => config('monitoring.website_timeout', 10),
                'retention_days' => config('monitoring.retention_days', 30),
            ],
            'notifications' => [
                'email_enabled' => config('notifications.email_enabled', false),
                'email_recipients' => config('notifications.email_recipients', ''),
                'slack_enabled' => config('notifications.slack_enabled', false),
                'slack_webhook' => config('notifications.slack_webhook', ''),
                'telegram_enabled' => config('notifications.telegram_enabled', false),
                'telegram_token' => config('notifications.telegram_token', ''),
                'telegram_chat_id' => config('notifications.telegram_chat_id', ''),
            ],
            'system' => [
                'app_name' => config('app.name'),
                'timezone' => config('app.timezone'),
                'debug_mode' => config('app.debug'),
                'cache_driver' => config('cache.default'),
                'queue_driver' => config('queue.default'),
            ],
        ];

        // Get system information
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_size' => $this->getDatabaseSize(),
            'cache_size' => $this->getCacheSize(),
            'storage_used' => $this->getStorageUsed(),
            'queue_jobs' => DB::table('jobs')->count(),
            'failed_jobs' => DB::table('failed_jobs')->count(),
            'cache_driver' => config('cache.default', 'file'),
            'queue_driver' => config('queue.default', 'sync'),
        ];

        return view('settings', compact('settings', 'systemInfo'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'monitoring.check_interval' => 'required|integer|min:1|max:60',
            'monitoring.alert_threshold_cpu' => 'required|integer|min:50|max:100',
            'monitoring.alert_threshold_memory' => 'required|integer|min:50|max:100',
            'monitoring.alert_threshold_disk' => 'required|integer|min:50|max:100',
            'monitoring.website_timeout' => 'required|integer|min:5|max:60',
            'monitoring.retention_days' => 'required|integer|min:7|max:365',
            'notifications.email_enabled' => 'boolean',
            'notifications.email_recipients' => 'nullable|string',
            'notifications.slack_enabled' => 'boolean',
            'notifications.slack_webhook' => 'nullable|url',
            'notifications.telegram_enabled' => 'boolean',
            'notifications.telegram_token' => 'nullable|string',
            'notifications.telegram_chat_id' => 'nullable|string',
        ]);

        // Save settings to cache (in production, you'd save to database or .env)
        foreach ($validated as $key => $value) {
            Cache::forever("settings.{$key}", $value);
        }

        return redirect()->route('settings')
            ->with('success', 'Settings updated successfully.');
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return redirect()->route('settings')
                ->with('success', 'All caches cleared successfully.');
        } catch (\Exception $e) {
            return redirect()->route('settings')
                ->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    public function optimizeSystem()
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            return redirect()->route('settings')
                ->with('success', 'System optimized successfully.');
        } catch (\Exception $e) {
            return redirect()->route('settings')
                ->with('error', 'Failed to optimize system: ' . $e->getMessage());
        }
    }

    public function cleanupOldData()
    {
        try {
            $retentionDays = config('monitoring.retention_days', 30);
            $cutoffDate = now()->subDays($retentionDays);

            // Delete old server metrics
            $deletedMetrics = DB::table('server_metrics')
                ->where('recorded_at', '<', $cutoffDate)
                ->delete();

            // Delete old website checks
            $deletedChecks = DB::table('website_checks')
                ->where('checked_at', '<', $cutoffDate)
                ->delete();

            // Delete old resolved alerts
            $deletedAlerts = DB::table('alerts')
                ->where('is_resolved', true)
                ->where('resolved_at', '<', $cutoffDate)
                ->delete();

            $message = "Cleanup completed: {$deletedMetrics} metrics, {$deletedChecks} checks, and {$deletedAlerts} alerts removed.";

            return redirect()->route('settings')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('settings')
                ->with('error', 'Failed to cleanup data: ' . $e->getMessage());
        }
    }

    public function testNotification(Request $request)
    {
        $type = $request->input('type', 'email');

        try {
            $result = $this->notificationService->sendTestNotification($type);
            
            return response()->json([
                'success' => true,
                'message' => $result['message']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test notification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get database size
     */
    private function getDatabaseSize()
    {
        try {
            $database = config('database.connections.mysql.database');
            $size = DB::selectOne("
                SELECT 
                    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb
                FROM information_schema.tables 
                WHERE table_schema = ?
            ", [$database]);

            return $size->size_mb ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get cache size
     */
    private function getCacheSize()
    {
        try {
            // Estimate cache size (simplified)
            return round(strlen(serialize(Cache::get('*'))) / 1024 / 1024, 2);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get storage used
     */
    private function getStorageUsed()
    {
        try {
            $path = storage_path();
            $size = 0;

            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $file) {
                $size += $file->getSize();
            }

            return round($size / 1024 / 1024, 2);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
