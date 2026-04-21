<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Add New Server</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Tambahkan VPS/Server baru untuk monitoring</p>
            </div>
            <a href="{{ route('servers.index') }}" class="inline-flex items-center px-4 py-2.5 bg-gray-600 hover:bg-gray-700 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Back to List
            </a>
        </div>

        <div class="card p-6">
            <form action="{{ route('servers.store') }}" method="POST" class="space-y-6">
                @csrf

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
                            value="{{ old('name') }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            placeholder="VPS Singapore 1"
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
                            value="{{ old('hostname') }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            placeholder="sg1.example.com"
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
                            value="{{ old('ip_address') }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            placeholder="103.28.36.10"
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
                            value="{{ old('location') }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            placeholder="Singapore"
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
                            value="{{ old('provider') }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            placeholder="DigitalOcean, Linode, AWS, etc"
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
                            value="{{ old('os') }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            placeholder="Ubuntu 22.04 LTS"
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
                                value="{{ old('ssh_username') }}"
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
                                value="{{ old('ssh_port', 22) }}"
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
                                    placeholder="••••••••"
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
                                placeholder="-----BEGIN RSA PRIVATE KEY-----&#10;MIIEpQIBAAKCAQEA...&#10;-----END RSA PRIVATE KEY-----"
                            >{{ old('ssh_private_key') }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Opsional: paste private key untuk SSH key-based authentication</p>
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
                                <option value="None" {{ old('panel_type') == 'None' ? 'selected' : '' }}>None</option>
                                <option value="aaPanel" {{ old('panel_type') == 'aaPanel' ? 'selected' : '' }}>aaPanel</option>
                                <option value="cPanel" {{ old('panel_type') == 'cPanel' ? 'selected' : '' }}>cPanel</option>
                                <option value="DirectAdmin" {{ old('panel_type') == 'DirectAdmin' ? 'selected' : '' }}>DirectAdmin</option>
                                <option value="Plesk" {{ old('panel_type') == 'Plesk' ? 'selected' : '' }}>Plesk</option>
                                <option value="Custom" {{ old('panel_type') == 'Custom' ? 'selected' : '' }}>Custom/Other</option>
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
                                value="{{ old('panel_port') }}"
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
                                value="{{ old('panel_url') }}"
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
                                value="{{ old('panel_username') }}"
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
                                    placeholder="••••••••"
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
                            @error('panel_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                        <div class="text-sm text-blue-800 dark:text-blue-200">
                            <p class="font-medium mb-1">Setelah save, kamu akan dapat:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>API Token untuk install agent</li>
                                <li>Bash script untuk copy ke VPS</li>
                                <li>Instruksi lengkap cara install</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Create Server
                    </button>
                    <a href="{{ route('servers.index') }}" class="inline-flex items-center px-4 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-gray-700 dark:text-zinc-300 text-sm font-medium rounded-lg transition-all duration-200 border border-gray-300 dark:border-zinc-700">
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
