<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">{{ $website->name }}</h1>
                    <span class="badge 
                        @if($website->status == 'up') badge-green 
                        @elseif($website->status == 'slow') badge-yellow 
                        @elseif($website->status == 'down') badge-red 
                        @else badge-gray 
                        @endif">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 
                            @if($website->status == 'up') bg-green-500 
                            @elseif($website->status == 'slow') bg-yellow-500 
                            @elseif($website->status == 'down') bg-red-500 
                            @else bg-gray-500 
                            @endif">
                        </span>
                        {{ ucfirst($website->status) }}
                    </span>
                </div>
                <a href="{{ $website->url }}" target="_blank" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">{{ $website->url }}</a>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('websites.edit', $website) }}" class="inline-flex items-center px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                    </svg>
                    Edit Website
                </a>
                <a href="{{ route('websites.index') }}" class="inline-flex items-center px-4 py-2.5 bg-gray-600 hover:bg-gray-700 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Website Info & Status -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Website Details -->
            <div class="card p-6">
                <h3 class="section-title mb-4">Website Details</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Status</p>
                        <span class="badge 
                            @if($website->status == 'up') badge-green 
                            @elseif($website->status == 'slow') badge-yellow 
                            @elseif($website->status == 'down') badge-red 
                            @else badge-gray 
                            @endif mt-1">
                            {{ ucfirst($website->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Type</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">{{ ucfirst($website->type) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Server</p>
                        @if($website->server)
                        <a href="{{ route('servers.show', $website->server) }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $website->server->name }}
                        </a>
                        @else
                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">-</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Check Interval</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">
                            @if($website->check_interval < 60)
                                {{ $website->check_interval }} seconds
                            @elseif($website->check_interval < 3600)
                                {{ $website->check_interval / 60 }} minutes
                            @else
                                {{ $website->check_interval / 3600 }} hour(s)
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Last Checked</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">
                            {{ $website->last_checked_at ? $website->last_checked_at->diffForHumans() : 'Never' }}
                        </p>
                    </div>
                </div>

                <!-- Check Now Button -->
                <form action="{{ route('websites.check-now', $website) }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Check Now
                    </button>
                </form>
            </div>

            <!-- Current Status -->
            <div class="lg:col-span-2 card p-6">
                <h3 class="section-title mb-4">Current Status</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                            <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">Response Time</p>
                        </div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100">
                            {{ $website->response_time ? $website->response_time . 'ms' : '-' }}
                        </p>
                    </div>

                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">HTTP Status</p>
                        </div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100">
                            {{ $website->http_status ?? '-' }}
                        </p>
                    </div>

                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">Uptime (24h)</p>
                        </div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100">
                            {{ $uptimePercentage }}%
                        </p>
                    </div>

                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">SSL Expiry</p>
                        </div>
                        <p class="text-sm font-bold text-gray-900 dark:text-zinc-100">
                            {{ $website->ssl_expiry_date ? $website->ssl_expiry_date->format('M d, Y') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Checks History -->
        <div class="card p-6">
            <h3 class="section-title mb-4">Recent Checks</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 dark:border-zinc-700">
                            <th class="text-left py-3 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Time</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Status</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">HTTP Code</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Response Time</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Message</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($website->checks as $check)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-900/50">
                            <td class="py-3 px-4 text-sm text-gray-600 dark:text-zinc-400">
                                {{ $check->checked_at->format('M d, H:i:s') }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="badge 
                                    @if($check->status == 'up') badge-green 
                                    @elseif($check->status == 'slow') badge-yellow 
                                    @elseif($check->status == 'down') badge-red 
                                    @else badge-gray 
                                    @endif">
                                    {{ ucfirst($check->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm font-medium text-gray-900 dark:text-zinc-100">
                                {{ $check->http_status ?? '-' }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-900 dark:text-zinc-100">
                                {{ $check->response_time ? $check->response_time . 'ms' : '-' }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600 dark:text-zinc-400">
                                {{ $check->error_message ?? 'OK' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500 dark:text-zinc-400">
                                No check history available yet
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Active Alerts -->
        @if($website->alerts->count() > 0)
        <div class="card p-6 bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800">
            <h3 class="section-title mb-4 text-red-900 dark:text-red-100">Active Alerts</h3>
            <div class="space-y-3">
                @foreach($website->alerts as $alert)
                <div class="p-4 bg-white dark:bg-zinc-900 rounded-lg border border-red-200 dark:border-red-800">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-semibold text-red-900 dark:text-red-100">{{ $alert->type }}</p>
                            <p class="text-sm text-red-700 dark:text-red-300 mt-1">{{ $alert->message }}</p>
                            <p class="text-xs text-red-600 dark:text-red-400 mt-2">{{ $alert->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="badge badge-red">Active</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
