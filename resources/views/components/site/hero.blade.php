@props(['locale'])
@php
    $text = Site::text($locale);
    $home = Content::get($locale)['home'];
    $t = [
        'fr' => ['discover' => 'Découvrir nos expertises', 'scrollLabel' => 'Faire défiler vers nos expertises', 'scroll' => 'Défiler'],
        'en' => ['discover' => 'Discover our expertise', 'scrollLabel' => 'Scroll to our expertise', 'scroll' => 'Scroll'],
    ][$locale];
    // Accent word of the official title, underlined once the title has appeared (same effect as before).
    $accent = fn (string $word) => '<em class="relative text-accent italic">'.e($word).'<span aria-hidden="true" class="absolute inset-x-0 bottom-[0.02em]"><span data-reveal="draw" data-reveal-delay="1.1" class="block h-px origin-left bg-accent/70" style="'.Ui::revealStyle('draw').'"></span></span></em>';
    [$before, $word] = $locale === 'fr' ? ['Nous créons ce qui vous ', 'distingue'] : ['We create what sets you ', 'apart'];
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
          {{ $home['eyebrow'] }}
          <span aria-hidden="true" class="hidden h-px w-10 bg-accent sm:block"></span>
        </p>
      </x-ui.reveal-item>

      <x-ui.reveal-item>
        <h1 id="accueil-titre" class="font-display text-[clamp(2.5rem,1.2rem+4.6vw,5.75rem)] leading-[1.04] tracking-[-0.015em] text-fg">{{ $before }}<span class="whitespace-nowrap">{!! $accent($word) !!}.</span></h1>
      </x-ui.reveal-item>

      <x-ui.reveal-item>
        <p class="max-w-2xl text-lead text-white/85">{{ $home['text'] }}</p>
      </x-ui.reveal-item>

      <x-ui.reveal-item class="flex w-full flex-col gap-3 pt-2 sm:w-auto sm:flex-row sm:gap-4">
        <x-ui.link :href="I18n::localizeHref(Site::PRIMARY_CTA_HREF, $locale)" appearance="primary" size="lg" icon="arrow-right" class="w-full sm:w-auto">{{ $text['primaryCta'] }}</x-ui.link>
        <x-ui.link href="#expertise" appearance="secondary" size="lg" class="w-full sm:w-auto">{{ $t['discover'] }}</x-ui.link>
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

    <a href="#expertise" aria-label="{{ $t['scrollLabel'] }}" class="pointer-events-auto absolute bottom-6 left-1/2 hidden -translate-x-1/2 flex-col items-center gap-3 text-[0.625rem] font-medium tracking-[0.3em] text-white/70 uppercase transition-colors hover:text-white md:flex">
      <span aria-hidden="true">{{ $t['scroll'] }}</span>
      <span aria-hidden="true" class="relative h-12 w-px overflow-hidden bg-white/25">
        <span class="absolute inset-x-0 top-0 h-1/2 bg-white motion-safe:animate-scroll-cue"></span>
      </span>
    </a>
  </x-ui.container>
</section>
