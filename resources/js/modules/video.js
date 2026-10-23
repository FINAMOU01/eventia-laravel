import { prefersReducedMotion } from './motion';

function prefersDataSaving() {
    return navigator.connection?.saveData === true;
}

/** Port of components/ui/lazy-video.tsx. */
export function lazyVideo({ ambient, types }) {
    return {
        shouldLoad: false,
        hasStarted: false,
        isPlaying: false,
        pausedByUser: false,
        // False when no source can be decoded (e.g. HEVC without hardware support).
        canPlay: false,
        video: null,

        init() {
            const probe = document.createElement('video');
            this.canPlay = types.some((type) => probe.canPlayType(type) !== '');
            if (!ambient || prefersReducedMotion() || !this.canPlay) return;

            const observer = new IntersectionObserver(
                ([entry]) => {
                    if (!entry.isIntersecting) {
                        this.video?.pause();
                        return;
                    }
                    if (this.pausedByUser) return;
                    if (this.video) {
                        this.video.play().catch(() => undefined);
                    } else if (!prefersDataSaving()) {
                        this.shouldLoad = true;
                    }
                },
                { rootMargin: '200px 0px' },
            );
            observer.observe(this.$el);
        },

        start(video) {
            this.video = video;
            video.muted = ambient;
            // Autoplay may be refused (e.g. low-power mode); the poster stays visible.
            video.play().catch(() => undefined);
        },

        toggle() {
            if (!this.video) {
                this.pausedByUser = false;
                this.shouldLoad = true;
                return;
            }
            if (this.video.paused) {
                this.pausedByUser = false;
                this.video.play().catch(() => undefined);
            } else {
                this.pausedByUser = true;
                this.video.pause();
            }
        },
    };
}

/** Port of components/ui/video-lightbox.tsx. */
export function videoLightbox() {
    return {
        isOpen: false,
        previousOverflow: '',

        open() {
            this.isOpen = true;
            const dialog = this.$refs.dialog;
            if (!dialog.open) dialog.showModal();
            const root = document.documentElement;
            this.previousOverflow = root.style.overflow;
            root.style.overflow = 'hidden';
        },

        close() {
            if (!this.isOpen) return;
            this.isOpen = false;
            const dialog = this.$refs.dialog;
            if (dialog.open) dialog.close();
            document.documentElement.style.overflow = this.previousOverflow;
        },
    };
}
