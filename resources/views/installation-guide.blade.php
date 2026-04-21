<x-app-layout>
    <div class="px-8 py-6 space-y-6" x-data="{ activeTab: 'python' }">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Installation Guide</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Setup monitoring agent di VPS/Server anda</p>
            </div>
            <a href="{{ route('servers.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Back to Servers
            </a>
        </div>

        <!-- Info Card -->
        <div class="card p-6 bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800">
            <div class="flex gap-3">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-100">Tentang Monitoring Agent</h3>
                    <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">Agent adalah script yang berjalan di server anda untuk mengirim metrics (CPU, Memory, Disk, Network) ke dashboard ini. Pilih Python atau Bash sesuai kebutuhan.</p>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="card overflow-hidden">
            <div class="border-b border-gray-200 dark:border-zinc-700">
                <div class="flex">
                    <button 
                        @click="activeTab = 'python'"
                        :class="activeTab === 'python' ? 'border-indigo-600 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14.25.18l.9.2.73.26.59.3.45.32.34.34.25.34.16.33.1.3.04.26.02.2-.01.13V8.5l-.05.63-.13.55-.21.46-.26.38-.3.31-.33.25-.35.19-.35.14-.33.1-.3.07-.26.04-.21.02H8.77l-.69.05-.59.14-.5.22-.41.27-.33.32-.27.35-.2.36-.15.37-.1.35-.07.32-.04.27-.02.21v3.06H3.17l-.21-.03-.28-.07-.32-.12-.35-.18-.36-.26-.36-.36-.35-.46-.32-.59-.28-.73-.21-.88-.14-1.05-.05-1.23.06-1.22.16-1.04.24-.87.32-.71.36-.57.4-.44.42-.33.42-.24.4-.16.36-.1.32-.05.24-.01h.16l.06.01h8.16v-.83H6.18l-.01-2.75-.02-.37.05-.34.11-.31.17-.28.25-.26.31-.23.38-.2.44-.18.51-.15.58-.12.64-.1.71-.06.77-.04.84-.02 1.27.05zm-6.3 1.98l-.23.33-.08.41.08.41.23.34.33.22.41.09.41-.09.33-.22.23-.34.08-.41-.08-.41-.23-.33-.33-.22-.41-.09-.41.09zm13.09 3.95l.28.06.32.12.35.18.36.27.36.35.35.47.32.59.28.73.21.88.14 1.04.05 1.23-.06 1.23-.16 1.04-.24.86-.32.71-.36.57-.4.45-.42.33-.42.24-.4.16-.36.09-.32.05-.24.02-.16-.01h-8.22v.82h5.84l.01 2.76.02.36-.05.34-.11.31-.17.29-.25.25-.31.24-.38.2-.44.17-.51.15-.58.13-.64.09-.71.07-.77.04-.84.01-1.27-.04-1.07-.14-.9-.2-.73-.25-.59-.3-.45-.33-.34-.34-.25-.34-.16-.33-.1-.3-.04-.25-.02-.2.01-.13v-5.34l.05-.64.13-.54.21-.46.26-.38.3-.32.33-.24.35-.2.35-.14.33-.1.3-.06.26-.04.21-.02.13-.01h5.84l.69-.05.59-.14.5-.21.41-.28.33-.32.27-.35.2-.36.15-.36.1-.35.07-.32.04-.28.02-.21V6.07h2.09l.14.01.21.03zm-6.47 14.25l-.23.33-.08.41.08.41.23.33.33.23.41.08.41-.08.33-.23.23-.33.08-.41-.08-.41-.23-.33-.33-.23-.41-.08-.41.08z"/>
                            </svg>
                            Python Agent (Recommended)
                        </div>
                    </button>
                    <button 
                        @click="activeTab = 'bash'"
                        :class="activeTab === 'bash' ? 'border-indigo-600 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            Bash Script (Lightweight)
                        </div>
                    </button>
                </div>
            </div>

            <!-- Python Tab Content -->
            <div x-show="activeTab === 'python'" class="p-6 space-y-6">
                <!-- Step 1 -->
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold flex-shrink-0">1</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">Install Dependencies</h3>
                            <p class="text-sm text-gray-600 dark:text-zinc-400 mt-1">Install Python 3 dan required packages</p>
                        </div>
                    </div>
                    <div class="ml-11">
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>pip3 install psutil requests</code></pre>
                            <button @click="navigator.clipboard.writeText('pip3 install psutil requests'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold flex-shrink-0">2</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">Download Agent Script</h3>
                            <p class="text-sm text-gray-600 dark:text-zinc-400 mt-1">Download monitoring script ke server</p>
                        </div>
                    </div>
                    <div class="ml-11">
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>wget {{ url('/agent/monitor.py') }}
chmod +x monitor.py</code></pre>
                            <button @click="navigator.clipboard.writeText('wget {{ url('/agent/monitor.py') }}\nchmod +x monitor.py'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold flex-shrink-0">3</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">Get API Token</h3>
                            <p class="text-sm text-gray-600 dark:text-zinc-400 mt-1">Copy API Token dari server details page</p>
                        </div>
                    </div>
                    <div class="ml-11">
                        <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                            <p class="text-sm text-amber-800 dark:text-amber-200">
                                <strong>📍 Lokasi Token:</strong> Buka halaman <a href="{{ route('servers.index') }}" class="underline hover:no-underline">Servers</a> → Click server → Copy API Token dari bagian "Installation Script"
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold flex-shrink-0">4</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">Test Run</h3>
                            <p class="text-sm text-gray-600 dark:text-zinc-400 mt-1">Coba jalankan agent untuk test koneksi</p>
                        </div>
                    </div>
                    <div class="ml-11">
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>python3 monitor.py \
  --token YOUR_API_TOKEN \
  --url {{ url('/api') }}</code></pre>
                            <button @click="navigator.clipboard.writeText('python3 monitor.py --token YOUR_API_TOKEN --url {{ url('/api') }}'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-zinc-400 mt-2">Jika berhasil, akan muncul: <code class="text-green-600 dark:text-green-400">✓ Metrics sent successfully</code></p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold flex-shrink-0">5</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">Setup Systemd Service (Auto-start)</h3>
                            <p class="text-sm text-gray-600 dark:text-zinc-400 mt-1">Jalankan agent otomatis saat boot</p>
                        </div>
                    </div>
                    <div class="ml-11 space-y-3">
                        <p class="text-sm text-gray-700 dark:text-zinc-300">Buat file service:</p>
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>sudo nano /etc/systemd/system/server-monitor.service</code></pre>
                            <button @click="navigator.clipboard.writeText('sudo nano /etc/systemd/system/server-monitor.service'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>

                        <p class="text-sm text-gray-700 dark:text-zinc-300">Paste konfigurasi berikut:</p>
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>[Unit]
Description=Server Monitoring Agent
After=network.target

