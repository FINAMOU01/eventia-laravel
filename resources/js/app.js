import Alpine from 'alpinejs';
import siteHeader from './modules/header';
import expertiseSlider from './modules/expertise-slider';
import realisationsCarousel from './modules/realisations-carousel';
import quoteForm from './modules/quote-form';
import { lazyVideo, videoLightbox } from './modules/video';
import { initReveals } from './modules/motion';

const LOCALE_STORAGE_KEY = 'eventia-locale';

Alpine.data('siteHeader', siteHeader);
Alpine.data('expertiseSlider', expertiseSlider);
Alpine.data('realisationsCarousel', realisationsCarousel);
Alpine.data('quoteForm', quoteForm);
Alpine.data('lazyVideo', lazyVideo);
Alpine.data('videoLightbox', videoLightbox);

window.Alpine = Alpine;
Alpine.start();

initReveals();

// FR / EN switcher: remembers an explicit choice so the browser-language redirect never overrides it.
document.addEventListener('click', (event) => {
    const link = event.target.closest('[data-remember-locale]');
    if (!link) return;
    try {
        window.localStorage.setItem(LOCALE_STORAGE_KEY, link.dataset.rememberLocale);
    } catch {
        // Storage can be unavailable (private mode); the link still switches language.
    }
});