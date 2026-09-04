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
    siteMenuToggle?.setAttribute(
        'aria-label',
        isOpen ? siteMenuToggle.dataset.closeLabel : siteMenuToggle.dataset.openLabel,
    );
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

// ---------------------------------------------------------------------------
// Hero headline typewriter. Each term is typed, held, then deleted before the
// next one starts. Reduced-motion visitors keep the first term on screen.
// ---------------------------------------------------------------------------
const TYPER_TYPE_SPEED = 95;
const TYPER_DELETE_SPEED = 45;
const TYPER_HOLD = 1600;
const TYPER_GAP = 320;

const startHeroTyper = (typer) => {
    const output = typer.querySelector('[data-hero-typer-text]');

    let terms = [];

    try {
        terms = JSON.parse(typer.dataset.heroTerms ?? '[]');
    } catch {
        terms = [];
    }

    if (!output || terms.length === 0) {
        return;
    }

    let termIndex = 0;
    let characterCount = terms[0].length;
    let isDeleting = true;
    let timer = null;

    const tick = () => {
        const term = terms[termIndex];

        characterCount += isDeleting ? -1 : 1;
        output.textContent = term.slice(0, characterCount);

        let delay = isDeleting ? TYPER_DELETE_SPEED : TYPER_TYPE_SPEED;

        if (!isDeleting && characterCount === term.length) {
            isDeleting = true;
            delay = TYPER_HOLD;
        } else if (isDeleting && characterCount === 0) {
            isDeleting = false;
            termIndex = (termIndex + 1) % terms.length;
            delay = TYPER_GAP;
        }

        timer = window.setTimeout(tick, delay);
    };

    const play = () => {
        if (timer === null) {
            timer = window.setTimeout(tick, TYPER_HOLD);
        }
    };

    const pause = () => {
        window.clearTimeout(timer);
        timer = null;
    };

    // Typing off-screen or in a background tab is wasted work on phones.
    const visibilityObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => (entry.isIntersecting && !document.hidden ? play() : pause()));
        },
        { threshold: 0 },
    );

    visibilityObserver.observe(typer);
    document.addEventListener('visibilitychange', () => (document.hidden ? pause() : play()));
};

if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('[data-hero-typer]').forEach(startHeroTyper);
}

// ---------------------------------------------------------------------------
// Technology marquee. Pointer devices get the CSS `technology-scroll`
// animation, which hover pauses. Touch and narrow screens instead scroll the
// strip natively so a finger can drag it, and this loop keeps it moving
// whenever nobody is touching it.
// ---------------------------------------------------------------------------
const MARQUEE_PIXELS_PER_SECOND = 40;
const MARQUEE_RESUME_DELAY = 1500;

const startTechnologyMarquee = (marquee) => {
    const track = marquee.querySelector('[data-technology-track]');
    const slides = track ? [...track.children] : [];

    if (slides.length < 2) {
        return () => {};
    }

    /**
     * Distance covered by one full set of cards. The track renders the set
     * twice, so scrolling back by this much lands on an identical frame.
     */
    const loopDistance = () => slides[slides.length / 2].offsetLeft - slides[0].offsetLeft;

    let frameId = null;
    let previousTimestamp = null;
    let isPointerDown = false;
    let resumeAt = 0;

    const step = (timestamp) => {
        const elapsed = previousTimestamp === null ? 0 : (timestamp - previousTimestamp) / 1000;
        const distance = loopDistance();
        previousTimestamp = timestamp;

        if (!isPointerDown && distance > 0) {
            if (timestamp >= resumeAt) {
                marquee.scrollLeft += MARQUEE_PIXELS_PER_SECOND * elapsed;
            }

            if (marquee.scrollLeft >= distance) {
                marquee.scrollLeft -= distance;
            }
        }

        frameId = requestAnimationFrame(step);
    };

    const play = () => {
        if (frameId === null) {
            previousTimestamp = null;
            frameId = requestAnimationFrame(step);
        }
    };

    const pause = () => {
        if (frameId !== null) {
            cancelAnimationFrame(frameId);
            frameId = null;
        }
    };

    const holdForUser = () => {
        isPointerDown = false;
        resumeAt = performance.now() + MARQUEE_RESUME_DELAY;
    };

    const grab = () => {
        isPointerDown = true;
    };

    marquee.addEventListener('pointerdown', grab);
    marquee.addEventListener('pointerup', holdForUser);
    marquee.addEventListener('pointercancel', holdForUser);
    marquee.addEventListener('pointerleave', holdForUser);

    // Off-screen frames are wasted work and drain phone batteries.
    const visibilityObserver = new IntersectionObserver(
        ([entry]) => (entry.isIntersecting ? play() : pause()),
        { threshold: 0 },
    );

    visibilityObserver.observe(marquee);

    return () => {
        pause();
        visibilityObserver.disconnect();
        marquee.removeEventListener('pointerdown', grab);
        marquee.removeEventListener('pointerup', holdForUser);
        marquee.removeEventListener('pointercancel', holdForUser);
        marquee.removeEventListener('pointerleave', holdForUser);
        marquee.scrollLeft = 0;
    };
};

