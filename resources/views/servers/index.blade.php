<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Server Management</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Monitor and manage all your servers from one place</p>
            </div>
            <a href="{{ route('servers.create') }}" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Add Server
            </a>
        </div>

        @if(session('success'))
        <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="card p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100">{{ $servers->total() }}</p>
                        <p class="text-sm text-gray-600 dark:text-zinc-400 font-medium">Total Servers</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-green-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100">{{ $servers->where('status', 'online')->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-zinc-400 font-medium">Online</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-yellow-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100">{{ $servers->where('status', 'warning')->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-zinc-400 font-medium">Warning</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-red-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100">{{ $servers->where('status', 'offline')->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-zinc-400 font-medium">Offline</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Server List -->
        <div class="card p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 dark:border-zinc-700">
                            <th class="text-center py-4 px-3 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400 w-16">No</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Hostname</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Server</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Location</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Status</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Metrics</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Last Seen</th>
                            <th class="text-center py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($servers as $server)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-900/50 transition-colors duration-150">
                            <!-- No -->
                            <td class="py-4 px-3 text-center">
                                <span class="text-sm font-semibold text-gray-700 dark:text-zinc-300">{{ $loop->iteration + ($servers->currentPage() - 1) * $servers->perPage() }}</span>
                            </td>
                            <!-- Hostname -->
                            <td class="py-4 px-4">
                                <p class="text-sm font-mono text-gray-900 dark:text-zinc-100 font-medium">{{ $server->hostname ?? '-' }}</p>
                            </td>
                            <!-- Server Name & IP -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                        {{ substr($server->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-zinc-100">{{ $server->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-zinc-400 font-mono">{{ $server->ip_address }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">{{ $server->location ?? '-' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-zinc-400">{{ $server->provider ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="badge 
                                    @if($server->status == 'online') badge-green 
                                    @elseif($server->status == 'warning') badge-yellow 
                                    @else badge-red 
                                    @endif">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 
                                        @if($server->status == 'online') bg-green-500 
                                        @elseif($server->status == 'warning') bg-yellow-500 
                                        @else bg-red-500 
                                        @endif">
                                    </span>
                                    {{ ucfirst($server->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($server->latestMetric)
                                <div class="flex gap-3 text-xs">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21" />
                                        </svg>
                                        <span class="text-gray-700 dark:text-zinc-300 font-medium">{{ number_format($server->latestMetric->cpu_usage, 1) }}%</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                        </svg>
                                        <span class="text-gray-700 dark:text-zinc-300 font-medium">{{ number_format($server->latestMetric->memory_usage, 1) }}%</span>
                                    </div>
                                </div>
                                @else
                                <span class="text-xs text-gray-400 dark:text-zinc-500">No data</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-zinc-400">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $server->last_seen_at ? $server->last_seen_at->diffForHumans() : 'Never' }}
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('servers.show', $server) }}" class="action-btn-view" title="View Details">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('servers.edit', $server) }}" class="action-btn-edit" title="Edit Server">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('servers.destroy', $server) }}" method="POST" class="inline" x-data="{
                                        async confirmDelete(event) {
                                            event.preventDefault();
                                            const confirmed = await $store.confirm.show({
                                                title: 'Hapus Server',
                                                body: 'Yakin mau hapus server {{ $server->name }}? Data tidak bisa dikembalikan.',
                                                type: 'danger',
                                                confirmText: 'Ya, Hapus',
                                                cancelText: 'Batal'
                                            });
                                            if (confirmed) {
                                                event.target.closest('form').submit();
                                            }
                                        }
                                    }">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                @click="confirmDelete($event)"
                                                class="action-btn-delete"
                                                title="Delete Server">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-zinc-800 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400 dark:text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-900 dark:text-zinc-100 font-semibold mb-1">No servers yet</p>
                                    <p class="text-gray-500 dark:text-zinc-400 text-sm mb-4">Get started by adding your first server</p>
                                    <a href="{{ route('servers.create') }}" class="btn btn-primary">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                        Add Your First Server
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($servers->hasPages())
            <div class="mt-6">
                {{ $servers->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
