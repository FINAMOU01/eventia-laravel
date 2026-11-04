@extends('layouts.app')

@php
    $pole = Content::pole($page, $locale);
    $others = array_values(array_filter(Content::get($locale)['poles'], fn ($p) => $p['id'] !== $pole['id']));
    $t = [
        'fr' => [
            'eyebrow' => 'Nos expertises',
            'backdrop' => ['image' => 'Image', 'hotesses' => 'Hôtesses', 'events' => 'Events'],
            'description' => 'Présentation officielle du pôle',
            'gallery' => 'Le pôle en images',
            'others' => 'Nos autres expertises',
            'discover' => 'Découvrir',
            'ctaEyebrow' => 'Contact',
        ],
        'en' => [
            'eyebrow' => 'Our expertise',
            'backdrop' => ['image' => 'Image', 'hotesses' => 'Hostesses', 'events' => 'Events'],
            'description' => 'Official presentation of the division',
            'gallery' => 'The division in pictures',
            'others' => 'Our other areas of expertise',
            'discover' => 'Discover',
            'ctaEyebrow' => 'Contact',
        ],
    ][$locale];
    // Hero background: the division's main photo (same treatment as the recruitment hero).
    $heroImage = Media::slot($pole['slot'], $locale)['media'] ?? null;
    $heroImage = ($heroImage['kind'] ?? null) === 'image' ? $heroImage : null;
    $gallery = $pole['gallery'];
    $ctaHref = I18n::localizeHref(Site::PRIMARY_CTA_HREF, $locale).'?pole='.$pole['id'];
@endphp

