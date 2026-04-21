<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Prevent layout shift - Initialize sidebar and theme state before first paint --}}
        <script>
            (function() {
                // Dark mode
                const theme = localStorage.getItem('theme');
                if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                }
                
                // Sidebar state - store for Alpine to use
                window.__sidebarOpen = localStorage.getItem('sidebarOpen') !== 'false';
            })();
        </script>
        
        <style>
            /* Prevent flash of unstyled content */
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-zinc-950 text-gray-900 dark:text-zinc-100">
        
        <!-- Sidebar -->
        <aside 
            x-data
            :class="$store.sidebar.open ? 'w-64' : 'w-20'" 
            class="fixed left-0 top-0 h-screen bg-zinc-900 border-r border-zinc-800 transition-all duration-300 overflow-y-auto z-40"
            :style="'width: ' + ($store.sidebar.open ? '16rem' : '5rem')">
            <script>
                // Set initial width via inline style before Alpine loads
                (function() {
                    const sidebar = document.currentScript.parentElement;
                    const isOpen = window.__sidebarOpen !== false;
                    sidebar.style.width = isOpen ? '16rem' : '5rem';
                })();
            </script>
            <!-- Logo -->
            <div class="h-16 flex items-center border-b border-zinc-800 px-4" :class="$store.sidebar.open ? 'justify-start pl-6' : 'justify-center'">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="block h-8 w-auto fill-current text-zinc-200" />
                    <span x-show="$store.sidebar.open" x-transition class="text-xl font-bold text-zinc-100">Server</span>
                </a>
            </div>

            <!-- Menu -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('dashboard') }}" :title="!$store.sidebar.open ? 'Dashboard' : ''" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-zinc-300 hover:bg-zinc-800' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                    </svg>
                    <span x-show="$store.sidebar.open" x-transition.opacity.duration.200ms class="font-medium whitespace-nowrap">Dashboard</span>
                </a>

                <a href="{{ route('servers.index') }}" :title="!$store.sidebar.open ? 'Servers' : ''" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('servers.*') ? 'bg-indigo-600 text-white' : 'text-zinc-300 hover:bg-zinc-800' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                    </svg>
                    <span x-show="$store.sidebar.open" x-transition.opacity.duration.200ms class="font-medium whitespace-nowrap">Servers</span>
                </a>

                <a href="{{ route('websites.index') }}" :title="!$store.sidebar.open ? 'Websites' : ''" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('websites.*') ? 'bg-indigo-600 text-white' : 'text-zinc-300 hover:bg-zinc-800' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                    </svg>
                    <span x-show="$store.sidebar.open" x-transition.opacity.duration.200ms class="font-medium whitespace-nowrap">Websites</span>
                </a>

                <a href="{{ route('monitoring') }}" :title="!$store.sidebar.open ? 'Monitoring' : ''" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('monitoring') ? 'bg-indigo-600 text-white' : 'text-zinc-300 hover:bg-zinc-800' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                    <span x-show="$store.sidebar.open" x-transition.opacity.duration.200ms class="font-medium whitespace-nowrap">Monitoring</span>
                </a>

                <a href="{{ route('alerts') }}" :title="!$store.sidebar.open ? 'Alerts' : ''" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('alerts') ? 'bg-indigo-600 text-white' : 'text-zinc-300 hover:bg-zinc-800' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                    </svg>
                    <span x-show="$store.sidebar.open" x-transition.opacity.duration.200ms class="font-medium whitespace-nowrap">Alerts</span>
                </a>
                <a href="{{ route('installation.guide') }}" :title="!$store.sidebar.open ? 'Installation Guide' : ''" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('installation.guide') ? 'bg-indigo-600 text-white' : 'text-zinc-300 hover:bg-zinc-800' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                    <span x-show="$store.sidebar.open" x-transition.opacity.duration.200ms class="font-medium whitespace-nowrap">Installation Guide</span>
                </a>
                <a href="{{ route('reports') }}" :title="!$store.sidebar.open ? 'Reports' : ''" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('reports') ? 'bg-indigo-600 text-white' : 'text-zinc-300 hover:bg-zinc-800' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                    <span x-show="$store.sidebar.open" x-transition.opacity.duration.200ms class="font-medium whitespace-nowrap">Reports</span>
                </a>

                <div class="pt-4 mt-4 border-t border-zinc-800">
                    <a href="{{ route('components.demo') }}" :title="!$store.sidebar.open ? 'Components' : ''" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('components.demo') ? 'bg-indigo-600 text-white' : 'text-zinc-300 hover:bg-zinc-800' }} transition-colors">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/>
                        </svg>
                        <span x-show="$store.sidebar.open" x-transition.opacity.duration.200ms class="font-medium whitespace-nowrap">Components</span>
                    </a>

                    <a href="{{ route('settings') }}" :title="!$store.sidebar.open ? 'Settings' : ''" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('settings') ? 'bg-indigo-600 text-white' : 'text-zinc-300 hover:bg-zinc-800' }} transition-colors">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span x-show="$store.sidebar.open" x-transition.opacity.duration.200ms class="font-medium whitespace-nowrap">Settings</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Navbar -->
        @include('layouts.navigation')

        <!-- Main Content -->
        <main x-data :style="'margin-left: ' + ($store.sidebar.open ? '16rem' : '5rem')" class="pt-16 min-h-screen bg-gray-100 dark:bg-zinc-950 transition-all duration-300">
            <script>
                // Set initial margin via inline style before Alpine loads
                (function() {
                    const main = document.currentScript.parentElement;
                    const isOpen = window.__sidebarOpen !== false;
                    main.style.marginLeft = isOpen ? '16rem' : '5rem';
                })();
            </script>
            {{ $slot }}
        </main>

        <!-- Toast Container -->
        @include('components.toast-container')

        <!-- Confirm Dialog -->
        @include('components.confirm-dialog')
    </body>
</html>
