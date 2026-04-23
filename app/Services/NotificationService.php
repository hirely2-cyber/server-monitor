<?php

namespace App\Services;

use App\Notifications\TelegramAlertNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\AnonymousNotifiable;

class NotificationService
{
    /**
     * Send Telegram notification
     */
    public function sendTelegramNotification($alert, $alertType = 'alert')
    {
        $telegramEnabled = Cache::get('settings.notifications.telegram_enabled', config('notifications.telegram_enabled'));
        if (!$telegramEnabled) {
            throw new \Exception('Telegram notifications are not enabled');
        }

        $botToken = Cache::get('settings.notifications.telegram_bot_token', config('notifications.telegram_bot_token'));
        $chatId = Cache::get('settings.notifications.telegram_chat_id', config('notifications.telegram_chat_id'));

        if (empty($botToken) || empty($chatId)) {
            throw new \Exception('Telegram bot token or chat ID is not configured');
        }

        // Ensure Telegram channel uses latest token from settings cache.
        config(['services.telegram-bot-api.token' => $botToken]);

        // Create anonymous notifiable for Telegram
        $notifiable = new AnonymousNotifiable();
        $notifiable->route('telegram', $chatId);

        // Send notification
        $notifiable->notify(new TelegramAlertNotification($alert, $alertType));
    }

    /**
     * Send test notification
     */
    public function sendTestNotification(string $type)
    {
        switch ($type) {
            case 'telegram':
                return $this->sendTestTelegram();
            
            case 'email':
                return $this->sendTestEmail();
            
            case 'slack':
                return $this->sendTestSlack();
            
            default:
                throw new \Exception("Unsupported notification type: {$type}");
        }
    }

    /**
     * Send test Telegram notification
     */
    private function sendTestTelegram()
    {
        $testAlert = (object) [
            'id' => null,
            'severity' => 'info',
            'type' => 'test',
            'message' => 'This is a test notification',
            'created_at' => now(),
        ];

        $this->sendTelegramNotification($testAlert, 'test');
        
        return [
            'success' => true,
            'message' => 'Telegram test notification sent successfully'
        ];
    }

    /**
     * Send test Email notification
     */
    private function sendTestEmail()
    {
        // TODO: Implement email notification
        throw new \Exception('Email notifications are not yet implemented');
    }

    /**
     * Send test Slack notification
     */
    private function sendTestSlack()
    {
        // TODO: Implement Slack notification
        throw new \Exception('Slack notifications are not yet implemented');
    }
}
