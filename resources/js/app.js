import './bootstrap';

const siteHeader = document.querySelector('[data-site-header]');
const siteMenu = document.querySelector('[data-site-menu]');
const siteMenuToggle = document.querySelector('[data-site-menu-toggle]');
const siteMenuOpenIcon = document.querySelector('[data-site-menu-open-icon]');
const siteMenuCloseIcon = document.querySelector('[data-site-menu-close-icon]');

const setSiteMenuState = (isOpen) => {
    if (!siteMenu || !siteMenuToggle) {
        return;
    }

    siteMenu?.classList.toggle('hidden', !isOpen);
    siteMenuToggle?.setAttribute('aria-expanded', String(isOpen));
    siteMenuToggle?.setAttribute('aria-label', isOpen ? 'Close navigation' : 'Open navigation');
    siteMenuOpenIcon?.classList.toggle('hidden', isOpen);
    siteMenuCloseIcon?.classList.toggle('hidden', !isOpen);
    document.body.classList.toggle('overflow-hidden', isOpen);
};

siteMenuToggle?.addEventListener('click', () => {
    setSiteMenuState(siteMenu?.classList.contains('hidden') ?? false);
});

siteMenu?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => setSiteMenuState(false));
});

window.addEventListener(
    'scroll',
    () => {
        siteHeader?.classList.toggle('is-scrolled', window.scrollY > 12);
    },
    { passive: true },
);

window.matchMedia('(min-width: 1024px)').addEventListener('change', (event) => {
    if (event.matches) {
        setSiteMenuState(false);
    }
});

document.addEventListener('click', (event) => {
    if (siteHeader && siteMenu && !siteHeader.contains(event.target) && !siteMenu.classList.contains('hidden')) {
        setSiteMenuState(false);
    }
});

const revealElements = document.querySelectorAll('[data-reveal]');

if (revealElements.length > 0 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const revealObserver = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.08 },
    );

    revealElements.forEach((element) => {
        element.classList.add('is-reveal-ready');
        revealObserver.observe(element);
    });
}

const setContactFormSubmitting = (form, isSubmitting) => {
    const submitButton = form.querySelector('[data-contact-submit]');
    const submitLabel = submitButton?.querySelector('[data-contact-submit-label]');

    if (submitButton) {
        submitButton.disabled = isSubmitting;
        submitButton.setAttribute('aria-busy', String(isSubmitting));
        submitButton.classList.toggle('cursor-wait', isSubmitting);
        submitButton.classList.toggle('opacity-75', isSubmitting);
    }

    if (submitLabel) {
        submitLabel.textContent = isSubmitting ? 'Sending enquiry...' : 'Send enquiry';
    }
};

document.querySelectorAll('[data-contact-form]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        const siteKey = form.dataset.recaptchaSiteKey;
        const action = form.dataset.recaptchaAction ?? 'contact';
        const recaptcha = window.grecaptcha;

        if (siteKey && recaptcha) {
            event.preventDefault();
            setContactFormSubmitting(form, true);

            recaptcha.ready(() => {
                recaptcha
                    .execute(siteKey, { action })
                    .then((token) => {
                        const responseInput = form.querySelector('[data-recaptcha-response]');

                        if (responseInput) {
                            responseInput.value = token;
                        }

                        form.submit();
                    })
                    .catch(() => {
                        form.submit();
                    });
            });

            return;
        }

        setContactFormSubmitting(form, true);
    });
});

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
        setSiteMenuState(false);
    }
});

// ---------------------------------------------------------------------------
// Modals: <dialog> elements opened by [data-modal-open="id"], closed by
// [data-modal-close] buttons or a backdrop click.
// ---------------------------------------------------------------------------
document.addEventListener('click', (event) => {
    const opener = event.target.closest('[data-modal-open]');
    if (opener) {
        const dialog = document.getElementById(opener.dataset.modalOpen);

        if (dialog) {
            event.preventDefault();

            if (dialog.matches('[data-contact-modal]')) {
                const serviceSelect = dialog.querySelector('[data-contact-service-select]');

                if (serviceSelect) {
                    serviceSelect.value = opener.dataset.contactServiceId ?? '';
                }

                setSiteMenuState(false);
            }

            dialog.showModal();
            return;
        }
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

const contactModal = document.querySelector('[data-contact-modal]');

if (contactModal?.hasAttribute('data-open-on-load')) {
    contactModal.showModal();
}

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
