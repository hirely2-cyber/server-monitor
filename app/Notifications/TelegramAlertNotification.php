<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramAlertNotification extends Notification
{
    use Queueable;

    protected $alert;
    protected $alertType;

    /**
     * Create a new notification instance.
     */
    public function __construct($alert, $alertType = 'alert')
    {
        $this->alert = $alert;
        $this->alertType = $alertType;
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
        $chatId = Cache::get('settings.notifications.telegram_chat_id', config('notifications.telegram_chat_id'));
        $alertsUrl = rtrim(config('app.url'), '/') . '/alerts';

        // Get severity emoji
        $emoji = $this->getSeverityEmoji($this->alert->severity ?? 'info');
        
        // Format message based on alert type
        if ($this->alertType === 'test') {
            return TelegramMessage::create()
                ->to($chatId)
                ->content("🔔 Test Notification\n")
                ->line("This is a test notification from Server Monitor.")
                ->line("✅ Telegram integration is working correctly!")
                ->line("🔗 Check Alerts: {$alertsUrl}")
                ->line("\n_Sent at: " . now()->format('Y-m-d H:i:s') . "_");
        }

        // Build alert message
        $severity = strtoupper((string) ($this->alert->severity ?? 'info'));
        $message = TelegramMessage::create()
            ->to($chatId)
            ->content("{$emoji} {$severity} Alert\n");

        // Add alert details
        $type = str_replace('_', ' ', (string) ($this->alert->type ?? 'unknown'));
        $alertMessage = (string) ($this->alert->message ?? '-');

        $message->line("Type: " . ucfirst($type))
                ->line("Message: " . $alertMessage);

        // Add resource information if available
        if ($this->alert->alertable) {
            $resourceType = class_basename($this->alert->alertable_type);
            $resourceName = $this->alert->alertable->name ?? $this->alert->alertable->url ?? 'Unknown';
            $message->line("Resource: {$resourceType} - {$resourceName}");
        }

        $message->line("Check Alerts: {$alertsUrl}");

        // Add timestamp
        $message->line("Created: " . $this->alert->created_at->format('Y-m-d H:i:s'));

        return $message;
    }

    /**
     * Get emoji based on severity
     */
    private function getSeverityEmoji(string $severity): string
    {
        return match($severity) {
            'critical' => '🔴',
            'warning' => '⚠️',
            'info' => 'ℹ️',
            default => '🔔',
        };
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'alert_id' => $this->alert->id ?? null,
            'severity' => $this->alert->severity ?? 'info',
            'message' => $this->alert->message ?? 'Test notification',
        ];
    }
}
