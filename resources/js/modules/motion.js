import { animate, inView } from 'motion';

// Keep in sync with --ease-eventia in resources/css/app.css (lib/motion.ts in the Next.js source).
export const EASE_EVENTIA = [0.22, 1, 0.36, 1];

export const prefersReducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const HIDDEN = {
    fade: { opacity: 0 },
    up: { opacity: 0, y: 16 },
    left: { opacity: 0, x: -16 },
    right: { opacity: 0, x: 16 },
    draw: { scaleX: 0 },
};

const VISIBLE = {
    fade: { opacity: 1 },
    up: { opacity: 1, x: 0, y: 0 },
    left: { opacity: 1, x: 0, y: 0 },
    right: { opacity: 1, x: 0, y: 0 },
    draw: { scaleX: 1 },
};

const TRANSFORM_KEYS = new Set(['x', 'y', 'scaleX']);

/**
 * Animates an element between two states. Like Framer Motion with reducedMotion="user",
 * transforms jump to their target when the visitor prefers reduced motion; opacity still fades.
 */
export function animateTo(element, target, options) {
    if (!prefersReducedMotion()) {
        return animate(element, target, options);
    }
    const instant = {};
    const animated = {};
    for (const [key, value] of Object.entries(target)) {
        (TRANSFORM_KEYS.has(key) ? instant : animated)[key] = value;
    }
    if (Object.keys(instant).length) {
        animate(element, instant, { duration: 0 });
    }

    return Object.keys(animated).length ? animate(element, animated, options) : Promise.resolve();
}

export function revealHidden(element, variant) {
    return animate(element, HIDDEN[variant], { duration: 0 });
}

export function revealElement(element, variant, delay = 0) {
    const duration = variant === 'draw' ? 0.9 : 0.7;

    return animateTo(element, VISIBLE[variant], { duration, delay, ease: EASE_EVENTIA });
}

/** Port of the Reveal / RevealGroup / RevealItem components (whileInView, once, amount 0.2). */
function revealItemTree(item, delay) {
    revealElement(item, item.dataset.revealItem, delay);
    for (const child of item.querySelectorAll('[data-reveal-item]')) {
        if (child.parentElement.closest('[data-reveal-group], [data-reveal-item]') === item) {
            revealElement(child, child.dataset.revealItem, delay);
        }
    }
}

export function initReveals(root = document) {
    for (const element of root.querySelectorAll('[data-reveal]')) {
        const stop = inView(
            element,
            () => {
                stop();
                revealElement(element, element.dataset.reveal, Number(element.dataset.revealDelay || 0));
            },
            { amount: 0.2 },
        );
    }

    for (const group of root.querySelectorAll('[data-reveal-group]')) {
        const stop = inView(
            group,
            () => {
                stop();
                // Framer Motion lets each item's own transition delay (0) override staggerChildren / delayChildren,
                // so on the Next.js site every item of a group appears at the same time. Reproduced as is.
                for (const item of group.querySelectorAll('[data-reveal-item]')) {
                    if (item.parentElement.closest('[data-reveal-group], [data-reveal-item]') === group) {
                        revealItemTree(item, 0);
                    }
                }
            },
            { amount: 0.2 },
        );
    }
}

/** AnimatePresence mode="wait": the old content leaves, then the new one enters. */
export async function swapContent(element, update, { duration, ease }) {
    await animateTo(element, { opacity: 0, y: -8 }, { duration, ease });
    update();
    await new Promise((resolve) => requestAnimationFrame(resolve));
    animate(element, { opacity: 0, y: 16 }, { duration: 0 });
    await animateTo(element, { opacity: 1, y: 0 }, { duration, ease });
}
