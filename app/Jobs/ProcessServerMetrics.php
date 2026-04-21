<?php

namespace App\Jobs;

use App\Models\Server;
use App\Models\ServerMetric;
use App\Models\Alert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessServerMetrics implements ShouldQueue
{
    use Queueable;

    public $timeout = 30;
    public $tries = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Server $server,
        public ServerMetric $metric
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check CPU usage
        if ($this->metric->cpu_usage > 90) {
            $this->createOrUpdateAlert(
                'high_cpu',
                'critical',
                "High CPU usage detected on {$this->server->name} ({$this->metric->cpu_usage}%)"
            );
        } elseif ($this->metric->cpu_usage > 70) {
            $this->createOrUpdateAlert(
                'high_cpu',
                'warning',
                "Elevated CPU usage on {$this->server->name} ({$this->metric->cpu_usage}%)"
            );
        } else {
            // Resolve CPU alerts if usage is normal
            $this->resolveAlert('high_cpu');
        }

        // Check Memory usage
        if ($this->metric->memory_usage > 90) {
            $this->createOrUpdateAlert(
                'high_memory',
                'critical',
                "High memory usage detected on {$this->server->name} ({$this->metric->memory_usage}%)"
            );
        } elseif ($this->metric->memory_usage > 80) {
            $this->createOrUpdateAlert(
                'high_memory',
                'warning',
                "Elevated memory usage on {$this->server->name} ({$this->metric->memory_usage}%)"
            );
        } else {
            // Resolve memory alerts if usage is normal
            $this->resolveAlert('high_memory');
        }

        // Check Disk usage
        if ($this->metric->disk_usage > 90) {
            $this->createOrUpdateAlert(
                'high_disk',
                'critical',
                "Disk space critically low on {$this->server->name} ({$this->metric->disk_usage}%)"
            );
        } elseif ($this->metric->disk_usage > 80) {
            $this->createOrUpdateAlert(
                'high_disk',
                'warning',
                "Disk space running low on {$this->server->name} ({$this->metric->disk_usage}%)"
            );
        } else {
            // Resolve disk alerts if usage is normal
            $this->resolveAlert('high_disk');
        }

        // Update server status based on overall health
        $this->updateServerStatus();
    }

    /**
     * Create or update alert for specific type
     */
    private function createOrUpdateAlert(string $type, string $severity, string $message): void
    {
        // Check if there's already an unresolved alert of this type
        $existingAlert = Alert::where('alertable_type', Server::class)
            ->where('alertable_id', $this->server->id)
            ->where('type', $type)
            ->where('is_resolved', false)
            ->first();

        if ($existingAlert) {
            // Update existing alert if severity changed
            if ($existingAlert->severity !== $severity) {
                $existingAlert->update([
                    'severity' => $severity,
                    'message' => $message,
                ]);
                Log::info("Updated {$type} alert for server: {$this->server->name}");
            }
        } else {
            // Create new alert
            $this->server->alerts()->create([
                'type' => $type,
                'severity' => $severity,
                'message' => $message,
                'is_resolved' => false,
            ]);
            Log::info("Created {$type} alert for server: {$this->server->name}");
        }
    }

    /**
     * Resolve alert of specific type
     */
    private function resolveAlert(string $type): void
    {
        $alert = Alert::where('alertable_type', Server::class)
            ->where('alertable_id', $this->server->id)
            ->where('type', $type)
            ->where('is_resolved', false)
            ->first();

        if ($alert) {
            $alert->update([
                'is_resolved' => true,
                'resolved_at' => now(),
            ]);
            Log::info("Resolved {$type} alert for server: {$this->server->name}");
        }
    }

    /**
     * Update server status based on metrics
     */
    private function updateServerStatus(): void
    {
        $status = 'online';

        // Check if any critical thresholds are exceeded
        // Use 'warning' status for critical metrics since enum only has online/offline/warning
        if ($this->metric->cpu_usage > 90 || 
            $this->metric->memory_usage > 90 || 
            $this->metric->disk_usage > 90) {
            $status = 'warning';
        } 
        // Check if any warning thresholds are exceeded
        elseif ($this->metric->cpu_usage > 70 || 
                $this->metric->memory_usage > 80 || 
                $this->metric->disk_usage > 80) {
            $status = 'warning';
        }

        $this->server->update(['status' => $status]);
    }
}
