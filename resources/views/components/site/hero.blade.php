@props(['locale'])
@php
    $text = Site::text($locale);
    $team = Content::get($locale)['team'];
    [$open, $close] = I18n::quoteMarks($locale);
    $t = [
        'fr' => [
            'discover' => 'Découvrir EVENTIA',
            'scrollLabel' => 'Faire défiler vers la présentation',
            'scroll' => 'Défiler',
            'about' => 'Qui sommes-nous ?',
        ],
        'en' => [
            'discover' => 'Discover EVENTIA',
            'scrollLabel' => 'Scroll to the introduction',
            'scroll' => 'Scroll',
            'about' => 'About us',
        ],
    ][$locale];
@endphp
{{-- Accent word of the hero title, underlined once the title has appeared. --}}
@php
    $accent = fn (string $word) => '<em class="relative text-accent italic">'.e($word).'<span aria-hidden="true" class="absolute inset-x-0 bottom-[0.02em]"><span data-reveal="draw" data-reveal-delay="1.1" class="block h-px origin-left bg-accent/70" style="'.Ui::revealStyle('draw').'"></span></span></em>';
@endphp
<section id="accueil" aria-labelledby="accueil-titre" class="tone-deep relative isolate flex h-svh min-h-[36rem] flex-col overflow-hidden bg-ink text-fg">
  {{-- Play/pause aligned with the container's left edge, clear of the floating WhatsApp button on the right. --}}
  <x-ui.lazy-video
    :sources="Media::HERO_VIDEO['sources']"
    :poster="Media::HERO_VIDEO['poster']"
    :alt="Media::HERO_VIDEO['alt'][$locale]"
    behavior="ambient"
    sizes="100vw"
    :preload="true"
    :locale="$locale"
    control-class="bottom-6 left-[max(var(--gutter),calc((100%_-_var(--container-site))/2))]"
  />

  <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-deep/30"></div>
  <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-linear-to-b from-ink/75 via-ink/25 to-ink/85"></div>
  <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_center,transparent_35%,rgb(10_16_32/0.5)_100%)]"></div>

  <x-ui.container class="relative flex flex-1 flex-col items-center justify-center pt-(--header-height) pb-24 text-center">
    <x-ui.reveal-group :stagger="0.14" :delay="0.15" class="flex max-w-5xl flex-col items-center gap-6 lg:gap-8">
      <x-ui.reveal-item>
        <p class="flex items-center gap-4 font-sans text-eyebrow font-medium tracking-[0.12em] text-white/85 uppercase sm:tracking-[0.18em]">
          <span aria-hidden="true" class="hidden h-px w-10 bg-accent sm:block"></span>
          @if ($locale === 'fr')Hôtesses · Personnel événementiel · Activation de produits &amp; de marques @else Hostesses · Event staff · Product &amp; brand activation @endif
          <span aria-hidden="true" class="hidden h-px w-10 bg-accent sm:block"></span>
        </p>
      </x-ui.reveal-item>

      <x-ui.reveal-item>
        <h1 id="accueil-titre" class="font-display text-[clamp(2.5rem,1.2rem+4.6vw,5.75rem)] leading-[1.04] tracking-[-0.015em] text-fg">@if ($locale === 'fr')L’excellence de <span class="whitespace-nowrap">l’{!! $accent('accueil') !!}</span><br class="hidden md:block"> au service de votre image.@else{!! $accent('Hospitality') !!} excellence<br class="hidden md:block"> in service of your image.@endif</h1>
      </x-ui.reveal-item>

      <x-ui.reveal-item>
        <p class="max-w-xl text-lead text-white/85">{{ $locale === 'fr' ? 'Des équipes préparées, dynamiques et engagées pour accompagner entreprises, institutions et organisateurs.' : 'Prepared, dynamic and committed teams supporting companies, institutions and organisers.' }}</p>
      </x-ui.reveal-item>

      <x-ui.reveal-item class="flex w-full flex-col gap-3 pt-2 sm:w-auto sm:flex-row sm:gap-4">
        <x-ui.link :href="I18n::localizeHref(Site::PRIMARY_CTA_HREF, $locale)" appearance="primary" size="lg" icon="arrow-right" class="w-full sm:w-auto">{{ $text['primaryCta'] }}</x-ui.link>
        <x-ui.link href="#presentation" appearance="secondary" size="lg" class="w-full sm:w-auto">{{ $t['discover'] }}</x-ui.link>
      </x-ui.reveal-item>

      <x-ui.reveal-item class="md:hidden">
        <p class="font-sans text-[0.625rem] font-medium tracking-[0.2em] text-white/75 uppercase">{{ implode(' ', array_map(fn ($word) => "{$word}.", $text['signature'])) }}</p>
      </x-ui.reveal-item>
    </x-ui.reveal-group>
  </x-ui.container>

  <x-ui.container class="pointer-events-none absolute inset-x-0 bottom-0 flex h-[5.75rem] items-center">
    {{-- Room for the video play/pause button rendered by LazyVideo. --}}
    <span aria-hidden="true" class="size-11 shrink-0"></span>
    <x-ui.reveal variant="fade" :delay="0.9" class="ml-5 hidden md:block">
      <p class="flex gap-3 font-sans text-eyebrow font-medium tracking-[0.24em] text-white/75 uppercase">
        @foreach ($text['signature'] as $index => $word)
          <span class="flex gap-3">@if ($index > 0)<span aria-hidden="true" class="text-accent">·</span>@endif{{ $word }}.</span>
        @endforeach
      </p>
    </x-ui.reveal>

    <a href="#presentation" aria-label="{{ $t['scrollLabel'] }}" class="pointer-events-auto absolute bottom-6 left-1/2 hidden -translate-x-1/2 flex-col items-center gap-3 text-[0.625rem] font-medium tracking-[0.3em] text-white/70 uppercase transition-colors hover:text-white md:flex">
      <span aria-hidden="true">{{ $t['scroll'] }}</span>
      <span aria-hidden="true" class="relative h-12 w-px overflow-hidden bg-white/25">
        <span class="absolute inset-x-0 top-0 h-1/2 bg-white motion-safe:animate-scroll-cue"></span>
      </span>
    </a>
  </x-ui.container>