document.querySelectorAll('[data-technology-marquee]').forEach((marquee) => {
    // Mirrors the media query that turns the strip into a scroller in app.css.
    const scrollerQuery = window.matchMedia('(max-width: 767px), (hover: none)');
    const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

    let stop = null;

    const sync = () => {
        const shouldRun = scrollerQuery.matches && !reducedMotionQuery.matches;

        if (shouldRun && !stop) {
            stop = startTechnologyMarquee(marquee);
        } else if (!shouldRun && stop) {
            stop();
            stop = null;
        }
    };

    scrollerQuery.addEventListener('change', sync);
    reducedMotionQuery.addEventListener('change', sync);
    sync();
});

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
        submitLabel.textContent = isSubmitting ? submitLabel.dataset.busyLabel : submitLabel.dataset.idleLabel;
    }
};

const RECAPTCHA_WIDGET_WIDTH = 304;
const RECAPTCHA_WIDGET_HEIGHT = 78;

/**
 * The reCAPTCHA checkbox is a fixed 304x78 iframe that overflows narrow form
 * columns. Scale each widget to the width its column actually offers.
 */
const fitRecaptchaWidgets = (root = document) => {
    root.querySelectorAll('[data-recaptcha-shell]').forEach((shell) => {
        const available = shell.parentElement?.clientWidth ?? 0;

        if (available === 0) {
            return;
        }

        const scale = Math.min(1, available / RECAPTCHA_WIDGET_WIDTH);

        shell.style.setProperty('--recaptcha-scale', String(scale));
        shell.style.height = `${Math.ceil(RECAPTCHA_WIDGET_HEIGHT * scale)}px`;
    });
};

const renderRecaptchaWidgets = (root = document) => {
    const recaptcha = window.grecaptcha;

    if (typeof recaptcha?.render !== 'function') {
        return;
    }

    root.querySelectorAll('[data-recaptcha-widget]').forEach((widget) => {
        if (widget.dataset.recaptchaWidgetId || widget.closest('dialog:not([open])')) {
            return;
        }

        const widgetId = recaptcha.render(widget, {
            sitekey: widget.dataset.sitekey,
        });

        widget.dataset.recaptchaWidgetId = String(widgetId);
    });

    fitRecaptchaWidgets(root);
};

const loadRecaptcha = () => {
    if (!document.querySelector('[data-recaptcha-widget]') || window.grecaptcha) {
        renderRecaptchaWidgets();

        return;
    }

    window.networxRecaptchaLoaded = () => window.dispatchEvent(new Event('recaptcha:ready'));

    const script = document.createElement('script');
    const recaptchaLocale = document.documentElement.lang.startsWith('ar') ? 'ar' : 'en';

    script.src = `https://www.google.com/recaptcha/api.js?onload=networxRecaptchaLoaded&render=explicit&hl=${recaptchaLocale}`;
    script.async = true;
    script.defer = true;
    document.head.append(script);
};

window.addEventListener('recaptcha:ready', () => renderRecaptchaWidgets());
window.addEventListener('resize', () => fitRecaptchaWidgets());
loadRecaptcha();

