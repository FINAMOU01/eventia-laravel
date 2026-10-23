@props(['locale', 'id', 'eyebrow'])
{{-- Closing call to action shared by the Expertises, Réalisations and Équipe pages. --}}
<x-ui.section tone="surface" aria-labelledby="{{ $id }}">
  <x-ui.reveal class="mx-auto flex max-w-3xl flex-col items-center gap-7 py-6 text-center lg:py-10">
    <x-ui.eyebrow>{{ $eyebrow }}</x-ui.eyebrow>
    <h2 id="{{ $id }}" class="text-display text-fg">@if ($locale === 'fr')Parlons de <em class="text-accent italic">votre projet</em>.@else Let’s talk about <em class="text-accent italic">your project</em>.@endif</h2>
    <x-ui.link :href="I18n::localizeHref(Site::PRIMARY_CTA_HREF, $locale)" appearance="primary" size="lg" icon="arrow-right">{{ Site::text($locale)['primaryCta'] }}</x-ui.link>
  </x-ui.reveal>
</x-ui.section>