</section>

<section id="presentation" aria-label="{{ $t['about'] }}" class="tone-light bg-canvas text-fg">
  <x-ui.container :grid="true" class="gap-y-10 py-section">
    <div class="col-span-full flex items-center gap-5 text-eyebrow text-fg-muted uppercase">
      <span aria-hidden="true" class="font-display text-h3 tracking-normal text-accent normal-case">01</span>
      <x-ui.reveal as="span" variant="draw" class="block h-px flex-1 origin-left bg-line"></x-ui.reveal>
      <span>{{ $t['about'] }}</span>
    </div>

    <x-ui.reveal class="col-span-full lg:col-span-5">
      <div class="flex max-w-3xl flex-col gap-5">
        <x-ui.eyebrow>{{ Site::NAME }}</x-ui.eyebrow>
        <h2 class="text-h2 text-fg [&_em]:text-accent [&_em]:italic">@if ($locale === 'fr')L’<em>humain</em> au cœur de l’expérience.@else<em>People</em> at the heart of the experience.@endif</h2>
      </div>
    </x-ui.reveal>

    <x-ui.reveal :delay="0.1" class="col-span-full flex flex-col gap-10 lg:col-span-6 lg:col-start-7">
      <p class="text-lead text-fg-muted">{{ $team['agency'] }}</p>
      <div class="border-t border-line pt-8">
        <x-ui.eyebrow>Ambition</x-ui.eyebrow>
        <p class="mt-4 font-display text-h3 text-fg italic">{{ $open }}{{ $team['ambition'] }}{{ $close }}</p>
      </div>
    </x-ui.reveal>
  </x-ui.container>
</section>