[Service]
Type=simple
User=root
WorkingDirectory=/opt/monitoring
ExecStart=/usr/bin/python3 /opt/monitoring/monitor.py \
  --token YOUR_API_TOKEN \
  --url {{ url('/api') }} \
  --interval 60
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target</code></pre>
                            <button @click="navigator.clipboard.writeText('[Unit]\nDescription=Server Monitoring Agent\nAfter=network.target\n\n[Service]\nType=simple\nUser=root\nWorkingDirectory=/opt/monitoring\nExecStart=/usr/bin/python3 /opt/monitoring/monitor.py --token YOUR_API_TOKEN --url {{ url('/api') }} --interval 60\nRestart=always\nRestartSec=10\n\n[Install]\nWantedBy=multi-user.target'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>

                        <p class="text-sm text-gray-700 dark:text-zinc-300">Enable dan start service:</p>
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>sudo systemctl daemon-reload
sudo systemctl enable server-monitor
sudo systemctl start server-monitor
sudo systemctl status server-monitor</code></pre>
                            <button @click="navigator.clipboard.writeText('sudo systemctl daemon-reload\nsudo systemctl enable server-monitor\nsudo systemctl start server-monitor\nsudo systemctl status server-monitor'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-green-900 dark:text-green-100">Setup Complete!</p>
                            <p class="text-sm text-green-700 dark:text-green-300 mt-1">Agent akan otomatis mengirim metrics setiap 60 detik. Check di halaman dashboard untuk lihat data real-time!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bash Tab Content -->
            <div x-show="activeTab === 'bash'" class="p-6 space-y-6">
                <!-- Step 1 -->
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold flex-shrink-0">1</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">Download Bash Script</h3>
                            <p class="text-sm text-gray-600 dark:text-zinc-400 mt-1">Download script dan buat executable</p>
                        </div>
                    </div>
                    <div class="ml-11">
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>wget {{ url('/agent/monitor.sh') }}
chmod +x monitor.sh</code></pre>
                            <button @click="navigator.clipboard.writeText('wget {{ url('/agent/monitor.sh') }}\nchmod +x monitor.sh'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold flex-shrink-0">2</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">Get API Token</h3>
                            <p class="text-sm text-gray-600 dark:text-zinc-400 mt-1">Copy API Token dari server details page</p>
                        </div>
                    </div>
                    <div class="ml-11">
                        <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                            <p class="text-sm text-amber-800 dark:text-amber-200">
                                <strong>📍 Lokasi Token:</strong> Buka halaman <a href="{{ route('servers.index') }}" class="underline hover:no-underline">Servers</a> → Click server → Copy API Token dari bagian "Installation Script"
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold flex-shrink-0">3</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">Test Run</h3>
                            <p class="text-sm text-gray-600 dark:text-zinc-400 mt-1">Coba jalankan script untuk test koneksi</p>
                        </div>
                    </div>
                    <div class="ml-11">
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>./monitor.sh YOUR_API_TOKEN {{ url('/api') }}</code></pre>
                            <button @click="navigator.clipboard.writeText('./monitor.sh YOUR_API_TOKEN {{ url('/api') }}'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-zinc-400 mt-2">Jika berhasil, akan muncul: <code class="text-green-600 dark:text-green-400">✓ Metrics sent successfully</code></p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold flex-shrink-0">4</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100">Setup Cron Job (Auto-run)</h3>
                            <p class="text-sm text-gray-600 dark:text-zinc-400 mt-1">Jalankan script setiap menit via cron</p>
                        </div>
                    </div>
                    <div class="ml-11 space-y-3">
                        <p class="text-sm text-gray-700 dark:text-zinc-300">Edit crontab:</p>
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>crontab -e</code></pre>
                            <button @click="navigator.clipboard.writeText('crontab -e'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>

                        <p class="text-sm text-gray-700 dark:text-zinc-300">Tambahkan baris berikut (jalankan setiap menit):</p>
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>* * * * * /opt/monitoring/monitor.sh YOUR_TOKEN {{ url('/api') }} >> /var/log/monitor.log 2>&1</code></pre>
                            <button @click="navigator.clipboard.writeText('* * * * * /opt/monitoring/monitor.sh YOUR_TOKEN {{ url('/api') }} >> /var/log/monitor.log 2>&1'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>

                        <p class="text-sm text-gray-700 dark:text-zinc-300">View logs untuk monitoring:</p>
                        <div class="relative" x-data="{ copied: false }">
                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code>tail -f /var/log/monitor.log</code></pre>
                            <button @click="navigator.clipboard.writeText('tail -f /var/log/monitor.log'); copied = true; setTimeout(() => copied = false, 2000)" class="absolute top-2 right-2 p-2 bg-gray-800 hover:bg-gray-700 rounded text-gray-400 hover:text-white transition-colors">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-green-900 dark:text-green-100">Setup Complete!</p>
                            <p class="text-sm text-green-700 dark:text-green-300 mt-1">Script akan otomatis mengirim metrics setiap menit via cron. Check logs dan dashboard untuk verify!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Troubleshooting -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-zinc-100 mb-4">🛠️ Troubleshooting</h3>
            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-zinc-100 mb-1">❌ Connection refused</h4>
                    <p class="text-sm text-gray-600 dark:text-zinc-400">Check firewall dan pastikan URL API correct. Test dengan <code class="bg-gray-200 dark:bg-zinc-800 px-2 py-1 rounded text-sm">curl -I {{ url('/api') }}</code></p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-zinc-100 mb-1">🔒 Invalid API token (401)</h4>
                    <p class="text-sm text-gray-600 dark:text-zinc-400">Token salah atau expired. Copy token baru dari server details page dan regenerate jika perlu.</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-zinc-100 mb-1">🐍 Python modules not found</h4>
                    <p class="text-sm text-gray-600 dark:text-zinc-400">Install dependencies: <code class="bg-gray-200 dark:bg-zinc-800 px-2 py-1 rounded text-sm">pip3 install --upgrade psutil requests</code></p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-zinc-100 mb-1">⚠️ Permission denied</h4>
                    <p class="text-sm text-gray-600 dark:text-zinc-400">Run dengan sudo atau fix file permissions: <code class="bg-gray-200 dark:bg-zinc-800 px-2 py-1 rounded text-sm">chmod +x monitor.py</code></p>
                </div>
            </div>
        </div>

        <!-- Support Card -->
        <div class="card p-6 bg-gray-50 dark:bg-zinc-900">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-gray-600 dark:text-zinc-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-zinc-100">Need Help?</h3>
                    <p class="text-sm text-gray-600 dark:text-zinc-400 mt-1">
                        Jika masih ada masalah, pastikan:
                    </p>
                    <ul class="text-sm text-gray-600 dark:text-zinc-400 mt-2 space-y-1 list-disc list-inside">
                        <li>Network connectivity dari server ke dashboard OK</li>
                        <li>API Token valid dan belum expired</li>
                        <li>Agent script sudah executable (chmod +x)</li>
                        <li>Dependencies sudah terinstall (untuk Python)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
