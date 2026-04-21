{{--
    Toast Container Component
    -------------------------
    Include once in your main layout (app.blade.php).

    Trigger from anywhere:
      Alpine:    $dispatch('toast', { message: 'Berhasil!', type: 'success' })
      JS:        window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Error!', type: 'error' } }))
      PHP/Blade: @php session()->flash('toast', ['message' => '...', 'type' => 'success']) @endphp
      Types:     success | error | warning | info
--}}

@php
    $sessionToast = session('toast');
@endphp

<div
    x-data
    x-on:toast.window="$store.toast.add($event.detail.message, $event.detail.type ?? 'success', $event.detail.duration ?? 4000)"
    class="fixed top-4 right-4 z-[9999] flex flex-col gap-2.5 max-w-sm w-full pointer-events-none"
    aria-live="polite"
    aria-atomic="false"
>
    <template x-for="item in $store.toast.items" :key="item.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8 scale-95"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0 scale-100"
            x-transition:leave-end="opacity-0 translate-x-8 scale-95"
            :class="{
                'bg-white dark:bg-zinc-800 border-green-400 dark:border-green-500':  item.type === 'success',
                'bg-white dark:bg-zinc-800 border-red-400   dark:border-red-500':    item.type === 'error',
                'bg-white dark:bg-zinc-800 border-yellow-400 dark:border-yellow-500':item.type === 'warning',
                'bg-white dark:bg-zinc-800 border-blue-400  dark:border-blue-500':   item.type === 'info',
            }"
            class="flex items-start gap-3 p-4 rounded-2xl border-l-4 shadow-xl pointer-events-auto"
            role="alert"
        >
            {{-- Icon --}}
            <div class="shrink-0 mt-0.5">
                <template x-if="item.type === 'success'">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/40">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                    </div>
                </template>
                <template x-if="item.type === 'error'">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/40">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </template>
                <template x-if="item.type === 'warning'">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900/40">
                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                </template>
                <template x-if="item.type === 'info'">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/40">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                    </div>
                </template>
            </div>

            {{-- Message --}}
            <p class="text-sm font-medium text-gray-800 dark:text-zinc-200 flex-1 pt-1" x-text="item.message"></p>

            {{-- Close Button --}}
            <button
                @click="$store.toast.remove(item.id)"
                class="shrink-0 text-gray-400 hover:text-gray-600 dark:text-zinc-500 dark:hover:text-zinc-300 transition-colors mt-0.5"
                aria-label="Tutup notifikasi"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>

{{-- Flash toast from PHP session --}}
@if($sessionToast)
<script>
    document.addEventListener('alpine:init', () => {
        window.dispatchEvent(new CustomEvent('toast', {
            detail: {
                message: @js($sessionToast['message'] ?? ''),
                type:    @js($sessionToast['type']    ?? 'success'),
            }
        }));
    });
</script>
@endif
