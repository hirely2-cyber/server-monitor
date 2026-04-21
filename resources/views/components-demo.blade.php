<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-zinc-100 leading-tight">
            {{ __('UI Components Demo') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="px-6 lg:px-8 space-y-6">

            {{-- Welcome Card --}}
            <div class="card p-6 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-950/30 dark:to-purple-950/30 border border-indigo-100 dark:border-indigo-900/50">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">
                            UI Components Playground 🎨
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-zinc-400">
                            Test all available UI components: Toast notifications, Confirm dialogs, and Badges.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Toast Notifications Demo --}}
            <div class="card p-6" x-data>
                <h3 class="section-title mb-1">Toast Notifications</h3>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mb-4">
                    Trigger via: <code class="text-xs bg-gray-100 dark:bg-zinc-800 px-2 py-1 rounded font-mono">$dispatch('toast', { message: '...', type: 'success' })</code>
                </p>
                <div class="flex flex-wrap gap-3">
                    <button
                        @click="$dispatch('toast', { message: 'Data berhasil disimpan!', type: 'success' })"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-green-600 hover:bg-green-700 text-white transition-all hover:shadow-lg hover:shadow-green-500/30"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        Success Toast
                    </button>
                    <button
                        @click="$dispatch('toast', { message: 'Terjadi kesalahan pada server!', type: 'error' })"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-red-600 hover:bg-red-700 text-white transition-all hover:shadow-lg hover:shadow-red-500/30"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Error Toast
                    </button>
                    <button
                        @click="$dispatch('toast', { message: 'Perhatikan penggunaan disk yang tinggi!', type: 'warning' })"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-yellow-500 hover:bg-yellow-600 text-white transition-all hover:shadow-lg hover:shadow-yellow-500/30"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374H19.355c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                        Warning Toast
                    </button>
                    <button
                        @click="$dispatch('toast', { message: 'Update tersedia: v2.1.0', type: 'info' })"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white transition-all hover:shadow-lg hover:shadow-blue-500/30"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                        Info Toast
                    </button>
                </div>

                {{-- Code Example --}}
                <div class="mt-6 p-4 bg-gray-50 dark:bg-zinc-900 rounded-xl border border-gray-200 dark:border-zinc-800">
                    <p class="text-xs font-semibold text-gray-700 dark:text-zinc-300 mb-2">Example Code:</p>
                    <pre class="text-xs text-gray-600 dark:text-zinc-400 font-mono overflow-x-auto"><code>$dispatch('toast', {
    message: 'Your custom message here',
    type: 'success',  // success | error | warning | info
    duration: 5000    // optional, default 5000ms
})</code></pre>
                </div>
            </div>

            {{-- Confirm Dialog Demo --}}
            <div class="card p-6" x-data>
                <h3 class="section-title mb-1">Confirm Dialog</h3>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mb-4">
                    Async/await dialog — resolves <code class="text-xs bg-gray-100 dark:bg-zinc-800 px-2 py-1 rounded font-mono">true</code> atau <code class="text-xs bg-gray-100 dark:bg-zinc-800 px-2 py-1 rounded font-mono">false</code>.
                </p>
                <div class="flex flex-wrap gap-3">
                    <button
                        @click="
                            const ok = await $store.confirm.show({
                                title: 'Hapus Server',
                                body: 'Server ini akan dihapus dari monitoring secara permanen. Tindakan ini tidak dapat dibatalkan.',
                                type: 'danger',
                                confirmText: 'Ya, Hapus',
                                cancelText: 'Batal'
                            });
                            if (ok) $dispatch('toast', { message: 'Server berhasil dihapus.', type: 'success' });
                            else    $dispatch('toast', { message: 'Aksi dibatalkan.', type: 'info' });
                        "
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-red-600 hover:bg-red-700 text-white transition-all hover:shadow-lg hover:shadow-red-500/30"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg>
                        Danger Confirm
                    </button>
                    <button
                        @click="
                            const ok = await $store.confirm.show({
                                title: 'Restart Service',
                                body: 'Service akan di-restart. Ini mungkin menyebabkan downtime sementara (±30 detik).',
                                type: 'warning',
                                confirmText: 'Ya, Restart',
                                cancelText: 'Batal'
                            });
                            if (ok) $dispatch('toast', { message: 'Service sedang di-restart...', type: 'warning' });
                        "
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-yellow-500 hover:bg-yellow-600 text-white transition-all hover:shadow-lg hover:shadow-yellow-500/30"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374H19.355c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                        Warning Confirm
                    </button>
                    <button
                        @click="
                            const ok = await $store.confirm.show({
                                title: 'Tambah ke Watchlist',
                                body: 'Server ini akan ditambahkan ke daftar monitoring aktif dan mulai diawasi secara realtime.',
                                type: 'info',
                                confirmText: 'Tambahkan',
                                cancelText: 'Batal'
                            });
                            if (ok) $dispatch('toast', { message: 'Server ditambahkan ke watchlist.', type: 'success' });
                        "
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white transition-all hover:shadow-lg hover:shadow-blue-500/30"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                        Info Confirm
                    </button>
                </div>

                {{-- Code Example --}}
                <div class="mt-6 p-4 bg-gray-50 dark:bg-zinc-900 rounded-xl border border-gray-200 dark:border-zinc-800">
                    <p class="text-xs font-semibold text-gray-700 dark:text-zinc-300 mb-2">Example Code:</p>
                    <pre class="text-xs text-gray-600 dark:text-zinc-400 font-mono overflow-x-auto"><code>const confirmed = await $store.confirm.show({
    title: 'Confirm Action',
    body: 'Are you sure you want to proceed?',
    type: 'danger',        // danger | warning | info
    confirmText: 'Yes',    // optional
    cancelText: 'Cancel'   // optional
});

