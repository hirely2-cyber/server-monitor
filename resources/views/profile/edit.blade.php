<x-app-layout>
    <div class="px-8 py-6 space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Profile Settings</h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">Manage your account information and preferences</p>
            </div>
        </div>

        @if (session('status') === 'profile-updated')
        <div class="card p-4 border-l-4 bg-green-50 dark:bg-green-900/10 border-green-500">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium text-green-900 dark:text-green-100">Profile updated successfully.</p>
            </div>
        </div>
        @endif

        @if (session('status') === 'password-updated')
        <div class="card p-4 border-l-4 bg-green-50 dark:bg-green-900/10 border-green-500">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium text-green-900 dark:text-green-100">Password updated successfully.</p>
            </div>
        </div>
        @endif

        <!-- Profile Information -->
        <div class="card p-6">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password -->
        <div class="card p-6">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account -->
        <div class="card p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