document.querySelectorAll('[data-contact-form]').forEach((form) => {
    form.addEventListener('submit', () => {
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

// ---------------------------------------------------------------------------
// Pricing plans: monthly/yearly switch and the "get started" request modal.
// ---------------------------------------------------------------------------
const planRequestTitleTemplate = (dialog) => dialog.dataset.planTitleTemplate ?? '';

const preparePlanRequestModal = (dialog, planId, planName) => {
    const planIdInput = dialog.querySelector('[data-plan-request-plan-id]');
    const billingInput = dialog.querySelector('[data-plan-request-billing-period]');
    const title = dialog.querySelector('[data-plan-request-title]');
    const pricingSection = document.querySelector('[data-pricing]');

    if (planIdInput) {
        planIdInput.value = planId;
    }

    if (billingInput) {
        billingInput.value = pricingSection?.dataset.billing ?? 'monthly';
    }

    if (title && planName) {
        title.textContent = planRequestTitleTemplate(dialog).replace(':plan', planName);
    }
};

document.querySelectorAll('[data-pricing]').forEach((section) => {
    const options = [...section.querySelectorAll('[data-billing-option]')];
    const prices = [...section.querySelectorAll('[data-plan-price]')];

    const setBillingPeriod = (period) => {
        section.dataset.billing = period;

        options.forEach((option) => {
            option.setAttribute('aria-pressed', String(option.dataset.billingOption === period));
        });

        prices.forEach((price) => {
            price.hidden = price.dataset.planPrice !== period;
        });
    };

    options.forEach((option) => {
        option.addEventListener('click', () => setBillingPeriod(option.dataset.billingOption));
    });

    setBillingPeriod(section.dataset.billing ?? 'monthly');
});

const planRequestForm = document.querySelector('[data-plan-request-form]');

planRequestForm?.addEventListener('submit', () => {
    const submitButton = planRequestForm.querySelector('[data-plan-request-submit]');
    const submitLabel = submitButton?.querySelector('[data-plan-request-submit-label]');

    if (submitButton) {
        submitButton.disabled = true;
        submitButton.setAttribute('aria-busy', 'true');
        submitButton.classList.add('cursor-wait', 'opacity-75');
    }

    if (submitLabel) {
        submitLabel.textContent = submitLabel.dataset.busyLabel;
    }
});

const modalBackdrop = (dialog) => document.querySelector(`[data-modal-backdrop="${dialog.id}"]`);

const openDialog = (dialog) => {
    if (dialog.matches('[data-contact-modal]')) {
        modalBackdrop(dialog)?.classList.remove('hidden');
        dialog.show();
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => renderRecaptchaWidgets(dialog));

        return;
    }

    dialog.showModal();
};

const closeDialog = (dialog) => {
    dialog.close();

    if (dialog.matches('[data-contact-modal]')) {
        modalBackdrop(dialog)?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
};

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        document.querySelectorAll('[data-dropdown-menu]').forEach((menu) => menu.classList.add('hidden'));
        setSiteMenuState(false);

        const openContactModal = document.querySelector('[data-contact-modal][open]');

        if (openContactModal) {
            closeDialog(openContactModal);
        }
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

            if (dialog.matches('[data-plan-modal]') && opener.dataset.planId) {
                preparePlanRequestModal(dialog, opener.dataset.planId, opener.dataset.planName);
            }

            openDialog(dialog);
            return;
        }
    }

    if (event.target.closest('[data-modal-close]')) {
        const dialog = event.target.closest('dialog');

        if (dialog) {
            closeDialog(dialog);
        }

        return;
    }

    if (event.target.matches('[data-modal-backdrop]')) {
        const dialog = document.getElementById(event.target.dataset.modalBackdrop);

        if (dialog) {
            closeDialog(dialog);
        }

        return;
    }

    // Backdrop click: target is the dialog itself, not its inner panel.
    if (event.target instanceof HTMLDialogElement) {
        closeDialog(event.target);
    }
});

const contactModal = document.querySelector('[data-contact-modal]');

if (contactModal?.hasAttribute('data-open-on-load')) {
    openDialog(contactModal);
}

const planRequestModal = document.querySelector('[data-plan-modal]');

if (planRequestModal?.hasAttribute('data-open-on-load')) {
    openDialog(planRequestModal);
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
// Page-content tabs: responsive, keyboard accessible, and validation aware.
// ---------------------------------------------------------------------------
document.querySelectorAll('[data-page-content-tabs]').forEach((container) => {
    const tablist = container.querySelector('[data-page-content-tablist]');
    const tabs = [...container.querySelectorAll('[data-page-content-tab]')];
    const panels = [...container.querySelectorAll('[data-page-content-panel]')];
    const inactiveClasses = ['text-slate-500', 'hover:bg-slate-100', 'hover:text-navy-950'];

    if (!tablist || tabs.length === 0 || panels.length === 0) {
        return;
    }

    const panelFor = (name) => panels.find((panel) => panel.dataset.pageContentPanel === name);

    const activateTab = (name, focus = false) => {
        if (!panelFor(name)) {
            return;
        }

        tabs.forEach((tab) => {
            const isActive = tab.dataset.pageContentTab === name;

            tab.setAttribute('aria-selected', String(isActive));
            tab.tabIndex = isActive ? 0 : -1;
            tab.classList.toggle('bg-navy-950', isActive);
            tab.classList.toggle('text-white', isActive);
            tab.classList.toggle('shadow-sm', isActive);
            inactiveClasses.forEach((className) => tab.classList.toggle(className, !isActive));
        });

        panels.forEach((panel) => {
            panel.hidden = panel.dataset.pageContentPanel !== name;
        });

        if (focus) {
            tabs.find((tab) => tab.dataset.pageContentTab === name)?.focus();
        }
    };

    tablist.setAttribute('role', 'tablist');

    tabs.forEach((tab, index) => {
        tab.setAttribute('role', 'tab');
        tab.setAttribute('aria-controls', panelFor(tab.dataset.pageContentTab)?.id ?? '');

        tab.addEventListener('click', (event) => {
            event.preventDefault();
            activateTab(tab.dataset.pageContentTab);
        });

        tab.addEventListener('keydown', (event) => {
            let targetIndex;

            if (event.key === 'ArrowRight') {
                targetIndex = (index + 1) % tabs.length;
            } else if (event.key === 'ArrowLeft') {
                targetIndex = (index - 1 + tabs.length) % tabs.length;
            } else if (event.key === 'Home') {
                targetIndex = 0;
            } else if (event.key === 'End') {
                targetIndex = tabs.length - 1;
            } else {
                return;
            }

            event.preventDefault();
            activateTab(tabs[targetIndex].dataset.pageContentTab, true);
        });
    });

    panels.forEach((panel) => panel.setAttribute('role', 'tabpanel'));

    const initialTab = tabs.find((tab) => tab.getAttribute('aria-selected') === 'true')?.dataset.pageContentTab
        ?? tabs[0].dataset.pageContentTab;

    activateTab(initialTab);
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
