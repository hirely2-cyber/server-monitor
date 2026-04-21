{{--
    Confirm Dialog Component
    ------------------------
    Include once in your main layout (app.blade.php).

    Usage from Alpine.js (async/await):
        async function deleteItem() {
            const ok = await $store.confirm.show({
                title:       'Hapus Data',
                body:        'Data ini akan dihapus secara permanen.',
                type:        'danger',     // danger | warning | info
                confirmText: 'Ya, Hapus',
                cancelText:  'Batal',
            });
            if (ok) {
                // lanjutkan aksi
            }
        }
--}}

<div
    x-data
    x-show="$store.confirm.open"
    x-on:keydown.escape.window="$store.confirm.cancel()"
    class="fixed inset-0 z-[9998] flex items-center justify-center p-4"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    :aria-labelledby="$store.confirm.open ? 'confirm-title' : null"
>
    {{-- Backdrop --}}
    <div
        x-show="$store.confirm.open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="$store.confirm.cancel()"
        class="absolute inset-0 bg-black/50 backdrop-blur-sm"
    ></div>

    {{-- Panel --}}
    <div
        x-show="$store.confirm.open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="relative w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl p-6 border border-gray-100 dark:border-zinc-700"
    >
        {{-- Icon --}}
        <div
            class="flex items-center justify-center w-14 h-14 rounded-full mx-auto mb-4"
            :class="{
                'bg-red-100    dark:bg-red-900/30':    $store.confirm.type === 'danger',
                'bg-yellow-100 dark:bg-yellow-900/30': $store.confirm.type === 'warning',
                'bg-blue-100   dark:bg-blue-900/30':   $store.confirm.type === 'info',
            }"
        >
            <template x-if="$store.confirm.type === 'danger'">
                <svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </template>
            <template x-if="$store.confirm.type === 'warning'">
                <svg class="w-7 h-7 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </template>
            <template x-if="$store.confirm.type === 'info'">
                <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                </svg>
            </template>
        </div>

        {{-- Title --}}
        <h3
            id="confirm-title"
            class="text-lg font-bold text-center text-gray-900 dark:text-zinc-100 mb-2"
            x-text="$store.confirm.title"
        ></h3>

        {{-- Body --}}
        <p
            class="text-sm text-center text-gray-500 dark:text-zinc-400 mb-7 leading-relaxed"
            x-text="$store.confirm.body"
        ></p>

        {{-- Buttons --}}
        <div class="flex gap-3">
            <button
                @click="$store.confirm.cancel()"
                class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold border border-gray-300 dark:border-zinc-700 text-gray-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-zinc-600 transition-all duration-150"
                x-text="$store.confirm.cancelText"
            ></button>

            <button
                @click="$store.confirm.confirm()"
                class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-zinc-900 transition-all duration-150"
                :class="{
                    'bg-red-600    hover:bg-red-700    focus:ring-red-500':    $store.confirm.type === 'danger',
                    'bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-400': $store.confirm.type === 'warning',
                    'bg-blue-600   hover:bg-blue-700   focus:ring-blue-500':   $store.confirm.type === 'info',
                }"
                x-text="$store.confirm.confirmText"
            ></button>
        </div>
    </div>
</div>
