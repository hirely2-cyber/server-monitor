<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Website Monitoring</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Monitor uptime, performance, and SSL certificates</p>
            </div>
            <a href="{{ route('websites.create') }}" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Add Website
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="card p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100">{{ $stats['total'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-zinc-400 font-medium">Total Websites</p>
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
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100">{{ $stats['up'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-zinc-400 font-medium">Online</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-yellow-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100">{{ $stats['slow'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-zinc-400 font-medium">Slow Response</p>
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
                        <p class="text-3xl font-bold text-gray-900 dark:text-zinc-100">{{ $stats['down'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-zinc-400 font-medium">Down</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Website List -->
        <div class="card p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 dark:border-zinc-700">
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Website</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Server</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Type</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Status</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Response Time</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Last Checked</th>
                            <th class="text-center py-4 px-4 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-zinc-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($websites as $website)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-900/50 transition-colors duration-150">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                        {{ substr($website->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-zinc-100">{{ $website->name }}</p>
                                        <a href="{{ $website->url }}" target="_blank" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">{{ $website->url }}</a>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                @if($website->server)
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">{{ $website->server->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-zinc-400">{{ $website->server->ip_address }}</p>
                                </div>
                                @else
                                <span class="text-xs text-gray-400 dark:text-zinc-500">No server</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="badge badge-gray">
                                    {{ ucfirst($website->type) }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
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
                            </td>
                            <td class="py-4 px-4">
                                @if($website->response_time)
                                <div class="flex items-center gap-1 text-xs">
                                    <svg class="w-3.5 h-3.5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                    </svg>
                                    <span class="text-gray-700 dark:text-zinc-300 font-medium">{{ $website->response_time }}ms</span>
                                </div>
                                @else
                                <span class="text-xs text-gray-400 dark:text-zinc-500">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-zinc-400">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $website->last_checked_at ? $website->last_checked_at->diffForHumans() : 'Never' }}
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('websites.show', $website) }}" class="action-btn-view" title="View Details">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('websites.edit', $website) }}" class="action-btn-edit" title="Edit Website">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('websites.destroy', $website) }}" method="POST" class="inline" x-data="{
                                        async confirmDelete(event) {
                                            event.preventDefault();
                                            const confirmed = await $store.confirm.show({
                                                title: 'Hapus Website',
                                                body: 'Yakin mau hapus website {{ $website->name }}? Data monitoring akan hilang.',
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
                                                title="Delete Website">
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
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-gray-900 dark:text-zinc-100 font-semibold">No websites yet</p>
                                        <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Add your first website to start monitoring</p>
                                    </div>
                                    <a href="{{ route('websites.create') }}" class="btn btn-primary mt-2">
                                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                        Add Website
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($websites->hasPages())
            <div class="mt-6 border-t border-gray-200 dark:border-zinc-700 pt-4">
                {{ $websites->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
