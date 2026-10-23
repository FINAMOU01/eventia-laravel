@extends('layouts.app')

@php
    $content = Content::get($locale);
    $intro = $content['realisationsIntro'];
    $spot = $content['eventiaSpot'];
    $t = [
        'fr' => [
            'backdrop' => 'Réalisations',
            'eyebrow' => 'Nos réalisations',
            'context' => 'Contexte : partenariat COMICA',
            'list' => 'Nos réalisations',
            'ctaEyebrow' => 'Vous préparez votre prochain événement ?',
        ],
        'en' => [
            'backdrop' => 'Our work',
            'eyebrow' => 'Our work',
            'context' => 'Background: COMICA partnership',
            'list' => 'Our work',
            'ctaEyebrow' => 'Preparing your next event?',
        ],
    ][$locale];
@endphp

@section('content')
  {{-- Hero --}}
  <section aria-labelledby="realisations-page-titre" class="tone-deep relative isolate overflow-hidden bg-ink text-fg">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(ellipse_70%_60%_at_85%_0%,rgb(4_58_164/0.55),transparent_70%),radial-gradient(ellipse_60%_50%_at_0%_100%,rgb(0_48_106/0.8),transparent_70%)]"></div>
    <span aria-hidden="true" class="pointer-events-none absolute -right-[0.06em] bottom-[-0.2em] -z-10 font-display text-[clamp(8rem,4rem+16vw,22rem)] leading-none text-white/[0.035] italic select-none">{{ $t['backdrop'] }}</span>

    <x-ui.container class="pt-[calc(var(--header-height)+2.5rem)] pb-section lg:pt-[calc(var(--header-height)+3.5rem)]">
      <x-ui.reveal-group :stagger="0.14" :delay="0.1" class="site-grid items-end gap-y-8">
        <x-ui.reveal-item class="col-span-full lg:col-span-8">
          <x-ui.eyebrow>{{ $t['eyebrow'] }}</x-ui.eyebrow>
          <h1 id="realisations-page-titre" class="mt-6 font-display text-[clamp(2.5rem,1.3rem+4.2vw,5.25rem)] leading-[1.05] tracking-[-0.015em] text-fg">@if ($locale === 'fr')<span class="block">Des événements.</span><span class="block">Des <em class="text-accent italic">visages</em>.</span><span class="block">Des expériences.</span>@else<span class="block">Events.</span><span class="block"><em class="text-accent italic">Faces</em>.</span><span class="block">Experiences.</span>@endif</h1>
        </x-ui.reveal-item>
        <x-ui.reveal-item class="col-span-full lg:col-span-4 lg:pb-3">
          <p class="max-w-md border-l border-accent/60 pl-5 text-lead text-fg-muted">{{ $intro['intro'] }}</p>
        </x-ui.reveal-item>
      </x-ui.reveal-group>
    </x-ui.container>
  </section>

  {{-- Context: COMICA partnership --}}
  <x-ui.section tone="surface" aria-label="{{ $t['context'] }}">
    <div class="site-grid items-center gap-y-12">
      <x-ui.reveal class="col-span-full lg:col-span-7">
        <x-ui.eyebrow>{{ $intro['category'] }}</x-ui.eyebrow>
        <p class="mt-8 font-display text-[clamp(1.625rem,1.2rem+1.6vw,2.625rem)] leading-[1.3] text-fg">{{ $intro['context'] }}</p>
      </x-ui.reveal>
      <x-ui.reveal variant="fade" :delay="0.1" class="col-span-full sm:col-span-6 sm:col-start-2 md:col-span-4 md:col-start-3 lg:col-span-4 lg:col-start-9">
        <x-site.media-slot-frame name="realisation-comica" :locale="$locale" ratio="portrait" tone="light" sizes="(min-width: 1024px) 30vw, 70vw" />
      </x-ui.reveal>
    </div>
  </x-ui.section>

  {{-- Projects --}}
  <section aria-label="{{ $t['list'] }}" class="tone-light bg-canvas text-fg">
    <x-ui.container>
      @foreach ($content['realisations'] as $index => $item)
        @php
            $reversed = $index % 2 === 1;
            $titleId = "{$item['id']}-titre";
            $lead = $item['slots'][0];
            $side = $item['slots'][1];
            $others = array_values(array_filter(array_slice($item['slots'], 2)));
        @endphp
        <article id="{{ $item['id'] }}" aria-labelledby="{{ $titleId }}" class="border-b border-line py-section last:border-b-0">
          <div class="site-grid items-end gap-y-6">
            <x-ui.reveal @class(['col-span-full flex items-end gap-6 lg:col-span-9', 'lg:col-start-4 lg:justify-end lg:text-right' => $reversed])>
              <span aria-hidden="true" @class(['font-display text-[clamp(4.5rem,3rem+6vw,10rem)] leading-[0.78] text-accent/15', 'lg:order-last' => $reversed])>{{ $item['number'] }}</span>
              <h2 id="{{ $titleId }}"><span class="block font-sans text-eyebrow font-medium tracking-[0.18em] text-accent uppercase">{{ $item['type'] }}</span><span class="sr-only">{{ $locale === 'fr' ? ' : ' : ': ' }}</span><span class="mt-3 block font-display text-[clamp(2rem,1.3rem+2.6vw,3.75rem)] leading-[1.08] text-fg">{{ $item['title'] }}</span></h2>
            </x-ui.reveal>
          </div>

          {{-- Row 1: lead + side at equal height; then the remaining photos two by two. --}}
          <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:mt-16 lg:grid-cols-12 lg:gap-6">
            <x-ui.reveal variant="fade" @class(['sm:col-span-2 lg:col-span-8 lg:row-start-1', 'lg:col-start-5' => $reversed, 'lg:col-start-1' => ! $reversed])>
              <x-site.media-slot-frame :name="$lead" :locale="$locale" ratio="landscape" tone="light" sizes="(min-width: 1024px) 66vw, 100vw" />
            </x-ui.reveal>

            <x-ui.reveal variant="fade" :delay="0.1" @class(['lg:col-span-4 lg:row-start-1', 'lg:col-start-1' => $reversed, 'lg:col-start-9' => ! $reversed, 'sm:col-span-2' => count($others) % 2 === 0])>
              <x-site.media-slot-frame :name="$side" :locale="$locale" ratio="fill" tone="light" :compact="true" class="aspect-4/3 lg:aspect-auto" sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw" />
            </x-ui.reveal>

            @foreach ($others as $i => $slot)
              <x-ui.reveal variant="fade" :delay="0.1 * ($i % 2)" @class(['lg:col-span-6', 'lg:col-span-12' => count($others) % 2 === 1 && $i === count($others) - 1])>
                <x-site.media-slot-frame :name="$slot" :locale="$locale" ratio="landscape" tone="light" sizes="(min-width: 640px) 50vw, 100vw" />
              </x-ui.reveal>
            @endforeach
          </div>
        </article>
      @endforeach
    </x-ui.container>
  </section>

  {{-- EVENTIA spot --}}
  <x-ui.section tone="deep" aria-labelledby="eventia-video-titre">
    <div class="site-grid items-end gap-y-6">
      <x-ui.reveal class="col-span-full lg:col-span-8">
        <x-ui.eyebrow>{{ $t['eyebrow'] }}</x-ui.eyebrow>
        <h2 id="eventia-video-titre" class="mt-5 text-h2 text-fg">EVENTIA <em class="text-accent italic">{{ $locale === 'fr' ? 'en vidéo' : 'on video' }}</em></h2>
      </x-ui.reveal>
    </div>

    <x-ui.reveal variant="fade" :delay="0.1" class="mt-10 lg:mt-14">
      <x-ui.video-lightbox :video="$spot" :locale="$locale" class="aspect-4/3 rounded-media sm:aspect-video">
        <x-ui.img src="/media/hero/spot-poster.jpg" alt="" sizes="(min-width: 1280px) 1248px, 100vw" class="object-cover transition-transform duration-700 ease-eventia group-hover/video:scale-103" />
        <span aria-hidden="true" class="absolute inset-0 bg-linear-to-t from-ink/70 via-ink/10 to-ink/20"></span>
        <span class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-4 p-6 sm:p-8">
          <span class="font-display text-h3 text-white">{{ $spot['title'] }}</span>
          <span class="text-eyebrow font-medium tracking-[0.18em] text-white/80 uppercase">1 min 26</span>
        </span>
      </x-ui.video-lightbox>
    </x-ui.reveal>
  </x-ui.section>

  <x-site.page-cta :locale="$locale" id="realisations-cta-titre" :eyebrow="$t['ctaEyebrow']" />
@endsection
