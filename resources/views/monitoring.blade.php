<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Live Monitoring</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Real-time server and website monitoring</p>
            </div>
            <div class="flex items-center gap-2">
                <button 
                    onclick="refreshMetrics()" 
                    class="btn btn-sm btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Servers Stats -->
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Total Servers</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $stats['servers']['total'] }}</p>
                        <p class="text-xs mt-2">
                            <span class="text-green-600 dark:text-green-400">{{ $stats['servers']['online'] }} online</span>
                            @if($stats['servers']['warning'] > 0)
                                <span class="text-yellow-600 dark:text-yellow-400">, {{ $stats['servers']['warning'] }} warning</span>
                            @endif
                            @if($stats['servers']['offline'] > 0)
                                <span class="text-red-600 dark:text-red-400">, {{ $stats['servers']['offline'] }} offline</span>
                            @endif
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Websites Stats -->
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Total Websites</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $stats['websites']['total'] }}</p>
                        <p class="text-xs mt-2">
                            <span class="text-green-600 dark:text-green-400">{{ $stats['websites']['up'] }} up</span>
                            @if($stats['websites']['slow'] > 0)
                                <span class="text-yellow-600 dark:text-yellow-400">, {{ $stats['websites']['slow'] }} slow</span>
                            @endif
                            @if($stats['websites']['down'] > 0)
                                <span class="text-red-600 dark:text-red-400">, {{ $stats['websites']['down'] }} down</span>
                            @endif
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Online Servers -->
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Online Servers</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $stats['servers']['online'] }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">Operating normally</p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Warning Servers -->
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Warning Servers</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $stats['servers']['warning'] }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">High resource usage</p>
                    </div>
                    <div class="w-14 h-14 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Servers Monitoring -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="section-title">Server Metrics</h3>
                    <p class="text-sm text-gray-500 dark:text-zinc-400">Real-time server performance monitoring</p>
                </div>
            </div>
            
            @if($servers->isEmpty())
                <div class="text-center py-12 text-gray-500 dark:text-zinc-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                    </svg>
                    <p class="font-medium">No servers found</p>
                    <a href="{{ route('servers.create') }}" class="mt-4 inline-flex btn btn-sm btn-primary">
                        Add Server
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($servers as $server)
                        <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">{{ $server->name }}</h3>
                                        @if($server->status === 'online')
                                            <span class="badge badge-green">Online</span>
                                        @elseif($server->status === 'warning')
                                            <span class="badge badge-yellow">Warning</span>
                                        @else
                                            <span class="badge badge-red">Offline</span>
                                        @endif
                                    </div>
                                    <div class="mt-1 flex items-center gap-2 text-sm text-gray-500 dark:text-zinc-400">
                                        <span>{{ $server->ip_address }}</span>
                                        <span>•</span>
                                        <span>Last seen: {{ $server->last_seen_at ? $server->last_seen_at->diffForHumans() : 'Never' }}</span>
                                    </div>

                                    @if($server->latestMetric)
                                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <!-- CPU Usage -->
                                            <div>
                                                <div class="flex items-center justify-between text-sm mb-1">
                                                    <span class="text-gray-600 dark:text-zinc-400">CPU Usage</span>
                                                    <span class="font-medium text-gray-900 dark:text-zinc-100">{{ round($server->latestMetric->cpu_usage, 1) }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-2">
                                                    <div class="h-2 rounded-full transition-all duration-300 {{ $server->latestMetric->cpu_usage > 90 ? 'bg-red-500' : ($server->latestMetric->cpu_usage > 70 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                                         style="width: {{ min($server->latestMetric->cpu_usage, 100) }}%"></div>
                                                </div>
                                            </div>

                                            <!-- Memory Usage -->
                                            <div>
                                                <div class="flex items-center justify-between text-sm mb-1">
                                                    <span class="text-gray-600 dark:text-zinc-400">Memory Usage</span>
                                                    <span class="font-medium text-gray-900 dark:text-zinc-100">{{ round($server->latestMetric->memory_usage, 1) }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-2">
                                                    <div class="h-2 rounded-full transition-all duration-300 {{ $server->latestMetric->memory_usage > 90 ? 'bg-red-500' : ($server->latestMetric->memory_usage > 80 ? 'bg-yellow-500' : 'bg-blue-500') }}" 
                                                         style="width: {{ min($server->latestMetric->memory_usage, 100) }}%"></div>
                                                </div>
                                            </div>

                                            <!-- Disk Usage -->
                                            <div>
                                                <div class="flex items-center justify-between text-sm mb-1">
                                                    <span class="text-gray-600 dark:text-zinc-400">Disk Usage</span>
                                                    <span class="font-medium text-gray-900 dark:text-zinc-100">{{ round($server->latestMetric->disk_usage, 1) }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-2">
                                                    <div class="h-2 rounded-full transition-all duration-300 {{ $server->latestMetric->disk_usage > 90 ? 'bg-red-500' : ($server->latestMetric->disk_usage > 80 ? 'bg-yellow-500' : 'bg-purple-500') }}" 
                                                         style="width: {{ min($server->latestMetric->disk_usage, 100) }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <p class="mt-4 text-sm text-gray-500 dark:text-zinc-400">No metrics available</p>
                                    @endif

                                    <!-- Active Alerts -->
                                    @if($server->alerts->count() > 0)
                                        <div class="mt-4">
                                            <p class="text-sm font-medium text-gray-600 dark:text-zinc-400 mb-2">Active Alerts ({{ $server->alerts->count() }})</p>
                                            <div class="space-y-1">
                                                @foreach($server->alerts->take(3) as $alert)
                                                    <div class="flex items-center gap-2 text-sm">
                                                        @if($alert->severity === 'critical')
                                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                                            <span class="text-red-600 dark:text-red-400">{{ $alert->message }}</span>
                                                        @elseif($alert->severity === 'warning')
                                                            <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                                            <span class="text-yellow-600 dark:text-yellow-400">{{ $alert->message }}</span>
                                                        @else
                                                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                                            <span class="text-blue-600 dark:text-blue-400">{{ $alert->message }}</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Websites Monitoring -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="section-title">Website Health</h3>
                    <p class="text-sm text-gray-500 dark:text-zinc-400">Monitor website availability and performance</p>
                </div>
            </div>
            
            @if($websites->isEmpty())
                <div class="text-center py-12 text-gray-500 dark:text-zinc-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                    </svg>
                    <p class="font-medium">No websites found</p>
                    <a href="{{ route('websites.create') }}" class="mt-4 inline-flex btn btn-sm btn-primary">
                        Add Website
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($websites as $website)
                        <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        @if($website->status === 'up')
                                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                        @elseif($website->status === 'slow')
                                            <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                                        @elseif($website->status === 'down')
                                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                        @else
                                            <span class="w-3 h-3 bg-gray-500 rounded-full"></span>
                                        @endif
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-zinc-100 truncate">{{ $website->name }}</h3>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-zinc-400 truncate">{{ $website->url }}</p>

                                    @if($website->latestCheck)
                                        <div class="mt-3 space-y-2">
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-gray-500 dark:text-zinc-400">Status</span>
                                                @if($website->latestCheck->status === 'up')
                                                    <span class="badge badge-green">Up</span>
                                                @elseif($website->latestCheck->status === 'slow')
                                                    <span class="badge badge-yellow">Slow</span>
                                                @else
                                                    <span class="badge badge-red">Down</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-gray-500 dark:text-zinc-400">Response Time</span>
                                                <span class="font-medium text-gray-900 dark:text-zinc-100">{{ $website->latestCheck->response_time }}ms</span>
                                            </div>
                                            @if($website->latestCheck->http_code)
                                                <div class="flex items-center justify-between text-xs">
                                                    <span class="text-gray-500 dark:text-zinc-400">HTTP Code</span>
                                                    <span class="font-medium text-gray-900 dark:text-zinc-100">{{ $website->latestCheck->http_code }}</span>
                                                </div>
                                            @endif
                                            @if($website->ssl_expiry_date)
                                                <div class="flex items-center justify-between text-xs">
                                                    <span class="text-gray-500 dark:text-zinc-400">SSL Expiry</span>
                                                    <span class="font-medium text-gray-900 dark:text-zinc-100">{{ $website->ssl_expiry_date->diffForHumans() }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <p class="mt-3 text-xs text-gray-500 dark:text-zinc-400">No check data</p>
                                    @endif

                                    @if($website->alerts->count() > 0)
                                        <div class="mt-3 px-2 py-1 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-900/30 rounded text-xs text-red-600 dark:text-red-400">
                                            {{ $website->alerts->count() }} active {{ Str::plural('alert', $website->alerts->count()) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        // Auto-refresh metrics every 30 seconds
        let refreshInterval;

        function startAutoRefresh() {
            refreshInterval = setInterval(() => {
                refreshMetrics();
            }, 30000); // 30 seconds
        }

        function refreshMetrics() {
            // Show loading indicator
            console.log('Refreshing metrics...');
            
            // Reload the page to get fresh data
            window.location.reload();
        }

        // Start auto-refresh on page load
        document.addEventListener('DOMContentLoaded', () => {
            startAutoRefresh();
        });

        // Clean up on page unload
        window.addEventListener('beforeunload', () => {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        });
    </script>
</x-app-layout>
