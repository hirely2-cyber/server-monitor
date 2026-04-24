<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramStatusReportNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly array $summary,
        private readonly array $offlineServers,
        private readonly array $downWebsites,
    ) {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the Telegram representation of the notification.
     */
    public function toTelegram($notifiable): TelegramMessage
    {
        $chatId = $notifiable->routeNotificationFor('telegram');
        $alertsUrl = rtrim((string) config('app.url'), '/') . '/alerts';
        $monitoringUrl = rtrim((string) config('app.url'), '/') . '/monitoring';

        $message = TelegramMessage::create()
            ->to($chatId)
            ->content("System Status Report")
            ->line("")
            ->line("Servers")
            ->line("- Online: {$this->summary['servers_online']}")
            ->line("- Warning: {$this->summary['servers_warning']}")
            ->line("- Offline: {$this->summary['servers_offline']}")
            ->line("")
            ->line("Websites")
            ->line("- Up: {$this->summary['websites_up']}")
            ->line("- Slow: {$this->summary['websites_slow']}")
            ->line("- Down: {$this->summary['websites_down']}")
            ->line("- Unknown: {$this->summary['websites_unknown']}");

        if (!empty($this->offlineServers)) {
            $message->line("")
                ->line("Offline Servers:");
            foreach ($this->offlineServers as $serverName) {
                $message->line("- {$serverName}");
            }
        }

        if (!empty($this->downWebsites)) {
            $message->line("")
                ->line("Down Websites:");
            foreach ($this->downWebsites as $websiteName) {
                $message->line("- {$websiteName}");
            }
        }

        $message->line("")
            ->line("Monitoring: {$monitoringUrl}")
            ->line("Alerts: {$alertsUrl}")
            ->line("Generated: " . now()->format('Y-m-d H:i:s'));

        return $message;
    }
}
