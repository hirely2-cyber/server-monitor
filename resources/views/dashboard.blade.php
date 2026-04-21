<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Dashboard</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Here's what's happening with your servers today.</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-zinc-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Last updated: {{ now()->format('H:i') }}
            </div>
        </div>

        <!-- System Health Status -->
        <div class="card p-4 border-l-4 
            @if($systemHealth == 'healthy') bg-green-50 dark:bg-green-900/10 border-green-500
            @elseif($systemHealth == 'warning') bg-yellow-50 dark:bg-yellow-900/10 border-yellow-500
            @else bg-red-50 dark:bg-red-900/10 border-red-500
            @endif">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-full 
                    @if($systemHealth == 'healthy') bg-green-100 dark:bg-green-900/30
                    @elseif($systemHealth == 'warning') bg-yellow-100 dark:bg-yellow-900/30
                    @else bg-red-100 dark:bg-red-900/30
                    @endif">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full 
                            @if($systemHealth == 'healthy') bg-green-500
                            @elseif($systemHealth == 'warning') bg-yellow-500
                            @else bg-red-500
                            @endif opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 
                            @if($systemHealth == 'healthy') bg-green-600
                            @elseif($systemHealth == 'warning') bg-yellow-600
                            @else bg-red-600
                            @endif"></span>
                    </span>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold 
                        @if($systemHealth == 'healthy') text-green-900 dark:text-green-100
                        @elseif($systemHealth == 'warning') text-yellow-900 dark:text-yellow-100
                        @else text-red-900 dark:text-red-100
                        @endif">
                        @if($systemHealth == 'healthy')
                            ✓ All Systems Operational
                        @elseif($systemHealth == 'warning')
                            ⚠ System Warnings Detected
                        @else
                            ✕ Critical Issues Detected
                        @endif
                    </h3>
                    <p class="text-xs mt-0.5 
                        @if($systemHealth == 'healthy') text-green-700 dark:text-green-300
                        @elseif($systemHealth == 'warning') text-yellow-700 dark:text-yellow-300
                        @else text-red-700 dark:text-red-300
                        @endif">
                        @if($systemHealth == 'healthy')
                            All servers and websites are running smoothly
                        @elseif($systemHealth == 'warning')
                            {{ $warningServers > 0 ? $warningServers . ' server(s) need attention' : '' }}
                            {{ $websitesDown > 0 ? ($warningServers > 0 ? ', ' : '') . $websitesDown . ' website(s) down' : '' }}
                        @else
                            {{ $offlineServers > 0 ? $offlineServers . ' server(s) offline' : '' }}
                            {{ $criticalAlerts > 0 ? ($offlineServers > 0 ? ', ' : '') . $criticalAlerts . ' critical alert(s)' : '' }}
                        @endif
                    </p>
                </div>
                @if($systemHealth != 'healthy')
                <a href="{{ $systemHealth == 'critical' ? route('servers.index') : '#' }}" class="btn btn-sm 
                    @if($systemHealth == 'warning') btn-warning
                    @else btn-danger
                    @endif">
                    View Details
                </a>
                @endif
            </div>
        </div>

        <!-- Welcome -->
        <div class="card p-6 bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-950/30 dark:to-blue-950/30 border border-indigo-100 dark:border-indigo-900/50">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-sm text-gray-600 dark:text-zinc-400">You have {{ $totalServers }} servers and {{ $totalWebsites }} websites being monitored.</p>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Total Servers</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $totalServers }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                            <span class="text-green-600 dark:text-green-400">{{ $activeServers }} online</span>
                            @if($offlineServers > 0)
                                <span class="text-red-600 dark:text-red-400">, {{ $offlineServers }} offline</span>
                            @endif
                            @if($warningServers > 0)
                                <span class="text-yellow-600 dark:text-yellow-400">, {{ $warningServers }} warning</span>
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

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">System Uptime</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $uptimePercentage }}%</p>
                        <p class="text-xs mt-2">
                            <span class="text-green-600 dark:text-green-400">● {{ $activeServers }} active</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Websites</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $totalWebsites }}</p>
                        <p class="text-xs mt-2">
                            <span class="text-green-600 dark:text-green-400">{{ $websitesUp }} up</span>
                            @if($websitesSlow > 0)
                                <span class="text-yellow-600 dark:text-yellow-400">, {{ $websitesSlow }} slow</span>
                            @endif
                            @if($websitesDown > 0)
                                <span class="text-red-600 dark:text-red-400">, {{ $websitesDown }} down</span>
                            @endif
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Active Alerts</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $activeAlerts }}</p>
                        <p class="text-xs mt-2">
                            @if($criticalAlerts > 0)
                                <span class="text-red-600 dark:text-red-400">⚠ {{ $criticalAlerts }} critical</span>
                            @else
                                <span class="text-gray-600 dark:text-gray-400">All systems normal</span>
                            @endif
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Metrics & Network Traffic -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Avg CPU Usage</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100">{{ number_format($avgCpu, 1) }}%</p>
                    </div>
                </div>
                <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all {{ $avgCpu > 80 ? 'bg-red-500' : ($avgCpu > 60 ? 'bg-yellow-500' : 'bg-indigo-500') }}" style="width: {{ min($avgCpu, 100) }}%"></div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Avg Memory</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100">{{ number_format($avgMemory, 1) }}%</p>
                    </div>
                </div>
                <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all {{ $avgMemory > 80 ? 'bg-red-500' : ($avgMemory > 60 ? 'bg-yellow-500' : 'bg-cyan-500') }}" style="width: {{ min($avgMemory, 100) }}%"></div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-violet-100 dark:bg-violet-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Avg Disk Usage</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100">{{ number_format($avgDisk, 1) }}%</p>
                    </div>
                </div>
                <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all {{ $avgDisk > 80 ? 'bg-red-500' : 'bg-violet-500' }}" style="width: {{ min($avgDisk, 100) }}%"></div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Network Traffic</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100">{{ $totalTrafficGB }} GB</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-zinc-400">Total data transferred</p>
            </div>
        </div>

        <!-- Server Status & Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Server Status -->
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="section-title">Server Status</h3>
                    <a href="{{ route('servers.index') }}" class="btn btn-sm btn-secondary">
                        View All
                    </a>
                </div>

                @if($servers->count() > 0)
                    <div class="space-y-3">
                        @foreach($servers->take(5) as $server)
                        <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="badge 
                                        @if($server['status'] == 'online') badge-green 
                                        @elseif($server['status'] == 'warning') badge-yellow 
                                        @else badge-red 
                                        @endif">
                                        {{ ucfirst($server['status']) }}
                                    </span>
                                    <div>
                                        <span class="font-medium text-gray-900 dark:text-zinc-100">{{ $server['name'] }}</span>
                                        <p class="text-xs text-gray-500 dark:text-zinc-400">{{ $server['location'] ?? $server['ip_address'] }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-zinc-400">{{ $server['last_seen'] ?? 'Never' }}</span>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-gray-500 dark:text-zinc-400">CPU</span>
                                        <span class="font-medium text-gray-900 dark:text-zinc-100">{{ number_format($server['cpu'], 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-1.5">
                                        <div class="h-1.5 rounded-full {{ $server['cpu'] > 70 ? 'bg-yellow-500' : 'bg-blue-500' }}" style="width: {{ $server['cpu'] }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-gray-500 dark:text-zinc-400">Memory</span>
                                        <span class="font-medium text-gray-900 dark:text-zinc-100">{{ number_format($server['memory'], 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-1.5">
                                        <div class="h-1.5 rounded-full {{ $server['memory'] > 80 ? 'bg-red-500' : ($server['memory'] > 60 ? 'bg-yellow-500' : 'bg-green-500') }}" style="width: {{ $server['memory'] }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-gray-500 dark:text-zinc-400">Disk</span>
                                        <span class="font-medium text-gray-900 dark:text-zinc-100">{{ number_format($server['disk'], 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-1.5">
                                        <div class="h-1.5 rounded-full {{ $server['disk'] > 80 ? 'bg-red-500' : 'bg-purple-500' }}" style="width: {{ $server['disk'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500 dark:text-zinc-400">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                        </svg>
                        <p>No servers configured yet</p>
                    </div>
                @endif
            </div>

            <!-- Recent Activity -->
            <div class="card p-6">
                <h3 class="section-title mb-4">Recent Alerts</h3>
                @if($recentAlerts->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentAlerts as $alert)
                        <div class="flex gap-3 p-3 bg-gray-50 dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="w-2 h-2 rounded-full 
                                    @if($alert['severity'] == 'critical') bg-red-500 
                                    @elseif($alert['severity'] == 'warning') bg-yellow-500 
                                    @else bg-blue-500 
                                    @endif">
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900 dark:text-zinc-100 line-clamp-2">{{ $alert['message'] }}</p>
                                <div class="flex items-center gap-2 mt-1 text-xs text-gray-500 dark:text-zinc-400">
                                    <span>{{ $alert['source'] }}</span>
                                    <span>•</span>
                                    <span>{{ $alert['time'] }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500 dark:text-zinc-400">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>No alerts</p>
                        <p class="text-xs mt-1">All systems running normally</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Website Checks -->
        @if($recentWebsiteChecks->count() > 0)
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="section-title">Recent Website Checks</h3>
                <a href="{{ route('websites.index') }}" class="btn btn-sm btn-secondary">
                    View All
                </a>
            </div>
            
            <div class="space-y-3">
                @foreach($recentWebsiteChecks->take(8) as $check)
                <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800">
                    <div class="grid grid-cols-5 gap-4 items-center">
                        <!-- Website -->
                        <div class="col-span-2">
                            <div class="font-medium text-gray-900 dark:text-zinc-100">{{ $check['website_name'] }}</div>
                            <div class="text-xs text-gray-500 dark:text-zinc-400 mt-0.5">{{ Str::limit($check['website_url'], 50) }}</div>
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <span class="badge 
                                @if($check['status'] == 'up') badge-green
                                @elseif($check['status'] == 'slow') badge-yellow
                                @else badge-red
                                @endif">
                                {{ ucfirst($check['status']) }}
                            </span>
                        </div>
                        
                        <!-- HTTP Status & Response Time -->
                        <div class="text-sm">
                            <div class="flex items-center gap-2">
                                <span class="
                                    @if($check['http_status'] >= 200 && $check['http_status'] < 300) text-green-600 dark:text-green-400
                                    @elseif($check['http_status'] >= 300 && $check['http_status'] < 400) text-blue-600 dark:text-blue-400
                                    @else text-red-600 dark:text-red-400
                                    @endif font-medium">
                                    {{ $check['http_status'] ?? 'N/A' }}
                                </span>
                                <span class="text-gray-400">•</span>
                                <span class="text-gray-900 dark:text-zinc-100">
                                    @if($check['response_time'])
                                        {{ number_format($check['response_time']) }} ms
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <!-- Checked At -->
                        <div class="text-right">
                            <span class="text-sm text-gray-500 dark:text-zinc-400">{{ $check['checked_at'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
