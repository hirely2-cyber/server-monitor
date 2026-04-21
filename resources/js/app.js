import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

/* ============================================================
   Dark Mode — Apply theme before first paint
   ============================================================ */
(function () {
    const saved = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (saved === 'dark' || (!saved && prefersDark)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();

/* ============================================================
   Alpine Store — Sidebar State (Shared Global State)
   Persisted to localStorage to prevent flashing on page load
   ============================================================ */
Alpine.store('sidebar', {
    // Load initial state from localStorage, default to true
    open: localStorage.getItem('sidebarOpen') !== 'false',
    
    toggle() {
        this.open = !this.open;
        // Save to localStorage
        localStorage.setItem('sidebarOpen', this.open);
    }
});

/* ============================================================
   Alpine Store — Toast Notifications
   Usage:  $dispatch('toast', { message: 'Saved!', type: 'success' })
           OR  window.dispatchEvent(new CustomEvent('toast', { detail: { message:'...', type:'error' } }))
   Types:  success | error | warning | info
   ============================================================ */
Alpine.store('toast', {
    items: [],

    add(message, type = 'success', duration = 4000) {
        const id = Date.now() + Math.random();
        this.items.push({ id, message, type });
        if (duration > 0) {
            setTimeout(() => this.remove(id), duration);
        }
    },

    remove(id) {
        this.items = this.items.filter(item => item.id !== id);
    },

    clear() {
        this.items = [];
    }
});

/* ============================================================
   Alpine Store — Confirmation Dialog
   Usage (async/await):
       const ok = await $store.confirm.show({
           title: 'Hapus Data',
           body: 'Data akan dihapus permanen.',
           type: 'danger',           // danger | warning | info
           confirmText: 'Ya, Hapus',
           cancelText: 'Batal',
       });
       if (ok) { ... }
   ============================================================ */
Alpine.store('confirm', {
    open: false,
    title: 'Konfirmasi',
    body: 'Apakah Anda yakin?',
    confirmText: 'Ya, Lanjutkan',
    cancelText: 'Batal',
    type: 'danger',
    _resolve: null,

    show(options = {}) {
        this.title       = options.title       ?? 'Konfirmasi';
        this.body        = options.body        ?? 'Apakah Anda yakin?';
        this.confirmText = options.confirmText ?? 'Ya, Lanjutkan';
        this.cancelText  = options.cancelText  ?? 'Batal';
        this.type        = options.type        ?? 'danger';
        this.open        = true;
        return new Promise(resolve => { this._resolve = resolve; });
    },

    confirm() {
        this.open = false;
        if (this._resolve) { this._resolve(true);  this._resolve = null; }
    },

    cancel() {
        this.open = false;
        if (this._resolve) { this._resolve(false); this._resolve = null; }
    }
});

Alpine.start();
