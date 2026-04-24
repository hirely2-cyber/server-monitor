<?php

namespace App\Console\Commands;

use App\Models\Server;
use App\Models\Website;
use App\Notifications\TelegramStatusReportNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Cache;

class SendStatusReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send manual full status report to Telegram';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $enabled = Cache::get('settings.notifications.telegram_enabled', config('notifications.telegram_enabled'));
        $botToken = Cache::get('settings.notifications.telegram_bot_token', config('notifications.telegram_bot_token'));
        $chatId = Cache::get('settings.notifications.telegram_chat_id', config('notifications.telegram_chat_id'));

        if (!$enabled) {
            $this->error('Telegram notifications are disabled.');
            return self::FAILURE;
        }

        if (empty($botToken) || empty($chatId)) {
            $this->error('Telegram bot token or chat ID is not configured.');
            return self::FAILURE;
        }

        $summary = [
            'servers_online' => Server::where('status', 'online')->count(),
            'servers_warning' => Server::where('status', 'warning')->count(),
            'servers_offline' => Server::where('status', 'offline')->count(),
            'websites_up' => Website::where('status', 'up')->count(),
            'websites_slow' => Website::where('status', 'slow')->count(),
            'websites_down' => Website::where('status', 'down')->count(),
            'websites_unknown' => Website::where('status', 'unknown')->count(),
        ];

        $offlineServers = Server::where('status', 'offline')
            ->orderBy('name')
            ->limit(10)
            ->pluck('name')
            ->toArray();

        $downWebsites = Website::where('status', 'down')
            ->orderBy('name')
            ->limit(10)
            ->pluck('name')
            ->toArray();

        // Ensure Telegram channel uses latest token from settings cache.
        config(['services.telegram-bot-api.token' => $botToken]);

        $notifiable = new AnonymousNotifiable();
        $notifiable->route('telegram', $chatId);
        $notifiable->notify(new TelegramStatusReportNotification($summary, $offlineServers, $downWebsites));

        $this->info('Status report sent to Telegram successfully.');

        return self::SUCCESS;
    }
}
