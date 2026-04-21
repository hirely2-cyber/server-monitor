<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Reports</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">View system performance and generate reports</p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="exportReport('servers')" class="btn btn-sm btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Servers
                </button>
                <button onclick="exportReport('websites')" class="btn btn-sm btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Websites
                </button>
                <button onclick="exportReport('alerts')" class="btn btn-sm btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Alerts
                </button>
            </div>
        </div>

        <!-- Date Range Filter -->
        <div class="card p-6">
            <h3 class="section-title mb-4">Date Range</h3>
            <form method="GET" action="{{ route('reports') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" 
                           class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" 
                           class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn btn-primary w-full gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Total Servers</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-1">{{ $stats['servers']['total'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Total Websites</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-1">{{ $stats['websites']['total'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Total Alerts</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-1">{{ $stats['alerts']['total'] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-orange-100 dark:bg-orange-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Avg CPU</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-1">{{ $stats['metrics']['avg_cpu'] }}%</p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25zm.75-12h9v9h-9v-9z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Avg Memory</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-1">{{ $stats['metrics']['avg_memory'] }}%</p>
                    </div>
                    <div class="w-14 h-14 bg-indigo-100 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Avg Response</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-1">{{ $stats['metrics']['avg_response_time'] }}ms</p>
                    </div>
                    <div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Server Performance Report -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="section-title">Server Performance</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-200 dark:border-zinc-700">
                        <tr class="text-left">
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400">Server</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400">IP Address</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400">Status</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400 text-right">Avg CPU</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400 text-right">Max CPU</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400 text-right">Avg Memory</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400 text-right">Avg Disk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($serverPerformance as $server)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                            <td class="py-3 text-sm font-medium text-gray-900 dark:text-zinc-100">{{ $server['name'] }}</td>
                            <td class="py-3 text-sm text-gray-600 dark:text-zinc-400">{{ $server['ip'] }}</td>
                            <td class="py-3">
                                <span class="badge {{ $server['status'] === 'online' ? 'badge-green' : ($server['status'] === 'warning' ? 'badge-yellow' : 'badge-red') }}">
                                    {{ ucfirst($server['status']) }}
                                </span>
                            </td>
                            <td class="py-3 text-sm text-gray-900 dark:text-zinc-100 text-right">{{ $server['avg_cpu'] }}%</td>
                            <td class="py-3 text-sm text-gray-900 dark:text-zinc-100 text-right">{{ $server['max_cpu'] }}%</td>
                            <td class="py-3 text-sm text-gray-900 dark:text-zinc-100 text-right">{{ $server['avg_memory'] }}%</td>
                            <td class="py-3 text-sm text-gray-900 dark:text-zinc-100 text-right">{{ $server['avg_disk'] }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-500 dark:text-zinc-400">
                                No server data available for the selected date range.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Website Uptime Report -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="section-title">Website Uptime</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-200 dark:border-zinc-700">
                        <tr class="text-left">
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400">Website</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400">URL</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400">Status</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400 text-right">Uptime</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400 text-right">Total Checks</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400 text-right">Failed</th>
                            <th class="pb-3 text-sm font-medium text-gray-500 dark:text-zinc-400 text-right">Avg Response</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($websiteUptime as $website)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                            <td class="py-3 text-sm font-medium text-gray-900 dark:text-zinc-100">{{ $website['name'] }}</td>
                            <td class="py-3 text-sm text-gray-600 dark:text-zinc-400">{{ Str::limit($website['url'], 40) }}</td>
                            <td class="py-3">
                                <span class="badge {{ $website['status'] === 'up' ? 'badge-green' : ($website['status'] === 'slow' ? 'badge-yellow' : 'badge-red') }}">
                                    {{ ucfirst($website['status']) }}
                                </span>
                            </td>
                            <td class="py-3 text-sm text-right">
                                <span class="font-semibold {{ $website['uptime'] >= 99 ? 'text-green-600 dark:text-green-400' : ($website['uptime'] >= 95 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                    {{ $website['uptime'] }}%
                                </span>
                            </td>
                            <td class="py-3 text-sm text-gray-900 dark:text-zinc-100 text-right">{{ $website['total_checks'] }}</td>
                            <td class="py-3 text-sm text-red-600 dark:text-red-400 text-right">{{ $website['failed_checks'] }}</td>
                            <td class="py-3 text-sm text-gray-900 dark:text-zinc-100 text-right">{{ $website['avg_response_time'] }}ms</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-500 dark:text-zinc-400">
                                No website data available for the selected date range.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Issues -->
        @if($topIssues->count() > 0)
        <div class="card p-6">
            <h3 class="section-title mb-4">Top Critical Issues</h3>
            <div class="space-y-3">
                @foreach($topIssues as $issue)
                <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 mt-2 rounded-full bg-red-500 flex-shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">{{ $issue->message }}</p>
                                    <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">
                                        {{ $issue->alertable ? class_basename($issue->alertable_type) . ': ' . ($issue->alertable->name ?? $issue->alertable->url) : 'System' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <span class="badge badge-red">Critical</span>
                                    <span class="text-xs text-gray-500 dark:text-zinc-400">{{ $issue->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <script>
        function exportReport(type) {
            const startDate = '{{ $startDate }}';
            const endDate = '{{ $endDate }}';
            window.location.href = `{{ route('reports.export') }}?type=${type}&start_date=${startDate}&end_date=${endDate}`;
        }
    </script>
</x-app-layout>
