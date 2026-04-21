<?php

namespace App\Jobs;

use App\Models\Website;
use App\Models\WebsiteCheck;
use App\Models\Alert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckWebsiteHealth implements ShouldQueue
{
    use Queueable;

    public $timeout = 30;
    public $tries = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Website $website
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $startTime = microtime(true);
        $status = 'down';
        $httpStatus = null;
        $responseTime = null;
        $errorMessage = null;

        try {
            // Make HTTP request with timeout
            $response = Http::timeout(10)
                ->withOptions(['verify' => false]) // Skip SSL verification for self-signed certs
                ->get($this->website->url);

            // Calculate response time in milliseconds
            $responseTime = (int) ((microtime(true) - $startTime) * 1000);
            $httpStatus = $response->status();

            // Determine status based on HTTP status code and response time
            if ($httpStatus >= 200 && $httpStatus < 300) {
                if ($responseTime > 3000) {
                    $status = 'slow'; // Slower than 3 seconds
                } else {
                    $status = 'up';
                }
            } else {
                $status = 'down';
                $errorMessage = "HTTP {$httpStatus} returned";
            }

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            $responseTime = (int) ((microtime(true) - $startTime) * 1000);
            $status = 'down';
            $errorMessage = 'Connection timeout or refused: ' . $e->getMessage();
            Log::warning("Website check failed for {$this->website->url}: Connection error");

        } catch (\Exception $e) {
            $responseTime = (int) ((microtime(true) - $startTime) * 1000);
            $status = 'down';
            $errorMessage = 'Error: ' . $e->getMessage();
            Log::error("Website check failed for {$this->website->url}: {$e->getMessage()}");
        }

        // Store check result
        WebsiteCheck::create([
            'website_id' => $this->website->id,
            'status' => $status === 'slow' ? 'up' : $status, // Store as 'up' if slow
            'http_status' => $httpStatus,
            'response_time' => $responseTime,
            'error_message' => $errorMessage,
            'checked_at' => now(),
        ]);

        // Update website status
        $this->website->update([
            'status' => $status,
            'http_status' => $httpStatus,
            'response_time' => $responseTime,
            'last_checked_at' => now(),
        ]);

        // Check SSL expiry (if HTTPS)
        if (str_starts_with($this->website->url, 'https://')) {
            $this->checkSslExpiry();
        }

        // Create alert if website is down
        if ($status === 'down' && $this->shouldCreateAlert()) {
            $this->createDownAlert($errorMessage);
        }

        // Create alert if website is slow
        if ($status === 'slow' && $this->shouldCreateSlowAlert()) {
            $this->createSlowAlert($responseTime);
        }
    }

    /**
     * Check SSL certificate expiry date
     */
    private function checkSslExpiry(): void
    {
        try {
            $url = parse_url($this->website->url);
            $hostname = $url['host'] ?? $this->website->url;
            
            $context = stream_context_create([
                'ssl' => [
                    'capture_peer_cert' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);

            $stream = @stream_socket_client(
                "ssl://{$hostname}:443",
                $errno,
                $errstr,
                10,
                STREAM_CLIENT_CONNECT,
                $context
            );

            if ($stream) {
                $params = stream_context_get_params($stream);
                $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate']);
                
                if ($cert && isset($cert['validTo_time_t'])) {
                    $expiryDate = Carbon::createFromTimestamp($cert['validTo_time_t']);
                    
                    $this->website->update([
                        'ssl_expiry_date' => $expiryDate->toDateString()
                    ]);

                    // Create alert if SSL expires soon (< 30 days)
                    $daysUntilExpiry = now()->diffInDays($expiryDate, false);
                    if ($daysUntilExpiry < 30 && $daysUntilExpiry >= 0) {
                        $this->createSslExpiryAlert($expiryDate, $daysUntilExpiry);
                    }
                }
                
                fclose($stream);
            }
        } catch (\Exception $e) {
            Log::warning("SSL check failed for {$this->website->url}: {$e->getMessage()}");
        }
    }

    /**
     * Check if we should create a down alert
     */
    private function shouldCreateAlert(): bool
    {
        // Check if there's already an unresolved alert for this website
        return !Alert::where('alertable_type', Website::class)
            ->where('alertable_id', $this->website->id)
            ->where('type', 'website_down')
            ->where('is_resolved', false)
            ->exists();
    }

    /**
     * Check if we should create a slow alert
     */
    private function shouldCreateSlowAlert(): bool
    {
        // Only create slow alert once per 6 hours
        $recentAlert = Alert::where('alertable_type', Website::class)
            ->where('alertable_id', $this->website->id)
            ->where('type', 'website_slow')
            ->where('created_at', '>', now()->subHours(6))
            ->exists();

        return !$recentAlert;
    }

    /**
     * Create down alert
     */
    private function createDownAlert(?string $errorMessage): void
    {
        $this->website->alerts()->create([
            'type' => 'website_down',
            'severity' => 'critical',
            'message' => "{$this->website->name} is currently unreachable" . 
                         ($errorMessage ? ": {$errorMessage}" : ''),
            'is_resolved' => false,
        ]);

        Log::info("Created down alert for website: {$this->website->name}");
    }

    /**
     * Create slow alert
     */
    private function createSlowAlert(int $responseTime): void
    {
        $this->website->alerts()->create([
            'type' => 'website_slow',
            'severity' => 'warning',
            'message' => "{$this->website->name} is responding slowly ({$responseTime}ms)",
            'is_resolved' => false,
        ]);

        Log::info("Created slow alert for website: {$this->website->name}");
    }

    /**
     * Create SSL expiry alert
     */
    private function createSslExpiryAlert(Carbon $expiryDate, int $daysUntilExpiry): void
    {
        // Check if there's already an alert for SSL expiry
        $existingAlert = Alert::where('alertable_type', Website::class)
            ->where('alertable_id', $this->website->id)
            ->where('type', 'ssl_expiring')
            ->where('is_resolved', false)
            ->first();

        if (!$existingAlert) {
            $this->website->alerts()->create([
                'type' => 'ssl_expiring',
                'severity' => $daysUntilExpiry < 7 ? 'critical' : 'warning',
                'message' => "SSL certificate for {$this->website->name} expires in {$daysUntilExpiry} days ({$expiryDate->format('Y-m-d')})",
                'is_resolved' => false,
            ]);

            Log::info("Created SSL expiry alert for website: {$this->website->name}");
        }
    }
}
