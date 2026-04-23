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

        // Get severity emoji
        $emoji = $this->getSeverityEmoji($this->alert->severity ?? 'info');
        
        // Format message based on alert type
        if ($this->alertType === 'test') {
            return TelegramMessage::create()
                ->to($chatId)
                ->content("🔔 *Test Notification*\n\n")
                ->line("This is a test notification from Server Monitor.")
                ->line("✅ Telegram integration is working correctly!")
                ->line("\n_Sent at: " . now()->format('Y-m-d H:i:s') . "_");
        }

        // Build alert message
        $message = TelegramMessage::create()
            ->to($chatId)
            ->content("{$emoji} *" . strtoupper($this->alert->severity) . " Alert*\n\n");

        // Add alert details
        $type = str_replace('_', ' ', (string) ($this->alert->type ?? 'unknown'));
        $alertMessage = (string) ($this->alert->message ?? '-');

        $message->line("*Type:* " . $this->escapeTelegramMarkdown(ucfirst($type)))
                ->line("*Message:* " . $this->escapeTelegramMarkdown($alertMessage));

        // Add resource information if available
        if ($this->alert->alertable) {
            $resourceType = class_basename($this->alert->alertable_type);
            $resourceName = $this->alert->alertable->name ?? $this->alert->alertable->url ?? 'Unknown';
            $message->line("*Resource:* "
                . $this->escapeTelegramMarkdown($resourceType)
                . " - "
                . $this->escapeTelegramMarkdown((string) $resourceName));
        }

        // Add timestamp
        $message->line("\n_Created: " . $this->alert->created_at->format('Y-m-d H:i:s') . "_");

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
     * Escape characters interpreted by Telegram Markdown parser.
     */
    private function escapeTelegramMarkdown(string $text): string
    {
        $search = ['\\', '_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        $replace = ['\\\\', '\_', '\*', '\[', '\]', '\(', '\)', '\~', '\`', '\>', '\#', '\+', '\-', '\=', '\|', '\{', '\}', '\.', '\!'];

        return str_replace($search, $replace, $text);
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
