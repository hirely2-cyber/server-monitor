<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Edit Website</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Update website monitoring configuration</p>
            </div>
            <a href="{{ route('websites.show', $website) }}" class="inline-flex items-center px-4 py-2.5 bg-gray-600 hover:bg-gray-700 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Back to Details
            </a>
        </div>

        <div class="card p-6">
            <form action="{{ route('websites.update', $website) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Grid Layout for Form Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Website Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            Website Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $website->name) }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            placeholder="My Portfolio Website"
                            required
                        >
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL -->
                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            URL <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="url" 
                            name="url" 
                            id="url" 
                            value="{{ old('url', $website->url) }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            placeholder="https://example.com"
                            required
                        >
                        @error('url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Server -->
                    <div>
                        <label for="server_id" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            Server (Optional)
                        </label>
                        <select 
                            name="server_id" 
                            id="server_id"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                        >
                            <option value="">- No Server -</option>
                            @foreach($servers as $server)
                            <option value="{{ $server->id }}" {{ old('server_id', $website->server_id) == $server->id ? 'selected' : '' }}>
                                {{ $server->name }} ({{ $server->ip_address }})
                            </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Link website to server if hosted on your VPS</p>
                        @error('server_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            Type <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="type" 
                            id="type"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            required
                        >
                            <option value="laravel" {{ old('type', $website->type) == 'laravel' ? 'selected' : '' }}>Laravel</option>
                            <option value="wordpress" {{ old('type', $website->type) == 'wordpress' ? 'selected' : '' }}>WordPress</option>
                            <option value="static" {{ old('type', $website->type) == 'static' ? 'selected' : '' }}>Static HTML</option>
                            <option value="php" {{ old('type', $website->type) == 'php' ? 'selected' : '' }}>PHP</option>
                            <option value="other" {{ old('type', $website->type) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Document Root -->
                    <div>
                        <label for="document_root" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            Document Root (Optional)
                        </label>
                        <input 
                            type="text" 
                            name="document_root" 
                            id="document_root" 
                            value="{{ old('document_root', $website->document_root) }}"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            placeholder="/var/www/html/public"
                        >
                        <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Path to website root on server</p>
                        @error('document_root')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Check Interval -->
                    <div>
                        <label for="check_interval" class="block text-sm font-medium text-gray-900 dark:text-zinc-100 mb-2">
                            Check Interval (seconds) <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="check_interval" 
                            id="check_interval"
                            class="w-full px-4 py-2 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-zinc-100"
                            required
                        >
                            <option value="30" {{ old('check_interval', $website->check_interval) == 30 ? 'selected' : '' }}>30 seconds</option>
                            <option value="60" {{ old('check_interval', $website->check_interval) == 60 ? 'selected' : '' }}>1 minute</option>
                            <option value="300" {{ old('check_interval', $website->check_interval) == 300 ? 'selected' : '' }}>5 minutes</option>
                            <option value="600" {{ old('check_interval', $website->check_interval) == 600 ? 'selected' : '' }}>10 minutes</option>
                            <option value="1800" {{ old('check_interval', $website->check_interval) == 1800 ? 'selected' : '' }}>30 minutes</option>
                            <option value="3600" {{ old('check_interval', $website->check_interval) == 3600 ? 'selected' : '' }}>1 hour</option>
                        </select>
                        <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">How often to check website status</p>
                        @error('check_interval')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-zinc-700">
                    <a href="{{ route('websites.show', $website) }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        Update Website
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
