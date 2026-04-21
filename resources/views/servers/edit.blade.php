<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Edit Server</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Update server information</p>
            </div>
            <a href="{{ route('servers.show', $server) }}" class="inline-flex items-center px-4 py-2.5 bg-gray-600 hover:bg-gray-700 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Back to Details
            </a>
        </div>

        <div class="card p-6">
            <form action="{{ route('servers.update', $server) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Grid Layout for Form Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Server Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            Server Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $server->name) }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            required
                        >
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hostname -->
                    <div>
                        <label for="hostname" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            Hostname
                        </label>
                        <input 
                            type="text" 
                            name="hostname" 
                            id="hostname" 
                            value="{{ old('hostname', $server->hostname) }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                        >
                        @error('hostname')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- IP Address -->
                    <div>
                        <label for="ip_address" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            IP Address <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="ip_address" 
                            id="ip_address" 
                            value="{{ old('ip_address', $server->ip_address) }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            required
                        >
                        @error('ip_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            Location
                        </label>
                        <input 
                            type="text" 
                            name="location" 
                            id="location" 
                            value="{{ old('location', $server->location) }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                        >
                        @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Provider -->
                    <div>
                        <label for="provider" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            Provider
                        </label>
                        <input 
                            type="text" 
                            name="provider" 
                            id="provider" 
                            value="{{ old('provider', $server->provider) }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                        >
                        @error('provider')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Operating System -->
                    <div>
                        <label for="os" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            Operating System
                        </label>
                        <input 
                            type="text" 
                            name="os" 
                            id="os" 
                            value="{{ old('os', $server->os) }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                        >
                        @error('os')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- SSH Access Section -->
                <div class="border-t border-gray-200 dark:border-zinc-700 pt-6">
                    <h3 class="section-title mb-4">🔐 SSH Access (Optional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- SSH Username -->
                        <div>
                            <label for="ssh_username" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                                SSH Username
                            </label>
                            <input 
                                type="text" 
                                name="ssh_username" 
                                id="ssh_username" 
                                value="{{ old('ssh_username', $server->ssh_username) }}"
                                class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                                placeholder="root atau username lain"
                            >
                            @error('ssh_username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SSH Port -->
                        <div>
                            <label for="ssh_port" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                                SSH Port
                            </label>
                            <input 
                                type="number" 
                                name="ssh_port" 
                                id="ssh_port" 
                                value="{{ old('ssh_port', $server->ssh_port ?? 22) }}"
                                class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                                placeholder="22"
                            >
                            @error('ssh_port')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SSH Password -->
                        <div>
                            <label for="ssh_password" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                                SSH Password
                            </label>
                            <div class="relative" x-data="{ show: false }">
                                <input 
                                    :type="show ? 'text' : 'password'" 
                                    name="ssh_password" 
                                    id="ssh_password" 
                                    class="w-full px-4 py-2 pr-10 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                                    placeholder="••••••••{{ $server->ssh_password ? ' (tersimpan)' : '' }}"
                                    autocomplete="new-password"
                                >
                                <button 
                                    type="button" 
                                    @click="show = !show"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-200"
                                >
                                    <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                    </svg>
                                    <svg x-show="show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Kosongkan jika tidak ingin mengubah</p>
                            @error('ssh_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SSH Private Key -->
                        <div class="md:col-span-2">
                            <label for="ssh_private_key" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                                SSH Private Key (Optional)
                            </label>
                            <textarea 
                                name="ssh_private_key" 
                                id="ssh_private_key" 
                                rows="4"
                                class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100 font-mono text-xs"
                                placeholder="-----BEGIN RSA PRIVATE KEY-----&#10;{{ $server->ssh_private_key ? '(Key tersimpan - edit untuk ganti)' : 'Paste private key disini' }}&#10;-----END RSA PRIVATE KEY-----"
                            >{{ old('ssh_private_key') }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Kosongkan jika tidak ingin mengubah</p>
                            @error('ssh_private_key')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Panel Access Section -->
                <div class="border-t border-gray-200 dark:border-zinc-700 pt-6">
                    <h3 class="section-title mb-4">🎛️ Panel Access (Optional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Panel Type -->
                        <div>
                            <label for="panel_type" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                                Panel Type
                            </label>
                            <select 
                                name="panel_type" 
                                id="panel_type" 
                                class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            >
                                <option value="None" {{ old('panel_type', $server->panel_type) == 'None' ? 'selected' : '' }}>None</option>
                                <option value="aaPanel" {{ old('panel_type', $server->panel_type) == 'aaPanel' ? 'selected' : '' }}>aaPanel</option>
                                <option value="cPanel" {{ old('panel_type', $server->panel_type) == 'cPanel' ? 'selected' : '' }}>cPanel</option>
                                <option value="DirectAdmin" {{ old('panel_type', $server->panel_type) == 'DirectAdmin' ? 'selected' : '' }}>DirectAdmin</option>
                                <option value="Plesk" {{ old('panel_type', $server->panel_type) == 'Plesk' ? 'selected' : '' }}>Plesk</option>
                                <option value="Custom" {{ old('panel_type', $server->panel_type) == 'Custom' ? 'selected' : '' }}>Custom/Other</option>
                            </select>
                            @error('panel_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Panel Port -->
                        <div>
                            <label for="panel_port" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                                Panel Port
                            </label>
                            <input 
                                type="number" 
                                name="panel_port" 
                                id="panel_port" 
                                value="{{ old('panel_port', $server->panel_port) }}"
                                class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                                placeholder="8888 untuk aaPanel, 2087 untuk cPanel"
                            >
                            @error('panel_port')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Panel URL -->
                        <div class="md:col-span-2">
                            <label for="panel_url" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                                Panel URL
                            </label>
                            <input 
                                type="text" 
                                name="panel_url" 
                                id="panel_url" 
                                value="{{ old('panel_url', $server->panel_url) }}"
                                class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                                placeholder="https://103.28.36.10:8888 atau https://panel.example.com"
                            >
                            @error('panel_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Panel Username -->
                        <div>
                            <label for="panel_username" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                                Panel Username
                            </label>
                            <input 
                                type="text" 
                                name="panel_username" 
                                id="panel_username" 
                                value="{{ old('panel_username', $server->panel_username) }}"
                                class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                                placeholder="admin"
                            >
                            @error('panel_username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Panel Password -->
                        <div>
                            <label for="panel_password" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                                Panel Password
                            </label>
                            <div class="relative" x-data="{ show: false }">
                                <input 
                                    :type="show ? 'text' : 'password'" 
                                    name="panel_password" 
                                    id="panel_password" 
                                    class="w-full px-4 py-2 pr-10 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                                    placeholder="••••••••{{ $server->panel_password ? ' (tersimpan)' : '' }}"
                                    autocomplete="new-password"
                                >
                                <button 
                                    type="button" 
                                    @click="show = !show"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-200"
                                >
                                    <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                    </svg>
                                    <svg x-show="show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Kosongkan jika tidak ingin mengubah</p>
                            @error('panel_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        Update Server
                    </button>
                    <a href="{{ route('servers.show', $server) }}" class="inline-flex items-center px-4 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-gray-700 dark:text-zinc-300 text-sm font-medium rounded-lg transition-all duration-200 border border-gray-300 dark:border-zinc-700">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
