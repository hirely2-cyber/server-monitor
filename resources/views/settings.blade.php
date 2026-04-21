<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Settings</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Configure system monitoring and notifications</p>
            </div>
        </div>

        @if(session('success'))
        <div class="card p-4 border-l-4 bg-green-50 dark:bg-green-900/10 border-green-500">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium text-green-900 dark:text-green-100">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="card p-4 border-l-4 bg-red-50 dark:bg-red-900/10 border-red-500">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                <p class="text-sm font-medium text-red-900 dark:text-red-100">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- System Information -->
        <div class="card p-6">
            <h3 class="section-title mb-4">System Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">PHP Version</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-zinc-100 mt-1">{{ $systemInfo['php_version'] }}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">Laravel Version</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-zinc-100 mt-1">{{ $systemInfo['laravel_version'] }}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">Database Size</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-zinc-100 mt-1">{{ $systemInfo['database_size'] }} MB</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">Storage Used</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-zinc-100 mt-1">{{ $systemInfo['storage_used'] }} MB</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">Queue Jobs</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-zinc-100 mt-1">{{ $systemInfo['queue_jobs'] }}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">Failed Jobs</p>
                    <p class="text-lg font-semibold text-red-600 dark:text-red-400 mt-1">{{ $systemInfo['failed_jobs'] }}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">Cache Driver</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-zinc-100 mt-1">{{ ucfirst($systemInfo['cache_driver']) }}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">Queue Driver</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-zinc-100 mt-1">{{ ucfirst($systemInfo['queue_driver']) }}</p>
                </div>
            </div>
        </div>

        <!-- System Actions -->
        <div class="card p-6">
            <h3 class="section-title mb-4">System Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <form method="POST" action="{{ route('settings.clear-cache') }}">
                    @csrf
                    <button type="submit" class="w-full btn btn-secondary gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Clear All Cache
                    </button>
                </form>

                <form method="POST" action="{{ route('settings.optimize') }}">
                    @csrf
                    <button type="submit" class="w-full btn btn-secondary gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Optimize System
                    </button>
                </form>

                <form method="POST" action="{{ route('settings.cleanup') }}" onsubmit="return confirm('Are you sure you want to cleanup old data? This action cannot be undone.')">
                    @csrf
                    <button type="submit" class="w-full btn btn-danger gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Cleanup Old Data
                    </button>
                </form>
            </div>
        </div>

        <!-- Monitoring Settings -->
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            <div class="card p-6">
                <h3 class="section-title mb-4">Monitoring Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">
                            Check Interval (minutes)
                        </label>
                        <input type="number" name="monitoring[check_interval]" value="{{ $settings['monitoring']['check_interval'] }}" min="1" max="60" 
                               class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                        <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">How often to check servers/websites</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">
                            CPU Alert Threshold (%)
                        </label>
                        <input type="number" name="monitoring[alert_threshold_cpu]" value="{{ $settings['monitoring']['alert_threshold_cpu'] }}" min="50" max="100" 
                               class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                        <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Alert when CPU usage exceeds</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">
                            Memory Alert Threshold (%)
                        </label>
                        <input type="number" name="monitoring[alert_threshold_memory]" value="{{ $settings['monitoring']['alert_threshold_memory'] }}" min="50" max="100" 
                               class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                        <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Alert when memory usage exceeds</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">
                            Disk Alert Threshold (%)
                        </label>
                        <input type="number" name="monitoring[alert_threshold_disk]" value="{{ $settings['monitoring']['alert_threshold_disk'] }}" min="50" max="100" 
                               class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                        <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Alert when disk usage exceeds</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">
                            Website Timeout (seconds)
                        </label>
                        <input type="number" name="monitoring[website_timeout]" value="{{ $settings['monitoring']['website_timeout'] }}" min="5" max="60" 
                               class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                        <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Maximum wait time for website response</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">
                            Data Retention (days)
                        </label>
                        <input type="number" name="monitoring[retention_days]" value="{{ $settings['monitoring']['retention_days'] }}" min="7" max="365" 
                               class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                        <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">How long to keep historical data</p>
                    </div>
                </div>
            </div>

            <!-- Email Notifications -->
            <div class="card p-6 mt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="section-title">Email Notifications</h3>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="notifications[email_enabled]" value="1" {{ $settings['notifications']['email_enabled'] ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">
                            Email Recipients
                        </label>
                        <input type="text" name="notifications[email_recipients]" value="{{ $settings['notifications']['email_recipients'] }}" placeholder="admin@example.com, user@example.com" 
                               class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                        <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Comma-separated email addresses</p>
                    </div>
                    <button type="button" onclick="testNotification('email')" class="btn btn-sm btn-secondary">
                        Test Email Notification
                    </button>
                </div>
            </div>

            <!-- Slack Notifications -->
            <div class="card p-6 mt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="section-title">Slack Notifications</h3>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="notifications[slack_enabled]" value="1" {{ $settings['notifications']['slack_enabled'] ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">
                            Slack Webhook URL
                        </label>
                        <input type="url" name="notifications[slack_webhook]" value="{{ $settings['notifications']['slack_webhook'] }}" placeholder="https://hooks.slack.com/services/..." 
                               class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                    </div>
                    <button type="button" onclick="testNotification('slack')" class="btn btn-sm btn-secondary">
                        Test Slack Notification
                    </button>
                </div>
            </div>

            <!-- Telegram Notifications -->
            <div class="card p-6 mt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="section-title">Telegram Notifications</h3>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="notifications[telegram_enabled]" value="1" {{ $settings['notifications']['telegram_enabled'] ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">
                                Bot Token
                            </label>
                            <input type="text" name="notifications[telegram_token]" value="{{ $settings['notifications']['telegram_token'] }}" placeholder="123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11" 
                                   class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">
                                Chat ID
                            </label>
                            <input type="text" name="notifications[telegram_chat_id]" value="{{ $settings['notifications']['telegram_chat_id'] }}" placeholder="-1001234567890" 
                                   class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                        </div>
                    </div>
                    <button type="button" onclick="testNotification('telegram')" class="btn btn-sm btn-secondary">
                        Test Telegram Notification
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="btn btn-primary gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Settings
                </button>
            </div>
        </form>
    </div>

    <script>
        function testNotification(type) {
            fetch('{{ route("settings.test-notification") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✓ ' + data.message);
                } else {
                    alert('✕ ' + data.message);
                }
            })
            .catch(error => {
                alert('✕ Error sending test notification');
                console.error('Error:', error);
            });
        }
    </script>
</x-app-layout>
