<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/monitoring', [MonitoringController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('monitoring');

Route::get('/alerts', [AlertController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('alerts');

Route::get('/components-demo', function () {
    return view('components-demo');
})->middleware(['auth', 'verified'])->name('components.demo');

Route::get('/installation-guide', function () {
    return view('installation-guide');
})->middleware(['auth', 'verified'])->name('installation.guide');

// Agent downloads (no auth required for wget)
Route::get('/agent/monitor.py', function () {
    $path = base_path('agent/monitor.py');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->download($path, 'monitor.py', [
        'Content-Type' => 'text/x-python',
    ]);
})->name('agent.python');

Route::get('/agent/monitor.sh', function () {
    $path = base_path('agent/monitor.sh');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->download($path, 'monitor.sh', [
        'Content-Type' => 'text/x-shellscript',
    ]);
})->name('agent.bash');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Monitoring AJAX endpoints
    Route::get('/monitoring/metrics', [MonitoringController::class, 'getMetrics'])->name('monitoring.metrics');
    Route::get('/monitoring/server/{id}', [MonitoringController::class, 'serverDetails'])->name('monitoring.server');
    Route::get('/monitoring/website/{id}', [MonitoringController::class, 'websiteDetails'])->name('monitoring.website');
    
    // Alert Management
    Route::post('/alerts/{id}/resolve', [AlertController::class, 'resolve'])->name('alerts.resolve');
    Route::post('/alerts/resolve-multiple', [AlertController::class, 'resolveMultiple'])->name('alerts.resolve-multiple');
    Route::delete('/alerts/delete-resolved', [AlertController::class, 'deleteResolved'])->name('alerts.delete-resolved');
    Route::get('/alerts/{id}', [AlertController::class, 'show'])->name('alerts.show');
    
    // Reports
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/reports/export', [ReportsController::class, 'export'])->name('reports.export');
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    Route::post('/settings/optimize', [SettingsController::class, 'optimizeSystem'])->name('settings.optimize');
    Route::post('/settings/cleanup', [SettingsController::class, 'cleanupOldData'])->name('settings.cleanup');
    Route::post('/settings/test-notification', [SettingsController::class, 'testNotification'])->name('settings.test-notification');
    
    // Server Management
    Route::resource('servers', ServerController::class);
    Route::post('/servers/{server}/regenerate-token', [ServerController::class, 'regenerateToken'])
        ->name('servers.regenerate-token');
    
    // Website Management
    Route::resource('websites', WebsiteController::class);
    Route::post('/websites/{website}/check-now', [WebsiteController::class, 'checkNow'])
        ->name('websites.check-now');
});

require __DIR__.'/auth.php';
