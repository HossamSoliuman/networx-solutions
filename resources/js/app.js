import './bootstrap';

// ---------------------------------------------------------------------------
// Public site navigation.
// ---------------------------------------------------------------------------
const siteHeader = document.querySelector('[data-site-header]');
const siteMenu = document.querySelector('[data-site-menu]');
const siteMenuToggle = document.querySelector('[data-site-menu-toggle]');

const closeSiteMenu = () => {
    siteMenu?.classList.add('hidden');
    siteMenuToggle?.setAttribute('aria-expanded', 'false');
};

siteMenuToggle?.addEventListener('click', () => {
    const isOpening = siteMenu?.classList.contains('hidden');

    siteMenu?.classList.toggle('hidden');
    siteMenuToggle.setAttribute('aria-expanded', String(isOpening));
});

siteMenu?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', closeSiteMenu);
});

window.addEventListener(
    'scroll',
    () => {
        siteHeader?.classList.toggle('shadow-sm', window.scrollY > 12);
    },
    { passive: true },
);

// ---------------------------------------------------------------------------
// Dropdown menus: [data-dropdown] wraps a [data-dropdown-trigger] button and a
// [data-dropdown-menu] panel. Click toggles; clicking elsewhere or Escape closes.
// ---------------------------------------------------------------------------
document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-dropdown-trigger]');

    document.querySelectorAll('[data-dropdown-menu]').forEach((menu) => {
        const container = menu.closest('[data-dropdown]');

        if (trigger && container.contains(trigger)) {
            menu.classList.toggle('hidden');
        } else if (!menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        document.querySelectorAll('[data-dropdown-menu]').forEach((menu) => menu.classList.add('hidden'));
        closeSiteMenu();
    }
});

// ---------------------------------------------------------------------------
// Modals: <dialog> elements opened by [data-modal-open="id"], closed by
// [data-modal-close] buttons or a backdrop click.
// ---------------------------------------------------------------------------
document.addEventListener('click', (event) => {
    const opener = event.target.closest('[data-modal-open]');
    if (opener) {
        document.getElementById(opener.dataset.modalOpen)?.showModal();
        return;
    }

    if (event.target.closest('[data-modal-close]')) {
        event.target.closest('dialog')?.close();
        return;
    }

    // Backdrop click: target is the dialog itself, not its inner panel.
    if (event.target instanceof HTMLDialogElement) {
        event.target.close();
    }
});

// ---------------------------------------------------------------------------
// Mobile sidebar drawer.
// ---------------------------------------------------------------------------
const sidebar = document.querySelector('[data-sidebar]');
const overlay = document.querySelector('[data-sidebar-overlay]');

document.querySelectorAll('[data-sidebar-toggle]').forEach((toggle) => {
    toggle.addEventListener('click', () => {
        sidebar?.classList.toggle('-translate-x-full');
        overlay?.classList.toggle('hidden');
    });
});

overlay?.addEventListener('click', () => {
    sidebar?.classList.add('-translate-x-full');
    overlay?.classList.add('hidden');
});

// ---------------------------------------------------------------------------
// Flash toasts fade out automatically.
// ---------------------------------------------------------------------------
document.querySelectorAll('[data-flash]').forEach((flash) => {
    setTimeout(() => {
        flash.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => flash.remove(), 300);
    }, 4500);
});

// ---------------------------------------------------------------------------
// Filter forms: selects marked [data-autosubmit] submit their form on change.
// ---------------------------------------------------------------------------
document.querySelectorAll('[data-autosubmit]').forEach((control) => {
    control.addEventListener('change', () => control.form?.submit());
});

// ---------------------------------------------------------------------------
// Bulk selection on the messages index.
// ---------------------------------------------------------------------------
const bulkForm = document.querySelector('[data-bulk-form]');

if (bulkForm) {
    const master = document.querySelector('[data-bulk-all]');
    const boxes = () => [...document.querySelectorAll('[data-bulk-item]')];
    const bar = document.querySelector('[data-bulk-bar]');
    const counter = document.querySelector('[data-bulk-count]');

    const sync = () => {
        const checked = boxes().filter((box) => box.checked);
        bar.classList.toggle('hidden', checked.length === 0);
        counter.textContent = checked.length;
        if (master) {
            master.checked = checked.length > 0 && checked.length === boxes().length;
        }
    };

    master?.addEventListener('change', () => {
        boxes().forEach((box) => (box.checked = master.checked));
        sync();
    });

    boxes().forEach((box) => box.addEventListener('change', sync));

    document.querySelectorAll('[data-bulk-action]').forEach((button) => {
        button.addEventListener('click', () => {
            const action = button.dataset.bulkAction;

            if (action === 'delete' && !confirm('Permanently delete the selected messages? This cannot be undone.')) {
                return;
            }

            bulkForm.querySelector('[data-bulk-action-input]').value = action;

            boxes()
                .filter((box) => box.checked)
                .forEach((box) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = box.value;
                    bulkForm.appendChild(input);
                });

            bulkForm.submit();
        });
    });
}

// ---------------------------------------------------------------------------
// Dashboard area chart: hover crosshair + tooltip. The SVG is server-rendered;
// each day has an invisible hit column carrying data-label / data-count.
// ---------------------------------------------------------------------------
document.querySelectorAll('[data-chart]').forEach((chart) => {
    const tooltip = chart.querySelector('[data-chart-tooltip]');
    const cursor = chart.querySelector('[data-chart-cursor]');

    chart.querySelectorAll('[data-chart-hit]').forEach((hit) => {
        hit.addEventListener('mouseenter', () => {
            tooltip.querySelector('[data-chart-tooltip-label]').textContent = hit.dataset.label;
            tooltip.querySelector('[data-chart-tooltip-value]').textContent = hit.dataset.count;
            tooltip.classList.remove('hidden');

            const x = parseFloat(hit.dataset.x);
            cursor.setAttribute('x1', x);
            cursor.setAttribute('x2', x);
            cursor.classList.remove('hidden');

            const bounds = chart.getBoundingClientRect();
            const ratio = x / parseFloat(chart.querySelector('svg').viewBox.baseVal.width);
            const left = Math.min(Math.max(ratio * bounds.width, 60), bounds.width - 60);
            tooltip.style.left = `${left}px`;
        });
    });

    chart.addEventListener('mouseleave', () => {
        tooltip.classList.add('hidden');
        cursor.classList.add('hidden');
    });
});
