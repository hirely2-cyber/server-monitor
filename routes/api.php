<?php

use App\Http\Controllers\Api\MetricsController;
use Illuminate\Support\Facades\Route;

// API endpoints for VPS agents to send metrics
Route::middleware(['throttle:60,1'])->group(function () {
    // Store server metrics
    Route::post('/metrics', [MetricsController::class, 'store']);
    
    // Simple heartbeat/ping endpoint
    Route::post('/heartbeat', [MetricsController::class, 'heartbeat']);
    
    // Get server configuration
    Route::get('/config', [MetricsController::class, 'config']);
});
