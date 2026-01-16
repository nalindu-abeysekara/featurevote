// Import styles
import '../css/app.css';

// Import Alpine.js
import Alpine from 'alpinejs';

// Import HTMX
import htmx from 'htmx.org';

// Make HTMX globally available
window.htmx = htmx;

// Configure HTMX
htmx.config.defaultSwapStyle = 'innerHTML';
htmx.config.historyCacheSize = 0;

// Alpine.js components
Alpine.data('dropdown', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    }
}));

Alpine.data('modal', () => ({
    open: false,
    show() {
        this.open = true;
        document.body.classList.add('overflow-hidden');
    },
    hide() {
        this.open = false;
        document.body.classList.remove('overflow-hidden');
    }
}));

Alpine.data('vote', () => ({
    voted: false,
    count: 0,
    init() {
        this.voted = this.$el.dataset.voted === 'true';
        this.count = parseInt(this.$el.dataset.count) || 0;
    },
    toggle() {
        if (this.voted) {
            this.count--;
        } else {
            this.count++;
        }
        this.voted = !this.voted;
    }
}));

// Start Alpine
Alpine.start();

// Make Alpine globally available
window.Alpine = Alpine;

// HTMX event handlers
document.body.addEventListener('htmx:beforeRequest', (e) => {
    // Add CSRF token to all HTMX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (csrfToken) {
        e.detail.xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    }
});

document.body.addEventListener('htmx:afterSwap', (e) => {
    // Re-initialize Alpine components after HTMX swap
    Alpine.initTree(e.detail.target);
});

// Flash message auto-dismiss
document.body.addEventListener('htmx:afterSettle', () => {
    const flashMessages = document.querySelectorAll('[data-flash-message]');
    flashMessages.forEach(msg => {
        setTimeout(() => {
            msg.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            setTimeout(() => msg.remove(), 300);
        }, 5000);
    });
});
