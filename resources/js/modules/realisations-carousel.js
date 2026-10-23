import { prefersReducedMotion, swapContent } from './motion';

const INTERVAL_MS = 4000;

/** Port of components/site/realisations.tsx (homepage photo carousel). */
export default ({ slides }) => ({
    slides,
    active: 0,
    shown: 0,
    hasFocus: false,
    inView: false,
    reduceMotion: prefersReducedMotion(),
    timer: null,
    swapping: Promise.resolve(),

    // Keeps rotating under the mouse; only keyboard focus inside the section or leaving the viewport pauses it.
    get isPlaying() {
        return this.slides.length > 1 && !this.reduceMotion && !this.hasFocus && this.inView;
    },

    init() {
        const observer = new IntersectionObserver(([entry]) => {
            this.inView = entry.isIntersecting;
        }, { threshold: 0.35 });
        observer.observe(this.$el);

        this.$watch('isPlaying', () => this.schedule());
        this.$watch('active', (value) => {
            this.schedule();
            this.swap(value);
        });
    },

    schedule() {
        window.clearTimeout(this.timer);
        if (!this.isPlaying) return;
        this.timer = window.setTimeout(() => {
            this.active = (this.active + 1) % this.slides.length;
        }, INTERVAL_MS);
    },

    // AnimatePresence keyed by the event: the caption only animates when the event changes.
    swap(value) {
        this.swapping = this.swapping.then(() => {
            if (!this.$refs.swap || this.slides[this.shown].id === this.slides[value].id) {
                this.shown = this.active;
                return undefined;
            }

            return swapContent(this.$refs.swap, () => {
                this.shown = this.active;
            }, { duration: 0.6, ease: [0.22, 1, 0.36, 1] });
        });
    },
});