if (confirmed) {
    // User clicked confirm button
} else {
    // User clicked cancel or closed dialog
}</code></pre>
                </div>
            </div>

            {{-- Badge Demo --}}
            <div class="card p-6">
                <h3 class="section-title mb-4">Badge Variants</h3>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mb-4">
                    Pre-styled badge utilities for status indicators.
                </p>
                
                <div class="space-y-6">
                    {{-- Default Badges --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 dark:text-zinc-300 mb-3">Default Badges</h4>
                        <div class="flex flex-wrap gap-3">
                            <span class="badge badge-green">Online</span>
                            <span class="badge badge-red">Offline</span>
                            <span class="badge badge-yellow">Warning</span>
                            <span class="badge badge-blue">Info</span>
                            <span class="badge badge-gray">Unknown</span>
                        </div>
                    </div>

                    {{-- Large Badges --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 dark:text-zinc-300 mb-3">With Icons</h4>
                        <div class="flex flex-wrap gap-3">
                            <span class="badge badge-green inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                Active
                            </span>
                            <span class="badge badge-red inline-flex items-center gap-1.5">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Error
                            </span>
                            <span class="badge badge-yellow inline-flex items-center gap-1.5">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374H19.355c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                                </svg>
                                Warning
                            </span>
                            <span class="badge badge-blue inline-flex items-center gap-1.5">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                                </svg>
                                Info
                            </span>
                        </div>
                    </div>

                    {{-- Code Example --}}
                    <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-xl border border-gray-200 dark:border-zinc-800">
                        <p class="text-xs font-semibold text-gray-700 dark:text-zinc-300 mb-2">Example Code:</p>
                        <pre class="text-xs text-gray-600 dark:text-zinc-400 font-mono overflow-x-auto"><code>&lt;span class="badge badge-green"&gt;Online&lt;/span&gt;
&lt;span class="badge badge-red"&gt;Offline&lt;/span&gt;
&lt;span class="badge badge-yellow"&gt;Warning&lt;/span&gt;
&lt;span class="badge badge-blue"&gt;Info&lt;/span&gt;
&lt;span class="badge badge-gray"&gt;Unknown&lt;/span&gt;</code></pre>
                    </div>
                </div>
            </div>

            {{-- Card Styles Demo --}}
            <div class="card p-6">
                <h3 class="section-title mb-4">Card Component</h3>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mb-4">
                    Base card utility with automatic dark mode support.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="card p-4">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-zinc-100 mb-2">Default Card</h4>
                        <p class="text-xs text-gray-600 dark:text-zinc-400">Standard card with white background in light mode and zinc-900 in dark mode.</p>
                    </div>
                    <div class="card p-4 hover:shadow-lg transition-shadow duration-200">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-zinc-100 mb-2">Hoverable Card</h4>
                        <p class="text-xs text-gray-600 dark:text-zinc-400">Add hover effect with <code class="text-[10px] bg-gray-100 dark:bg-zinc-800 px-1 rounded">hover:shadow-lg</code></p>
                    </div>
                    <div class="card p-4 border-2 border-indigo-200 dark:border-indigo-800">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-zinc-100 mb-2">Custom Border</h4>
                        <p class="text-xs text-gray-600 dark:text-zinc-400">Override border with custom colors for emphasis.</p>
                    </div>
                </div>

                {{-- Code Example --}}
                <div class="mt-6 p-4 bg-gray-50 dark:bg-zinc-900 rounded-xl border border-gray-200 dark:border-zinc-800">
                    <p class="text-xs font-semibold text-gray-700 dark:text-zinc-300 mb-2">Example Code:</p>
                    <pre class="text-xs text-gray-600 dark:text-zinc-400 font-mono overflow-x-auto"><code>&lt;div class="card p-6"&gt;
    &lt;h3&gt;Card Title&lt;/h3&gt;
    &lt;p&gt;Card content goes here...&lt;/p&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
