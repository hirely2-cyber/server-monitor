<?php

namespace App\Console\Commands;

use App\Models\Server;
use App\Models\Alert;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckOfflineServers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servers:check-offline {--threshold=5 : Minutes without heartbeat before marking offline}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for servers that haven\'t sent heartbeat and mark them as offline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thresholdMinutes = (int) $this->option('threshold');
        $thresholdTime = now()->subMinutes($thresholdMinutes);

        $this->info("Checking for servers offline for more than {$thresholdMinutes} minutes...");
        $this->newLine();

        // Get all servers
        $servers = Server::all();

        if ($servers->isEmpty()) {
            $this->warn("No servers found in database!");
            return 0;
        }

        $offlineCount = 0;
        $onlineCount = 0;

        foreach ($servers as $server) {
            $isOffline = !$server->last_seen_at || $server->last_seen_at < $thresholdTime;

            if ($isOffline && $server->status !== 'offline') {
                // Mark server as offline
                $server->update(['status' => 'offline']);
                
                // Create or update offline alert
                $this->createOfflineAlert($server);
                
                $this->line("<fg=red>✗</> {$server->name} is now <fg=red>OFFLINE</> (last seen: " . 
                           ($server->last_seen_at ? $server->last_seen_at->diffForHumans() : 'never') . ")");
                
                $offlineCount++;
                
            } elseif (!$isOffline && $server->status === 'offline') {
                // Server came back online
                $server->update(['status' => 'online']);
                
                // Resolve offline alert
                $this->resolveOfflineAlert($server);
                
                $this->line("<fg=green>✓</> {$server->name} is back <fg=green>ONLINE</>");
                
                $onlineCount++;
                
            } elseif ($isOffline) {
                $this->line("<fg=red>✗</> {$server->name} remains <fg=red>OFFLINE</> (last seen: " . 
                           ($server->last_seen_at ? $server->last_seen_at->diffForHumans() : 'never') . ")");
                $offlineCount++;
            } else {
                $onlineCount++;
            }
        }

        $this->newLine();
        $this->info("Summary:");
        $this->table(
            ['Status', 'Count'],
            [
                ['Online', $onlineCount],
                ['Offline', $offlineCount],
            ]
        );

        return 0;
    }

    /**
     * Create offline alert for server
     */
    private function createOfflineAlert(Server $server): void
    {
        // Check if there's already an unresolved offline alert
        $existingAlert = Alert::where('alertable_type', Server::class)
            ->where('alertable_id', $server->id)
            ->where('type', 'server_offline')
            ->where('is_resolved', false)
            ->first();

        if (!$existingAlert) {
            $server->alerts()->create([
                'type' => 'server_offline',
                'severity' => 'critical',
                'message' => "{$server->name} is offline and not responding to heartbeat",
                'is_resolved' => false,
            ]);

            Log::critical("Server offline: {$server->name}");
        }
    }

    /**
     * Resolve offline alert for server
     */
    private function resolveOfflineAlert(Server $server): void
    {
        $alert = Alert::where('alertable_type', Server::class)
            ->where('alertable_id', $server->id)
            ->where('type', 'server_offline')
            ->where('is_resolved', false)
            ->first();

        if ($alert) {
            $alert->update([
                'is_resolved' => true,
                'resolved_at' => now(),
            ]);

            Log::info("Server back online: {$server->name}");
        }
    }
}
