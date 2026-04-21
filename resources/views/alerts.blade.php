<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Alerts</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Monitor and manage system alerts</p>
            </div>
            <div class="flex items-center gap-2">
                <button 
                    onclick="deleteResolved()" 
                    class="btn btn-sm btn-danger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Resolved
                </button>
                <a href="{{ route('monitoring') }}" class="btn btn-sm btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    View Monitoring
                </a>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Total Alerts</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Active</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $stats['active'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Resolved</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $stats['resolved'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Critical</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $stats['critical'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Warning</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $stats['warning'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-zinc-400">Info</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100 mt-2">{{ $stats['info'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card p-6">
            <form method="GET" action="{{ route('alerts') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100" onchange="this.form.submit()">
                        <option value="">All Alerts</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved Only</option>
                    </select>
                </div>

                <!-- Severity Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Severity</label>
                    <select name="severity" class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100" onchange="this.form.submit()">
                        <option value="all" {{ request('severity') === 'all' || !request('severity') ? 'selected' : '' }}>All Severities</option>
                        <option value="critical" {{ request('severity') === 'critical' ? 'selected' : '' }}>Critical</option>
                        <option value="warning" {{ request('severity') === 'warning' ? 'selected' : '' }}>Warning</option>
                        <option value="info" {{ request('severity') === 'info' ? 'selected' : '' }}>Info</option>
                    </select>
                </div>

                <!-- Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Type</label>
                    <select name="type" class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100" onchange="this.form.submit()">
                        <option value="all" {{ request('type') === 'all' || !request('type') ? 'selected' : '' }}>All Types</option>
                        <option value="high_cpu" {{ request('type') === 'high_cpu' ? 'selected' : '' }}>High CPU</option>
                        <option value="high_memory" {{ request('type') === 'high_memory' ? 'selected' : '' }}>High Memory</option>
                        <option value="high_disk" {{ request('type') === 'high_disk' ? 'selected' : '' }}>High Disk</option>
                        <option value="server_offline" {{ request('type') === 'server_offline' ? 'selected' : '' }}>Server Offline</option>
                        <option value="website_down" {{ request('type') === 'website_down' ? 'selected' : '' }}>Website Down</option>
                        <option value="website_slow" {{ request('type') === 'website_slow' ? 'selected' : '' }}>Website Slow</option>
                        <option value="ssl_expiring" {{ request('type') === 'ssl_expiring' ? 'selected' : '' }}>SSL Expiring</option>
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="flex items-end">
                    <a href="{{ route('alerts') }}" class="btn btn-secondary w-full gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Alerts List -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="section-title">Alert History</h3>
                <span class="text-sm text-gray-500 dark:text-zinc-400">{{ $alerts->total() }} alerts</span>
            </div>
            
            @if($alerts->isEmpty())
                <div class="text-center py-12 text-gray-500 dark:text-zinc-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                    </svg>
                    <p class="font-medium">No alerts found</p>
                    <p class="text-sm mt-1">All systems running normally</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($alerts as $alert)
                        <div class="flex gap-3 p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800 {{ $alert->is_resolved ? 'opacity-60' : '' }}">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="w-2 h-2 rounded-full 
                                    @if($alert->severity === 'critical') bg-red-500
                                    @elseif($alert->severity === 'warning') bg-yellow-500
                                    @else bg-blue-500
                                    @endif">
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <!-- Severity Badge -->
                                    @if($alert->severity === 'critical')
                                        <span class="badge badge-red">Critical</span>
                                    @elseif($alert->severity === 'warning')
                                        <span class="badge badge-yellow">Warning</span>
                                    @else
                                        <span class="badge badge-blue">Info</span>
                                    @endif

                                    <!-- Status Badge -->
                                    @if($alert->is_resolved)
                                        <span class="badge badge-green">Resolved</span>
                                    @else
                                        <span class="badge badge-blue">Active</span>
                                    @endif

                                    <!-- Type Badge -->
                                    <span class="text-xs px-2 py-0.5 bg-gray-200 dark:bg-zinc-800 text-gray-700 dark:text-zinc-300 rounded">
                                        {{ str_replace('_', ' ', ucfirst($alert->type)) }}
                                    </span>
                                </div>

                                <!-- Message -->
                                <p class="text-sm text-gray-900 dark:text-zinc-100 font-medium">{{ $alert->message }}</p>

                                <!-- Resource Info -->
                                <div class="flex items-center gap-2 mt-1 text-xs text-gray-500 dark:text-zinc-400">
                                    <span>
                                        @if($alert->alertable_type === 'App\\Models\\Server')
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                            </svg>
                                            Server: {{ $alert->alertable->name ?? 'Unknown' }}
                                        @elseif($alert->alertable_type === 'App\\Models\\Website')
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                            </svg>
                                            Website: {{ $alert->alertable->name ?? 'Unknown' }}
                                        @endif
                                    </span>
                                    <span>•</span>
                                    <span>{{ $alert->created_at->diffForHumans() }}</span>
                                    @if($alert->is_resolved && $alert->resolved_at)
                                        <span>•</span>
                                        <span class="text-green-600 dark:text-green-400">Resolved {{ $alert->resolved_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            @if(!$alert->is_resolved)
                                <button 
                                    onclick="resolveAlert({{ $alert->id }})" 
                                    class="btn btn-sm btn-success flex-shrink-0">
                                    Resolve
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $alerts->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function resolveAlert(alertId) {
            if (!confirm('Are you sure you want to resolve this alert?')) {
                return;
            }

            fetch(`/alerts/${alertId}/resolve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Failed to resolve alert');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to resolve alert');
            });
        }

        function deleteResolved() {
            if (!confirm('Are you sure you want to delete all resolved alerts? This action cannot be undone.')) {
                return;
            }

            fetch('/alerts/delete-resolved', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Failed to delete alerts');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete alerts');
            });
        }
    </script>
</x-app-layout>
