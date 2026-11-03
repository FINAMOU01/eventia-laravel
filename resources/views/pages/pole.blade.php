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
    $photos = array_merge([$pole['slot']], $pole['gallery']);
    // A division with a single photo uses it as the hero background (same treatment as the recruitment hero).
    $heroImage = empty($pole['gallery']) ? (Media::slot($pole['slot'], $locale)['media'] ?? null) : null;
    $heroImage = ($heroImage['kind'] ?? null) === 'image' ? $heroImage : null;
    $lead = $photos[0];
    $side = $photos[1] ?? null;
    $rest = array_slice($photos, 2);
    $tones = ['light', 'surface'];
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
            <x-site.pole-logo :pole="$pole" class="h-14 w-auto lg:h-16" fallback-class="font-sans text-button font-medium tracking-[0.18em] text-fg uppercase" />
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

  {{-- Photos of the division (existing photos only); same grid as the former Réalisations page. --}}
  @unless ($heroImage)
  <section aria-label="{{ $t['gallery'] }}" class="tone-light bg-canvas text-fg">
    <x-ui.container class="py-section">
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-12 lg:gap-6">
        <x-ui.reveal variant="fade" @class(['sm:col-span-2 lg:row-start-1', 'lg:col-span-8' => $side, 'lg:col-span-12' => ! $side])>
          <x-site.media-slot-frame :name="$lead" :locale="$locale" :ratio="$side ? 'landscape' : 'wide'" tone="light" sizes="(min-width: 1024px) 66vw, 100vw" />
        </x-ui.reveal>
        @if ($side)
          <x-ui.reveal variant="fade" :delay="0.1" @class(['lg:col-span-4 lg:col-start-9 lg:row-start-1', 'sm:col-span-2' => count($rest) % 2 === 0])>
            <x-site.media-slot-frame :name="$side" :locale="$locale" ratio="fill" tone="light" :compact="true" class="aspect-4/3 lg:aspect-auto" sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw" />
          </x-ui.reveal>
        @endif
        @foreach ($rest as $i => $slot)
          <x-ui.reveal variant="fade" :delay="0.1 * ($i % 2)" @class(['lg:col-span-6', 'lg:col-span-12' => count($rest) % 2 === 1 && $i === count($rest) - 1])>
            <x-site.media-slot-frame :name="$slot" :locale="$locale" ratio="landscape" tone="light" sizes="(min-width: 640px) 50vw, 100vw" />
          </x-ui.reveal>
        @endforeach
      </div>
    </x-ui.container>
  </section>
  @endunless

  {{-- Official lists of the division (services, approach, field contexts, event types…). --}}
  @foreach ($pole['sections'] as $index => $section)
    @php $titleId = "pole-{$section['id']}-titre"; @endphp
    <x-ui.section :tone="$tones[($index + 1) % 2]" aria-labelledby="{{ $titleId }}">
      <div class="site-grid gap-y-4 lg:py-6">
        <div class="col-span-full lg:col-span-4">
          <x-ui.reveal class="lg:sticky lg:top-[calc(var(--header-height)+2.5rem)]">
            <x-ui.eyebrow>{{ $pole['name'] }}</x-ui.eyebrow>
            <h2 id="{{ $titleId }}" class="mt-5 text-h2 text-fg">{{ $section['eyebrow'] }}</h2>
          </x-ui.reveal>
        </div>
        <div class="col-span-full mt-8 lg:col-span-8 lg:mt-0">
          <x-site.item-list :items="$section['items']" :layout="$section['layout']" :locale="$locale" :pending-label="$section['eyebrow'].' — '.$pole['name']" />
        </div>
      </div>
    </x-ui.section>
  @endforeach

  {{-- Real assignments (Hôtesses): Miss Cameroun 2026 with the COMICA partnership poster, as on the former Réalisations page. --}}
  @isset($pole['missions'])
    @php $missions = $pole['missions']; @endphp
    <x-ui.section tone="surface" aria-labelledby="missions-titre">
      <div class="site-grid items-center gap-y-12">
        <x-ui.reveal class="col-span-full lg:col-span-7">
          <x-ui.eyebrow>{{ $missions['eyebrow'] }}</x-ui.eyebrow>
          <h2 id="missions-titre" class="mt-6"><span class="block font-sans text-eyebrow font-medium tracking-[0.18em] text-accent uppercase">{{ $missions['type'] }}</span><span class="sr-only">{{ $locale === 'fr' ? ' : ' : ': ' }}</span><span class="mt-3 block font-display text-[clamp(2rem,1.3rem+2.6vw,3.75rem)] leading-[1.08] text-fg">{{ $missions['title'] }}</span></h2>
          <p class="mt-8 font-display text-[clamp(1.375rem,1.1rem+1vw,2rem)] leading-[1.35] text-fg">{{ $missions['context'] }}</p>
        </x-ui.reveal>
        <x-ui.reveal variant="fade" :delay="0.1" class="col-span-full sm:col-span-6 sm:col-start-2 md:col-span-4 md:col-start-3 lg:col-span-4 lg:col-start-9">
          <x-site.media-slot-frame :name="$missions['poster']" :locale="$locale" ratio="portrait" tone="light" sizes="(min-width: 1024px) 30vw, 70vw" />
        </x-ui.reveal>
      </div>

      @php
          [$mLead, $mSide] = $missions['slots'];
          $mRest = array_slice($missions['slots'], 2);
      @endphp
      <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:mt-16 lg:grid-cols-12 lg:gap-6">
        <x-ui.reveal variant="fade" class="sm:col-span-2 lg:col-span-8 lg:row-start-1">
          <x-site.media-slot-frame :name="$mLead" :locale="$locale" ratio="landscape" tone="light" sizes="(min-width: 1024px) 66vw, 100vw" />
        </x-ui.reveal>
        <x-ui.reveal variant="fade" :delay="0.1" @class(['lg:col-span-4 lg:col-start-9 lg:row-start-1', 'sm:col-span-2' => count($mRest) % 2 === 0])>
          <x-site.media-slot-frame :name="$mSide" :locale="$locale" ratio="fill" tone="light" :compact="true" class="aspect-4/3 lg:aspect-auto" sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw" />
        </x-ui.reveal>
        @foreach ($mRest as $i => $slot)
          <x-ui.reveal variant="fade" :delay="0.1 * ($i % 2)" class="lg:col-span-6">
            <x-site.media-slot-frame :name="$slot" :locale="$locale" ratio="landscape" tone="light" sizes="(min-width: 640px) 50vw, 100vw" />
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
    <x-ui.reveal-group as="ul" :stagger="0.1" class="mt-12 grid border-t border-line md:grid-cols-2 lg:mt-16">
      @foreach ($others as $other)
        <x-ui.reveal-item as="li" class="border-b border-line md:odd:pr-8 md:even:border-l md:even:pl-8">
          <a href="{{ I18n::localizeHref(Metadata::PATHS[$other['id']], $locale) }}" class="group/pole flex h-full flex-col gap-5 py-10">
            <span aria-hidden="true" class="font-display text-h3 leading-none text-accent/40 transition-colors duration-500 group-hover/pole:text-accent">{{ $other['number'] }}</span>
            <x-site.pole-logo :pole="$other" class="h-12 w-auto" fallback-class="font-sans text-button font-medium tracking-[0.18em] text-fg uppercase" />
            <span class="font-display text-[clamp(1.5rem,1.1rem+1.4vw,2.25rem)] leading-[1.15] text-fg italic transition-transform duration-500 ease-eventia motion-safe:group-hover/pole:translate-x-1.5">{{ $other['signature'] }}</span>
            <span class="mt-auto inline-flex items-center gap-3 font-sans text-button tracking-[0.12em] text-fg uppercase transition-colors group-hover/pole:text-accent">{{ $t['discover'] }}<x-icon name="arrow-right" class="size-4 transition-transform duration-300 group-hover/pole:translate-x-1" /></span>
          </a>
        </x-ui.reveal-item>
      @endforeach
    </x-ui.reveal-group>
  </x-ui.section>

  <x-site.page-cta :locale="$locale" id="pole-cta-titre" :eyebrow="$t['ctaEyebrow']" :label="$pole['cta'] ?? null" :href="isset($pole['cta']) ? $ctaHref : null" />
@endsection