@section('content')
  {{-- Hero: same treatment as the former Expertises / Réalisations heroes. --}}
  <section aria-labelledby="pole-titre" @class(['tone-deep relative isolate overflow-hidden bg-ink text-fg', 'flex min-h-[min(88svh,48rem)]' => $heroImage])>
    @if ($heroImage)
      <x-ui.img :src="$heroImage['src']" :alt="$heroImage['alt']" :preload="true" sizes="100vw" class="-z-20 object-cover object-[50%_20%]" />
      <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-deep/30"></div>
      <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-linear-to-t from-ink/95 via-ink/55 to-ink/60 lg:from-ink/95 lg:via-ink/50 lg:to-ink/35"></div>
    @else
      <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(ellipse_70%_60%_at_85%_0%,rgb(4_58_164/0.55),transparent_70%),radial-gradient(ellipse_60%_50%_at_0%_100%,rgb(0_48_106/0.8),transparent_70%)]"></div>
      <span aria-hidden="true" class="pointer-events-none absolute -right-[0.06em] bottom-[-0.2em] -z-10 font-display text-[clamp(8rem,4rem+16vw,22rem)] leading-none text-white/[0.035] italic select-none">{{ $t['backdrop'][$pole['id']] }}</span>
    @endif

    <x-ui.container @class(['pt-[calc(var(--header-height)+2.5rem)] pb-section lg:pt-[calc(var(--header-height)+3.5rem)]', 'flex flex-1 flex-col justify-end lg:pb-16' => $heroImage])>
      <x-ui.reveal-group :stagger="0.14" :delay="0.1" class="site-grid items-end gap-y-8">
        <x-ui.reveal-item class="col-span-full lg:col-span-8">
          <x-ui.eyebrow>{{ $t['eyebrow'] }} · {{ $pole['number'] }}</x-ui.eyebrow>
          <div class="mt-6">
            <x-site.pole-logo :pole="$pole" class="size-24 lg:size-28" lockup-class="text-[30px] lg:text-[38px]" fallback-class="font-sans text-button font-medium tracking-[0.18em] text-fg uppercase" />
          </div>
          <h1 id="pole-titre" class="mt-6 font-display text-[clamp(2.5rem,1.3rem+4.2vw,5.25rem)] leading-[1.05] tracking-[-0.015em] text-fg">{{ $pole['title'] }}</h1>
        </x-ui.reveal-item>
        <x-ui.reveal-item class="col-span-full flex flex-col gap-6 lg:col-span-4 lg:pb-3">
          <p class="max-w-md border-l border-accent/60 pl-5 font-display text-h3 text-fg italic">{{ $pole['signature'] }}</p>
          @if ($pole['description'])
            <p class="max-w-md text-lead text-fg-muted">{{ $pole['description'] }}</p>
          @else
            <x-site.pending-content :locale="$locale" :label="$t['description']" :compact="true" class="max-w-md" />
          @endif
          @isset($pole['cta'])
            <x-ui.link :href="$ctaHref" appearance="primary" size="lg" icon="arrow-right" class="w-full sm:w-auto sm:self-start">{{ $pole['cta'] }}</x-ui.link>
          @endisset
        </x-ui.reveal-item>
      </x-ui.reveal-group>
    </x-ui.container>
  </section>

  {{-- Official lists of the division (services, approach, field contexts, event types…), with the other photos after the first one. --}}
  @foreach ($pole['sections'] as $index => $section)
    @php
        $titleId = "pole-{$section['id']}-titre";
        $tone = $section['tone'] ?? ($index % 2 === 0 ? 'light' : 'surface');
        $pendingLabel = $section['eyebrow'].' — '.$pole['name'];
    @endphp
    @if ($section['layout'] === 'inline')
      <x-ui.section :tone="$tone" aria-labelledby="{{ $titleId }}">
        <x-ui.reveal class="flex flex-col items-center text-center">
          <x-ui.eyebrow>{{ $pole['name'] }}</x-ui.eyebrow>
          <h2 id="{{ $titleId }}" class="mt-5 text-h2 text-fg">{{ $section['eyebrow'] }}</h2>
        </x-ui.reveal>
        <div class="mx-auto mt-10 max-w-5xl lg:mt-12">
          <x-site.item-list :items="$section['items']" layout="inline" :locale="$locale" :pending-label="$pendingLabel" />
        </div>
      </x-ui.section>
    @else
      <x-ui.section :tone="$tone" aria-labelledby="{{ $titleId }}">
        <div class="site-grid gap-y-4">
          <div class="col-span-full lg:col-span-4">
            <x-ui.reveal class="lg:sticky lg:top-[calc(var(--header-height)+2.5rem)]">
              <x-ui.eyebrow>{{ $pole['name'] }}</x-ui.eyebrow>
              <h2 id="{{ $titleId }}" class="mt-5 text-h2 text-fg">{{ $section['eyebrow'] }}</h2>
              @isset($section['photo'])
                <div class="mt-10 hidden max-w-xs lg:block">
                  <x-site.media-slot-frame :name="$section['photo']" :locale="$locale" ratio="square" tone="light" sizes="20rem" />
                </div>
              @endisset
            </x-ui.reveal>
          </div>
          <div class="col-span-full mt-8 lg:col-span-8 lg:mt-0">
            <x-site.item-list :items="$section['items']" :layout="$section['layout']" :locale="$locale" :pending-label="$pendingLabel" />
          </div>
        </div>
      </x-ui.section>
    @endif

    {{-- The division's other photos: one row of equal frames instead of a large mosaic. --}}
    @if ($index === 0 && $gallery)
      <section aria-label="{{ $t['gallery'] }}" @class(['bg-canvas text-fg', 'tone-'.$tone])>
        <x-ui.container class="pb-section">
          <div @class(['grid grid-cols-2 gap-4 lg:gap-6', 'sm:grid-cols-3' => count($gallery) === 3, 'sm:grid-cols-4' => count($gallery) >= 4])>
            @foreach ($gallery as $i => $slot)
              <x-ui.reveal variant="fade" :delay="0.08 * $i" @class(['col-span-2 sm:col-span-1' => $i === 0 && count($gallery) % 2 === 1])>
                <x-site.media-slot-frame :name="$slot" :locale="$locale" ratio="landscape" tone="light" :compact="true" sizes="(min-width: 640px) 33vw, 50vw" />
              </x-ui.reveal>
            @endforeach
          </div>
        </x-ui.container>
      </section>
    @endif
  @endforeach

  {{-- Real assignments (Hôtesses): Miss Cameroun 2026 with the COMICA partnership poster, as on the former Réalisations page. --}}
  @isset($pole['missions'])
    @php $missions = $pole['missions']; @endphp
    <x-ui.section tone="surface" aria-labelledby="missions-titre">
      <div class="site-grid items-center gap-y-12">
        <x-ui.reveal class="col-span-full lg:col-span-8">
          <x-ui.eyebrow>{{ $missions['eyebrow'] }}</x-ui.eyebrow>
          <h2 id="missions-titre" class="mt-6"><span class="block font-sans text-eyebrow font-medium tracking-[0.18em] text-accent uppercase">{{ $missions['type'] }}</span><span class="sr-only">{{ $locale === 'fr' ? ' : ' : ': ' }}</span><span class="mt-3 block font-display text-[clamp(2rem,1.3rem+2.6vw,3.75rem)] leading-[1.08] text-fg">{{ $missions['title'] }}</span></h2>
          <p class="mt-8 font-display text-[clamp(1.375rem,1.1rem+1vw,2rem)] leading-[1.35] text-fg">{{ $missions['context'] }}</p>
        </x-ui.reveal>
        <x-ui.reveal variant="fade" :delay="0.1" class="col-span-full mx-auto w-full max-w-64 sm:max-w-xs lg:col-span-3 lg:col-start-10 lg:max-w-none">
          <x-site.media-slot-frame :name="$missions['poster']" :locale="$locale" ratio="portrait" tone="light" sizes="(min-width: 1024px) 22vw, 20rem" />
        </x-ui.reveal>
      </div>

      <div class="mt-12 grid grid-cols-2 gap-4 lg:mt-16 lg:grid-cols-4 lg:gap-6">
        @foreach ($missions['slots'] as $i => $slot)
          <x-ui.reveal variant="fade" :delay="0.08 * $i">
            <x-site.media-slot-frame :name="$slot" :locale="$locale" ratio="landscape" tone="light" :compact="true" sizes="(min-width: 1024px) 25vw, 50vw" />
          </x-ui.reveal>
        @endforeach
      </div>
    </x-ui.section>
  @endisset

  {{-- The two other divisions. --}}
  <x-ui.section tone="deep" aria-labelledby="autres-poles-titre">
    <x-ui.reveal>
      <x-ui.eyebrow>EVENTIA SARL</x-ui.eyebrow>
      <h2 id="autres-poles-titre" class="mt-5 text-h2 text-fg">{{ $t['others'] }}</h2>
    </x-ui.reveal>
    <x-ui.reveal-group as="ul" :stagger="0.1" class="mt-10 grid gap-4 md:grid-cols-2 lg:mt-14 lg:gap-6">
      @foreach ($others as $other)
        <x-ui.reveal-item as="li">
          <x-site.pole-card :pole="$other" :locale="$locale" :label="$t['discover']" class="lg:min-h-80 xl:aspect-16/10" />
        </x-ui.reveal-item>
      @endforeach
    </x-ui.reveal-group>
  </x-ui.section>

  <x-site.page-cta :locale="$locale" id="pole-cta-titre" :eyebrow="$t['ctaEyebrow']" :label="$pole['cta'] ?? null" :href="isset($pole['cta']) ? $ctaHref : null" />
@endsection
