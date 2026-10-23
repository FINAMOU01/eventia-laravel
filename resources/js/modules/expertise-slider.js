import { animate } from 'motion';
import { EASE_EVENTIA, prefersReducedMotion, swapContent } from './motion';

const INTERVAL_MS = 6000;
const SWIPE_THRESHOLD_PX = 50;

/** Port of components/site/expertise.tsx (homepage expertise slider). */
export default ({ items }) => ({
    items,
    active: 0,
    shown: 0,
    isHovered: false,
    hasFocus: false,
    inView: false,
    reduceMotion: prefersReducedMotion(),
    timer: null,
    start: null,
    swapping: Promise.resolve(),

    // Pauses while the mouse is over the section or keyboard focus is inside it.
    get isPlaying() {
        return !this.reduceMotion && this.inView && !this.isHovered && !this.hasFocus;
    },

    init() {
        const observer = new IntersectionObserver(([entry]) => {
            this.inView = entry.isIntersecting;
        }, { threshold: 0.4 });
        observer.observe(this.$el);

        this.$watch('isPlaying', () => this.schedule());
        this.$watch('active', (value) => {
            this.schedule();
            this.swap(value);
        });
    },

    goTo(step) {
        this.active = (this.active + step + this.items.length) % this.items.length;
    },

    schedule() {
        window.clearTimeout(this.timer);
        this.progress();
        if (!this.isPlaying) return;
        this.timer = window.setTimeout(() => {
            this.active = (this.active + 1) % this.items.length;
        }, INTERVAL_MS);
    },

    // Progress ring around the "next" button, restarted on every slide while the rotation runs.
    progress() {
        const circle = this.$refs.progress;
        if (!circle || !this.isPlaying) return;
        this.$nextTick(() => {
            animate(circle, { strokeDasharray: ['0px 1px', '1px 1px'] }, { duration: INTERVAL_MS / 1000, ease: 'linear' });
        });
    },

    // AnimatePresence mode="wait" around the mobile caption.
    swap(value) {
        this.swapping = this.swapping.then(() => {
            if (this.shown === value) return undefined;

            return swapContent(this.$refs.swap, () => {
                this.shown = this.active;
            }, { duration: 0.5, ease: EASE_EVENTIA });
        });
    },

    touchStart(event) {
        const touch = event.touches[0];
        this.start = { x: touch.clientX, y: touch.clientY };
    },

    touchEnd(event) {
        const start = this.start;
        this.start = null;
        if (!start) return;
        const touch = event.changedTouches[0];
        const dx = touch.clientX - start.x;
        if (Math.abs(dx) > SWIPE_THRESHOLD_PX && Math.abs(dx) > Math.abs(touch.clientY - start.y)) {
            this.goTo(dx < 0 ? 1 : -1);
        }
    },
});
