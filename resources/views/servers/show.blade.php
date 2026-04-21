<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">{{ $server->name }}</h1>
                    <span class="badge {{ $server->status == 'online' ? 'badge-green' : ($server->status == 'warning' ? 'badge-yellow' : 'badge-red') }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $server->status == 'online' ? 'bg-green-500' : ($server->status == 'warning' ? 'bg-yellow-500' : 'bg-red-500') }}"></span>
                        {{ ucfirst($server->status) }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-zinc-400 font-mono">{{ $server->ip_address }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('servers.edit', $server) }}" class="inline-flex items-center px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                    </svg>
                    Edit Server
                </a>
                <a href="{{ route('servers.index') }}" class="inline-flex items-center px-4 py-2.5 bg-gray-600 hover:bg-gray-700 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    Back to List
                </a>
            </div>
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

        <!-- Server Info & Metrics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Server Details -->
            <div class="card p-6">
                <h3 class="section-title mb-4">Server Details</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Status</p>
                        <span class="badge {{ $server->status == 'online' ? 'badge-green' : ($server->status == 'warning' ? 'badge-yellow' : 'badge-red') }} mt-1">
                            {{ ucfirst($server->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Location</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">{{ $server->location ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Provider</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">{{ $server->provider ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Operating System</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">{{ $server->os ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Last Seen</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-100">
                            {{ $server->last_seen_at ? $server->last_seen_at->diffForHumans() : 'Never' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Current Metrics -->
            <div class="lg:col-span-2 card p-6">
                <h3 class="section-title mb-4">Current Metrics</h3>
                @if($server->latestMetric)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-zinc-400 mb-1">CPU Usage</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100">{{ number_format($server->latestMetric->cpu_usage, 1) }}%</p>
                        <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-2 mt-2">
                            <div class="h-2 rounded-full {{ $server->latestMetric->cpu_usage > 80 ? 'bg-red-500' : ($server->latestMetric->cpu_usage > 60 ? 'bg-yellow-500' : 'bg-blue-500') }}" 
                                 style="width: {{ $server->latestMetric->cpu_usage }}%"></div>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-zinc-400 mb-1">Memory Usage</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100">{{ number_format($server->latestMetric->memory_usage, 1) }}%</p>
                        <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-2 mt-2">
                            <div class="h-2 rounded-full {{ $server->latestMetric->memory_usage > 80 ? 'bg-red-500' : ($server->latestMetric->memory_usage > 60 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                 style="width: {{ $server->latestMetric->memory_usage }}%"></div>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-zinc-400 mb-1">Disk Usage</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100">{{ number_format($server->latestMetric->disk_usage, 1) }}%</p>
                        <div class="w-full bg-gray-200 dark:bg-zinc-800 rounded-full h-2 mt-2">
                            <div class="h-2 rounded-full {{ $server->latestMetric->disk_usage > 80 ? 'bg-red-500' : 'bg-purple-500' }}" 
                                 style="width: {{ $server->latestMetric->disk_usage }}%"></div>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-zinc-400 mb-1">Load Average</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-zinc-100">{{ $server->latestMetric->load_average ?? '-' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-zinc-400 mb-1">Network In</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-zinc-100">{{ number_format($server->latestMetric->network_in ?? 0, 2) }} KB/s</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-zinc-400 mb-1">Network Out</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-zinc-100">{{ number_format($server->latestMetric->network_out ?? 0, 2) }} KB/s</p>
                    </div>
                </div>
                @else
                <div class="text-center py-12 text-gray-500 dark:text-zinc-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                    <p>No metrics data yet</p>
                    <p class="text-sm mt-1">Install agent di VPS untuk mulai monitoring</p>
                </div>
                @endif
            </div>
        </div>

        <!-- SSH & Panel Access -->
        @if($server->ssh_username || $server->panel_type !== 'None')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- SSH Access -->
            @if($server->ssh_username)
            <div class="card p-6">
                <h3 class="section-title mb-6">🔐 SSH Access</h3>
                <div class="space-y-5">
                    <!-- SSH Command -->
                    <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700/50">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-gray-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <label class="text-xs font-semibold text-gray-600 dark:text-zinc-300 uppercase tracking-wide">
                                SSH Command
                            </label>
                        </div>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                value="{{ $server->getSshCommand() }}"
                                readonly
                                class="flex-1 px-3 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-600 rounded-lg font-mono text-sm text-gray-900 dark:text-zinc-100 focus:outline-none"
                                id="sshCommand"
                            >
                            <button 
                                onclick="copyToClipboard('sshCommand', 'SSH command copied!')"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Username -->
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700/50">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5 text-gray-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <p class="text-xs font-semibold text-gray-600 dark:text-zinc-300 uppercase tracking-wide">Username</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-zinc-100 font-mono">{{ $server->ssh_username }}</p>
                        </div>

                        <!-- Port -->
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700/50">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5 text-gray-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                <p class="text-xs font-semibold text-gray-600 dark:text-zinc-300 uppercase tracking-wide">Port</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-zinc-100 font-mono">{{ $server->ssh_port ?? 22 }}</p>
                        </div>
                    </div>

                    <!-- Password -->
                    @if($server->ssh_password)
                    <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700/50" x-data="{ showPassword: false }">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                            </svg>
                            <p class="text-xs font-semibold text-gray-600 dark:text-zinc-300 uppercase tracking-wide">Password</p>
                        </div>
                        <div class="flex gap-2">
                            <input 
                                :type="showPassword ? 'text' : 'password'" 
                                value="{{ $server->ssh_password }}"
                                readonly
                                class="flex-1 px-3 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-600 rounded-lg text-sm font-mono text-gray-900 dark:text-zinc-100 focus:outline-none"
                                id="sshPassword"
                            >
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                class="px-3 py-2 text-gray-600 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-zinc-100 hover:bg-gray-200 dark:hover:bg-zinc-700 border border-gray-300 dark:border-zinc-600 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <svg x-show="!showPassword" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                </svg>
                            </button>
                            <button 
                                onclick="copyToClipboard('sshPassword', 'SSH password copied!')"
                                class="px-3 py-2 text-gray-600 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-zinc-100 hover:bg-gray-200 dark:hover:bg-zinc-700 border border-gray-300 dark:border-zinc-600 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif

                    <!-- Private Key -->
                    @if($server->ssh_private_key)
                    <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700/50">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <p class="text-xs font-semibold text-gray-600 dark:text-zinc-300 uppercase tracking-wide">Private Key</p>
                        </div>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                value="••••••••••••••••••••"
                                readonly
                                class="flex-1 px-3 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-600 rounded-lg text-sm font-mono text-gray-900 dark:text-zinc-100 focus:outline-none"
                            >
                            <button 
                                onclick="copyToClipboard('', 'Private key copied!', `{{ str_replace(["\r", "\n"], ['', '\n'], $server->ssh_private_key) }}`)"
                                class="px-3 py-2 text-gray-600 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-zinc-100 hover:bg-gray-200 dark:hover:bg-zinc-700 border border-gray-300 dark:border-zinc-600 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Panel Access -->
            @if($server->panel_type !== 'None')
            <div class="card p-6">
                <h3 class="section-title mb-6">🎛️ Panel Access</h3>
                <div class="space-y-5">
                    <!-- Panel URL with Quick Access -->
                    <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700/50">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-gray-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            </svg>
                            <label class="text-xs font-semibold text-gray-600 dark:text-zinc-300 uppercase tracking-wide">
                                Panel URL
                            </label>
                        </div>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                value="{{ $server->panel_url }}"
                                readonly
                                class="flex-1 px-3 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-600 rounded-lg text-sm text-gray-900 dark:text-zinc-100 focus:outline-none"
                                id="panelUrl"
                            >
                            <a 
                                href="{{ $server->panel_url }}" 
                                target="_blank"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                </svg>
                                <span class="text-sm font-medium">Open</span>
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Panel Type -->
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700/50">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5 text-gray-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                </svg>
                                <p class="text-xs font-semibold text-gray-600 dark:text-zinc-300 uppercase tracking-wide">Panel Type</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">{{ $server->panel_type }}</span>
                        </div>

                        <!-- Port -->
                        @if($server->panel_port)
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700/50">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5 text-gray-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                <p class="text-xs font-semibold text-gray-600 dark:text-zinc-300 uppercase tracking-wide">Port</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-zinc-100 font-mono">{{ $server->panel_port }}</p>
                        </div>
                        @endif

                        <!-- Username -->
                        @if($server->panel_username)
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700/50">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5 text-gray-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <p class="text-xs font-semibold text-gray-600 dark:text-zinc-300 uppercase tracking-wide">Username</p>
                            </div>
                            <div class="flex gap-2 items-center">
                                <p class="text-sm font-medium text-gray-900 dark:text-zinc-100 font-mono" id="panelUsername">{{ $server->panel_username }}</p>
                                <button 
                                    onclick="copyText('{{ $server->panel_username }}', 'Panel username copied!')"
                                    class="text-gray-500 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-zinc-100 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Password -->
                    @if($server->panel_password)
                    <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700/50" x-data="{ showPanelPass: false }">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                            </svg>
                            <p class="text-xs font-semibold text-gray-600 dark:text-zinc-300 uppercase tracking-wide">Password</p>
                        </div>
                        <div class="flex gap-2">
                            <input 
                                :type="showPanelPass ? 'text' : 'password'" 
                                value="{{ $server->panel_password }}"
                                readonly
                                class="flex-1 px-3 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-600 rounded-lg text-sm font-mono text-gray-900 dark:text-zinc-100 focus:outline-none"
                                id="panelPassword"
                            >
                            <button 
                                type="button"
                                @click="showPanelPass = !showPanelPass"
                                class="px-3 py-2 text-gray-600 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-zinc-100 hover:bg-gray-200 dark:hover:bg-zinc-700 border border-gray-300 dark:border-zinc-600 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <svg x-show="!showPanelPass" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <svg x-show="showPanelPass" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                </svg>
                            </button>
                            <button 
                                onclick="copyToClipboard('panelPassword', 'Panel password copied!')"
                                class="px-3 py-2 text-gray-600 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-zinc-100 hover:bg-gray-200 dark:hover:bg-zinc-700 border border-gray-300 dark:border-zinc-600 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Agent Installation -->
        <div class="card p-6">
            <h3 class="section-title mb-4">Agent Installation</h3>
            
            <div class="space-y-4">
                <!-- API Token -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                        API Token
                    </label>
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            value="{{ $server->api_token }}"
                            readonly
                            class="flex-1 px-4 py-2.5 bg-gray-50 dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg font-mono text-sm text-gray-900 dark:text-zinc-100"
                            id="apiToken"
                        >
                        <button 
                            onclick="copyToken()"
                            class="btn btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                            </svg>
                            Copy
                        </button>
                        <form action="{{ route('servers.regenerate-token', $server) }}" method="POST" class="inline" x-data="{
                            async confirmRegenerate(event) {
                                event.preventDefault();
                                const confirmed = await $store.confirm.show({
                                    title: 'Regenerate API Token',
                                    body: 'Token lama akan tidak valid dan agent harus diinstall ulang dengan token baru. Yakin mau lanjut?',
                                    type: 'warning',
                                    confirmText: 'Ya, Generate Baru',
                                    cancelText: 'Batal'
                                });
                                if (confirmed) {
                                    event.target.closest('form').submit();
                                }
                            }
                        }">
                            @csrf
                            <button 
                                type="submit"
                                @click="confirmRegenerate($event)"
                                class="btn btn-warning">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                Regenerate
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Installation Script -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                        Installation Script (Copy & Paste ke VPS)
                    </label>
                    <div class="relative">
                        <pre class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-x-auto text-sm font-mono"><code id="installScript">#!/bin/bash

# Server Monitoring Agent Installer
# Generated for: {{ $server->name }}

API_URL="{{ url('/api/metrics') }}"
API_TOKEN="{{ $server->api_token }}"
SCRIPT_PATH="/usr/local/bin/server-monitor-agent.sh"
SERVICE_PATH="/etc/systemd/system/server-monitor.service"

echo "Installing Server Monitoring Agent..."

# Create monitoring script
cat > $SCRIPT_PATH << 'EOF'
#!/bin/bash

API_URL="__API_URL__"
API_TOKEN="__API_TOKEN__"

# Get CPU usage with fallback
CPU_USAGE=$(top -bn1 | grep "Cpu(s)" | sed "s/.*, *\([0-9.]*\)%* id.*/\1/" | awk '{print 100 - $1}' 2>/dev/null)
[ -z "$CPU_USAGE" ] || [ "$CPU_USAGE" = "100" ] && CPU_USAGE=0

# Get Memory usage with fallback
MEM_INFO=$(free -m | awk 'NR==2{printf "%.2f %.0f %.0f", $3*100/$2, $2, $3 }' 2>/dev/null)
if [ -n "$MEM_INFO" ]; then
    MEM_USAGE=$(echo $MEM_INFO | awk '{print $1}')
    MEM_TOTAL=$(echo $MEM_INFO | awk '{print $2}')
    MEM_USED=$(echo $MEM_INFO | awk '{print $3}')
else
    MEM_USAGE=0
    MEM_TOTAL=0
    MEM_USED=0
fi

# Get Disk usage with fallback
DISK_INFO=$(df / | awk 'NR==2{printf "%.2f", substr($5,1,length($5)-1)}' 2>/dev/null)
if [ -n "$DISK_INFO" ]; then
    DISK_USAGE=$DISK_INFO
    DISK_TOTAL=$(df -BG / | awk 'NR==2{print substr($2,1,length($2)-1)}')
    DISK_USED=$(df -BG / | awk 'NR==2{print substr($3,1,length($3)-1)}')
else
    DISK_USAGE=0
    DISK_TOTAL=0
    DISK_USED=0
fi

# Detect network interface (try common ones)
NET_IFACE="eth0"
[ ! -d "/sys/class/net/$NET_IFACE" ] && NET_IFACE="ens3"
[ ! -d "/sys/class/net/$NET_IFACE" ] && NET_IFACE="ens18"
[ ! -d "/sys/class/net/$NET_IFACE" ] && NET_IFACE="enp0s3"

# Get Network usage with fallback
if [ -d "/sys/class/net/$NET_IFACE" ]; then
    RX1=$(cat /sys/class/net/$NET_IFACE/statistics/rx_bytes 2>/dev/null || echo 0)
    TX1=$(cat /sys/class/net/$NET_IFACE/statistics/tx_bytes 2>/dev/null || echo 0)
    sleep 1
    RX2=$(cat /sys/class/net/$NET_IFACE/statistics/rx_bytes 2>/dev/null || echo 0)
    TX2=$(cat /sys/class/net/$NET_IFACE/statistics/tx_bytes 2>/dev/null || echo 0)
    NETWORK_IN=$(awk "BEGIN {printf \"%.2f\", ($RX2 - $RX1) / 1024}" 2>/dev/null)
    NETWORK_OUT=$(awk "BEGIN {printf \"%.2f\", ($TX2 - $TX1) / 1024}" 2>/dev/null)
else
    NETWORK_IN=0
    NETWORK_OUT=0
fi

# Get Load Average
LOAD_AVG=$(uptime | awk -F'load average:' '{print $2}' | xargs 2>/dev/null)
[ -z "$LOAD_AVG" ] && LOAD_AVG="0, 0, 0"

# Get Uptime (seconds)
UPTIME=$(cat /proc/uptime | awk '{print int($1)}' 2>/dev/null)
[ -z "$UPTIME" ] && UPTIME=0

# Validate values before sending (don't send if all are 0 or empty)
if [ -z "$CPU_USAGE" ] && [ -z "$MEM_USAGE" ] && [ -z "$DISK_USAGE" ]; then
    exit 0
fi

# Send to API
curl -X POST "$API_URL" \
  -H "Authorization: Bearer $API_TOKEN" \
  -H "Content-Type: application/json" \
  -d "{
    \"cpu_usage\": ${CPU_USAGE:-0},
    \"memory_usage\": ${MEM_USAGE:-0},
    \"memory_total\": ${MEM_TOTAL:-0},
    \"memory_used\": ${MEM_USED:-0},
    \"disk_usage\": ${DISK_USAGE:-0},
    \"disk_total\": ${DISK_TOTAL:-0},
    \"disk_used\": ${DISK_USED:-0},
    \"network_in\": ${NETWORK_IN:-0},
    \"network_out\": ${NETWORK_OUT:-0},
    \"load_average\": \"$LOAD_AVG\",
    \"uptime\": ${UPTIME:-0}
  }" \
  -s > /dev/null

EOF

# Replace placeholders
sed -i "s|__API_URL__|$API_URL|g" $SCRIPT_PATH
sed -i "s|__API_TOKEN__|$API_TOKEN|g" $SCRIPT_PATH

chmod +x $SCRIPT_PATH

# Create systemd service
cat > $SERVICE_PATH << EOF
[Unit]
Description=Server Monitoring Agent
After=network.target

[Service]
Type=simple
ExecStart=/bin/bash -c 'while true; do $SCRIPT_PATH; sleep 30; done'
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
EOF

# Enable and start service
systemctl daemon-reload
systemctl enable server-monitor.service
systemctl start server-monitor.service

echo "✓ Installation complete!"
echo "✓ Service started and enabled"
echo ""
echo "Check status: systemctl status server-monitor"
echo "View logs: journalctl -u server-monitor -f"
</code></pre>
                        <button 
                            onclick="copyScript()"
                            class="absolute top-4 right-4 btn btn-success btn-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                            </svg>
                            Copy Script
                        </button>
                    </div>
                </div>

                <!-- Installation Instructions -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Cara Install:</h4>
                    <ol class="list-decimal list-inside space-y-2 text-sm text-blue-800 dark:text-blue-200">
                        <li>SSH ke VPS kamu: <code class="bg-blue-100 dark:bg-blue-950 px-2 py-1 rounded">ssh root@{{ $server->ip_address }}</code></li>
                        <li>Copy script di atas dan paste ke terminal VPS</li>
                        <li>Tekan Enter untuk install</li>
                        <li>Agent akan otomatis kirim metrics setiap 30 detik</li>
                        <li>Refresh halaman ini untuk lihat data real-time!</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToken() {
            const token = document.getElementById('apiToken');
            token.select();
            document.execCommand('copy');
            alert('API Token copied!');
        }

        function copyScript() {
            const script = document.getElementById('installScript').textContent;
            navigator.clipboard.writeText(script).then(() => {
                alert('Installation script copied! Paste di VPS kamu.');
            });
        }

        function copyToClipboard(elementId, message, directValue = null) {
            if (directValue) {
                // Copy direct value (for private key)
                navigator.clipboard.writeText(directValue).then(() => {
                    alert(message);
                });
            } else if (elementId) {
                // Copy from element
                const element = document.getElementById(elementId);
                element.select();
                document.execCommand('copy');
                alert(message);
            }
        }

        function copyText(text, message) {
            navigator.clipboard.writeText(text).then(() => {
                alert(message);
            });
        }
    </script>
</x-app-layout>
