import { animate } from 'motion';
import { animateTo, EASE_EVENTIA, prefersReducedMotion } from './motion';

const DESKTOP_QUERY = '(min-width: 80rem)';
const MENU_DURATION = 0.3;

/** Port of components/site/header.tsx. */
export default ({ darkHero, routeSection, sections }) => ({
    isOpen: false,
    menuVisible: false,
    isScrolled: false,
    observed: 'accueil',
    cleanupOpen: null,

    init() {
        const onScroll = () => {
            this.isScrolled = window.scrollY > 8;
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        // A thin band around the middle of the viewport decides which section is current.
        const observer = new IntersectionObserver(
            (entries) => {
                for (const entry of entries) {
                    if (entry.isIntersecting) this.observed = entry.target.id;
                }
            },
            { rootMargin: '-45% 0px -50% 0px' },
        );
        sections
            .map((id) => document.getElementById(id))
            .filter(Boolean)
            .forEach((section) => observer.observe(section));
    },

    get active() {
        return routeSection ?? this.observed;
    },

    // Pages opening on a dark hero keep the bar transparent with light text until the user scrolls.
    get headerClasses() {
        const overHero = darkHero && !this.isScrolled;
        const solid = !this.isOpen && !overHero && this.isScrolled;

        return {
            'tone-deep': this.isOpen || overHero,
            'border-transparent': !solid,
            'bg-canvas': this.isOpen,
            'bg-transparent': !this.isOpen && !solid,
            'border-line bg-white/85 shadow-soft backdrop-blur-md': solid,
        };
    },

    toggleMenu() {
        this.isOpen ? this.closeMenu() : this.openMenu();
    },

    openMenu() {
        this.isOpen = true;
        this.menuVisible = true;
        this.$nextTick(() => {
            const menu = this.$refs.menu;
            const items = menu.querySelectorAll('[data-menu-item]');
            animate(menu, { opacity: [0, 1] }, { duration: MENU_DURATION, ease: EASE_EVENTIA });
            items.forEach((item) => {
                animate(item, { opacity: 0, y: 16 }, { duration: 0 });
                animateTo(item, { opacity: 1, y: 0 }, { duration: 0.7, ease: EASE_EVENTIA });
            });
            this.lockBackground();
            menu.querySelector('a')?.focus();
        });
    },

    async closeMenu() {
        if (!this.isOpen) return;
        this.isOpen = false;
        this.cleanupOpen?.();
        this.cleanupOpen = null;
        const menu = this.$refs.menu;
        menu.querySelectorAll('[data-menu-item]').forEach((item) => {
            animateTo(item, { opacity: 0, y: 16 }, { duration: MENU_DURATION, ease: EASE_EVENTIA });
        });
        await animate(menu, { opacity: 0 }, { duration: MENU_DURATION, ease: EASE_EVENTIA });
        if (!this.isOpen) this.menuVisible = false;
    },

    lockBackground() {
        const root = document.documentElement;
        const previousOverflow = root.style.overflow;
        const header = this.$root;
        const background = Array.from(document.body.children).filter(
            (element) => element instanceof HTMLElement && element !== header,
        );

        root.style.overflow = 'hidden';
        background.forEach((element) => {
            element.inert = true;
        });

        const handleKeyDown = (event) => {
            if (event.key !== 'Escape') return;
            this.closeMenu();
            this.$refs.toggle.focus();
        };
        const desktop = window.matchMedia(DESKTOP_QUERY);
        const handleDesktop = (event) => {
            if (event.matches) this.closeMenu();
        };

        document.addEventListener('keydown', handleKeyDown);
        desktop.addEventListener('change', handleDesktop);

        this.cleanupOpen = () => {
            root.style.overflow = previousOverflow;
            background.forEach((element) => {
                element.inert = false;
            });
            document.removeEventListener('keydown', handleKeyDown);
            desktop.removeEventListener('change', handleDesktop);
        };
    },

    navigateFromMenu(event, href) {
        if (!this.isOpen) return;
        this.closeMenu();

        const id = href.split('#')[1];
        const target = id ? document.getElementById(id) : null;
        // Another route, or an anchor not on this page: let the link navigate.
        if (!target) return;
        event.preventDefault();

        // Next frame: the scroll lock and inert state have been released.
        requestAnimationFrame(() => {
            target.scrollIntoView({ behavior: prefersReducedMotion() ? 'auto' : 'smooth' });
            if (!target.hasAttribute('tabindex')) target.setAttribute('tabindex', '-1');
            target.focus({ preventScroll: true });
            window.history.pushState(null, '', `#${id}`);
        });
    },
});
