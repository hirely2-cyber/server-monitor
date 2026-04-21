<?php

namespace App\Observers;

use App\Models\Alert;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class AlertObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the Alert "created" event.
     */
    public function created(Alert $alert): void
    {
        // Check if we should send notification for this severity
        $notifyOnSeverity = config('notifications.notify_on_severity', ['critical', 'warning']);
        
        if (!in_array($alert->severity, $notifyOnSeverity)) {
            return;
        }

        // Send Telegram notification if enabled
        if (config('notifications.telegram_enabled')) {
            try {
                $this->notificationService->sendTelegramNotification($alert);
                Log::info("Telegram notification sent for alert #{$alert->id}");
            } catch (\Exception $e) {
                Log::error("Failed to send Telegram notification for alert #{$alert->id}: " . $e->getMessage());
            }
        }

        // TODO: Add email notification
        // TODO: Add Slack notification
    }
}
