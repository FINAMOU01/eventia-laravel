@props(['locale'])
@php
    $intro = [
        'fr' => 'Vous préparez un événement, une activation de marque ou recherchez du personnel événementiel ? Parlons de votre projet.',
        'en' => 'Planning an event, a brand activation or looking for event staff? Let’s talk about your project.',
    ][$locale];
@endphp
{{-- Homepage closing section: a short invitation leading to /contact. --}}
<x-ui.section id="contact" tone="light" aria-labelledby="contact-titre">
  <x-ui.reveal class="mx-auto flex max-w-3xl flex-col items-center py-6 text-center lg:py-10">
    <x-ui.eyebrow>Contact</x-ui.eyebrow>
    <h2 id="contact-titre" class="mt-6 font-display text-[clamp(2.25rem,1.5rem+2.8vw,4rem)] leading-[1.06] tracking-[-0.015em] text-fg"><x-site.contact-title :locale="$locale" /></h2>
    <p class="mt-6 max-w-xl text-lead text-fg-muted">{{ $intro }}</p>
    <x-ui.link :href="I18n::localizeHref(Site::PRIMARY_CTA_HREF, $locale)" appearance="primary" size="lg" icon="arrow-right" class="mt-10 w-full sm:w-auto">{{ Site::text($locale)['primaryCta'] }}</x-ui.link>
  </x-ui.reveal>
</x-ui.section>
