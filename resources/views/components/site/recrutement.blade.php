@props(['locale'])
@php
    $content = Content::get($locale);
    $recruitment = $content['recruitment'];
    $t = [
        'fr' => ['eyebrow' => 'Recrutement', 'profiles' => 'Profils recherchés', 'apply' => 'Postuler', 'criteria' => 'Voir les critères'],
        'en' => ['eyebrow' => 'Careers', 'profiles' => 'Profiles we are looking for', 'apply' => 'Apply', 'criteria' => 'See the criteria'],
    ][$locale];
@endphp
{{-- Homepage preview; criteria and application details live on /recrutement. --}}
<x-ui.section id="recrutement" tone="surface" aria-labelledby="recrutement-titre">
  <div class="site-grid items-center gap-y-12 lg:py-6">
    <x-ui.reveal variant="fade" class="col-span-full sm:col-span-6 sm:col-start-2 md:col-span-5 md:col-start-2 lg:col-span-5 lg:col-start-1">
      <x-site.media-slot-frame name="recrutement-portrait" :locale="$locale" ratio="portrait" tone="light" sizes="(min-width: 1024px) 40vw, 80vw" />
    </x-ui.reveal>

    <div class="col-span-full lg:col-span-6 lg:col-start-7">
      <x-ui.reveal>
        <x-ui.eyebrow>{{ $t['eyebrow'] }}</x-ui.eyebrow>
        <h2 id="recrutement-titre" class="mt-6 font-display text-[clamp(2.25rem,1.5rem+2.6vw,3.75rem)] leading-[1.08] tracking-[-0.01em] text-fg">{{ $recruitment['title'] }}</h2>
        <p class="mt-4 font-display text-h3 text-accent italic">{{ $recruitment['tagline'] }}</p>
        <p class="mt-6 text-lead text-fg-muted">{{ $recruitment['intro'] }}</p>
      </x-ui.reveal>

      <h3 class="sr-only">{{ $t['profiles'] }}</h3>
      <x-ui.reveal-group as="ul" :stagger="0.08" class="mt-10 border-t border-line">
        @foreach ($recruitment['previewProfiles'] as $index => $profile)
          <x-ui.reveal-item as="li" class="group/profile flex items-baseline gap-5 border-b border-line py-4">
            <span aria-hidden="true" class="w-6 shrink-0 text-eyebrow text-accent">{{ Web::pad($index + 1) }}</span>
            <span class="font-display text-[clamp(1.25rem,1rem+0.8vw,1.625rem)] text-fg transition-transform duration-500 ease-eventia motion-safe:group-hover/profile:translate-x-1">{{ $profile }}</span>
          </x-ui.reveal-item>
        @endforeach
      </x-ui.reveal-group>

      <x-ui.reveal class="mt-10 flex flex-col gap-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-4">
          <x-ui.link :href="$content['applicationHref']" appearance="primary" size="lg" icon="arrow-right" class="w-full sm:w-auto">{{ $t['apply'] }}</x-ui.link>
          <x-ui.link :href="I18n::localizeHref('/recrutement', $locale)" appearance="secondary" size="lg" class="w-full sm:w-auto">{{ $t['criteria'] }}</x-ui.link>
        </div>
        <p class="text-small text-fg-muted">{{ $recruitment['note'] }}</p>
      </x-ui.reveal>
    </div>
  </div>
</x-ui.section>
