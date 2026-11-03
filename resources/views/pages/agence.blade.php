@extends('layouts.app')

@php
    $content = Content::get($locale);
    $agency = $content['agency'];
    $team = $content['team'];
    [$open, $close] = I18n::quoteMarks($locale);
    $t = [
        'fr' => [
            'heroAlt' => 'Noura Njikam, Miss World Cameroun 2026, entourée des hôtesses EVENTIA en uniforme bleu',
            'eyebrow' => 'L’agence',
            'presentation' => 'Présentation d’EVENTIA SARL',
            'mission' => 'Notre mission',
            'signature' => 'Notre signature',
            'poles' => 'Nos expertises',
            'commitments' => 'Nos engagements',
            'commitmentsPending' => 'Les cinq engagements d’EVENTIA SARL',
            'vision' => 'La vision',
            'quoteLabel' => 'Citation de Noura Njikam',
            'discover' => 'Découvrir',
        ],
        'en' => [
            'heroAlt' => 'Noura Njikam, Miss World Cameroun 2026, surrounded by EVENTIA hostesses in blue uniforms',
            'eyebrow' => 'The agency',
            'presentation' => 'Presentation of EVENTIA SARL',
            'mission' => 'Our mission',
            'signature' => 'Our signature',
            'poles' => 'Our expertise',
            'commitments' => 'Our commitments',
            'commitmentsPending' => 'The five commitments of EVENTIA SARL',
            'vision' => 'The vision',
            'quoteLabel' => 'Quote from Noura Njikam',
            'discover' => 'Discover',
        ],
    ][$locale];
@endphp

@section('content')
  {{-- Hero: same treatment as the former Équipe page (transparent team cut-out over the deep backdrop). --}}
  <section aria-labelledby="agence-titre" class="tone-deep relative isolate flex h-[min(90svh,54rem)] min-h-[40rem] overflow-hidden bg-deep text-fg">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-30 bg-[radial-gradient(ellipse_80%_70%_at_60%_30%,rgb(4_58_164/0.9),transparent_70%),linear-gradient(to_bottom,var(--color-deep),var(--color-ink))]"></div>
    <div class="absolute inset-x-0 top-[calc(var(--header-height)+1.5rem)] bottom-0 -z-20">
      <x-ui.img src="/media/equipe/equipe2-cutout.png" :alt="$t['heroAlt']" :preload="true" sizes="100vw" class="object-cover object-top" />
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-deep/10"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-linear-to-t from-ink/85 via-ink/20 to-ink/30 lg:bg-linear-to-r lg:from-ink/75 lg:via-ink/25 lg:to-transparent"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 bottom-0 -z-10 h-1/2 bg-linear-to-t from-ink/70 to-transparent"></div>

    <x-ui.container class="flex flex-1 flex-col justify-end pt-[calc(var(--header-height)+2rem)] pb-10 lg:pb-14">
      <x-ui.reveal-group :stagger="0.14" :delay="0.1" class="max-w-3xl">
        <x-ui.reveal-item>
          <x-ui.eyebrow>{{ $t['eyebrow'] }}</x-ui.eyebrow>
        </x-ui.reveal-item>
        <x-ui.reveal-item>
          <h1 id="agence-titre" class="mt-6 font-display text-[clamp(2.5rem,1.3rem+3.8vw,5rem)] leading-[1.04] tracking-[-0.015em] text-white">{{ $agency['title'] }}</h1>
        </x-ui.reveal-item>
      </x-ui.reveal-group>
    </x-ui.container>
  </section>

  {{-- EVENTIA SARL: presentation, mission and signature. --}}
  <x-ui.section tone="light" aria-labelledby="presentation-titre">
    <div class="site-grid gap-y-12 lg:py-6">
      <x-ui.reveal class="col-span-full lg:col-span-5">
        <x-ui.eyebrow>EVENTIA SARL</x-ui.eyebrow>
        <h2 id="presentation-titre" class="mt-6 text-h2 text-fg">{{ $t['presentation'] }}</h2>
      </x-ui.reveal>
      <x-ui.reveal :delay="0.1" class="col-span-full flex flex-col gap-10 lg:col-span-6 lg:col-start-7">
        @if ($agency['presentation'])
          <p class="text-lead text-fg-muted">{{ $agency['presentation'] }}</p>
        @else
          <x-site.pending-content :locale="$locale" :label="$t['presentation']" />
        @endif
        <div class="border-t border-line pt-8">
          <x-ui.eyebrow>{{ $t['mission'] }}</x-ui.eyebrow>
          @if ($agency['mission'])
            <p class="mt-4 text-lead text-fg">{{ $agency['mission'] }}</p>
          @else
            <x-site.pending-content :locale="$locale" :label="$t['mission']" :compact="true" class="mt-4" />
          @endif
        </div>
        <div class="border-t border-line pt-8">
          <x-ui.eyebrow>{{ $t['signature'] }}</x-ui.eyebrow>
          @if ($agency['signature'])
            <p class="mt-4 font-display text-h3 text-fg italic">{{ $agency['signature'] }}</p>
          @else
            <x-site.pending-content :locale="$locale" :label="$t['signature']" :compact="true" class="mt-4" />
          @endif
        </div>
      </x-ui.reveal>
    </div>
  </x-ui.section>

  {{-- The three divisions. --}}
  <x-ui.section tone="deep" aria-labelledby="agence-poles-titre">
    <x-ui.reveal>
      <x-ui.eyebrow>EVENTIA SARL</x-ui.eyebrow>
      <h2 id="agence-poles-titre" class="mt-5 text-h2 text-fg">{{ $t['poles'] }}</h2>
    </x-ui.reveal>
    <x-ui.reveal-group as="ul" :stagger="0.1" class="mt-12 grid border-t border-line lg:mt-16 lg:grid-cols-3">
      @foreach ($content['poles'] as $pole)
        <x-ui.reveal-item as="li" class="border-b border-line lg:border-l lg:px-8 lg:first:border-l-0 lg:first:pl-0 lg:last:pr-0">
          <a href="{{ I18n::localizeHref(Metadata::PATHS[$pole['id']], $locale) }}" class="group/pole flex h-full flex-col gap-5 py-10">
            <span aria-hidden="true" class="font-display text-h3 leading-none text-accent/40 transition-colors duration-500 group-hover/pole:text-accent">{{ $pole['number'] }}</span>
            <x-site.pole-logo :pole="$pole" class="h-12 w-auto" fallback-class="font-sans text-button font-medium tracking-[0.18em] text-fg uppercase" />
            <span class="font-display text-[clamp(1.375rem,1.1rem+1vw,2rem)] leading-[1.2] text-fg italic transition-transform duration-500 ease-eventia motion-safe:group-hover/pole:translate-x-1.5">{{ $pole['signature'] }}</span>
            <span class="mt-auto inline-flex items-center gap-3 font-sans text-button tracking-[0.12em] text-fg uppercase transition-colors group-hover/pole:text-accent">{{ $t['discover'] }}<x-icon name="arrow-right" class="size-4 transition-transform duration-300 group-hover/pole:translate-x-1" /></span>
          </a>
        </x-ui.reveal-item>
      @endforeach
    </x-ui.reveal-group>
  </x-ui.section>

  {{-- Five commitments. --}}
  <x-ui.section tone="surface" aria-labelledby="engagements-titre">
    <div class="site-grid gap-y-4 lg:py-6">
      <div class="col-span-full lg:col-span-4">
        <x-ui.reveal class="lg:sticky lg:top-[calc(var(--header-height)+2.5rem)]">
          <x-ui.eyebrow>EVENTIA SARL</x-ui.eyebrow>
          <h2 id="engagements-titre" class="mt-5 text-h2 text-fg">{{ $t['commitments'] }}</h2>
        </x-ui.reveal>
      </div>
      <div class="col-span-full mt-8 lg:col-span-8 lg:mt-0">
        <x-site.item-list :items="$agency['commitments']" layout="list" :locale="$locale" :pending-label="$t['commitmentsPending']" />
      </div>
    </div>
  </x-ui.section>

  {{-- Noura Njikam, kept from the former Équipe page at the client's request. --}}
  <x-ui.section tone="light" aria-labelledby="vision-titre">
    <div class="site-grid items-center gap-y-12 lg:py-8">
      <x-ui.reveal variant="fade" class="col-span-full sm:col-span-6 sm:col-start-2 md:col-span-5 md:col-start-2 lg:col-span-5 lg:col-start-1">
        <figure>
          <x-site.media-slot-frame name="equipe-noura" :locale="$locale" ratio="portrait" tone="light" sizes="(min-width: 1024px) 40vw, 80vw" />
          <figcaption class="mt-5 flex flex-col gap-1">
            <span class="font-display text-h3 text-fg">{{ $team['leader']['name'] }}</span>
            <span class="text-eyebrow font-medium tracking-[0.18em] text-accent uppercase">{{ $team['leader']['role'] }}</span>
            <span class="mt-1 text-small text-fg-muted">{{ $team['leader']['titles'] }}</span>
          </figcaption>
        </figure>
      </x-ui.reveal>

      <x-ui.reveal :delay="0.1" class="col-span-full lg:col-span-6 lg:col-start-7">
        <x-ui.eyebrow>{{ $t['vision'] }}</x-ui.eyebrow>
        <h2 id="vision-titre" class="mt-6 font-display text-[clamp(2rem,1.4rem+2.4vw,3.5rem)] leading-[1.1] tracking-[-0.01em] text-fg">@if ($locale === 'fr')Une vision portée par Madame <em class="text-accent italic">{{ $team['leader']['name'] }}</em>@else A vision led by <em class="text-accent italic">{{ $team['leader']['name'] }}</em>@endif</h2>
        <p class="mt-8 text-lead text-fg-muted">{{ $team['agency'] }}</p>
        <div class="mt-10 border-t border-line pt-8">
          <x-ui.eyebrow>Ambition</x-ui.eyebrow>
          <p class="mt-4 font-display text-h3 text-fg italic">{{ $open }}{{ $team['ambition'] }}{{ $close }}</p>
        </div>
      </x-ui.reveal>
    </div>
  </x-ui.section>

  <x-ui.section tone="deep" aria-label="{{ $t['quoteLabel'] }}">
    <x-ui.reveal class="mx-auto max-w-5xl py-6 text-center lg:py-12">
      <figure>
        <blockquote>
          <p class="font-display text-[clamp(2rem,1.2rem+3.2vw,4.25rem)] leading-[1.12] text-fg italic"><x-site.team-quote :locale="$locale" /></p>
        </blockquote>
        <figcaption class="mt-8 text-eyebrow font-medium tracking-[0.18em] text-fg-muted uppercase">{{ $team['leader']['name'] }} <span aria-hidden="true">·</span> {{ $team['leader']['role'] }}</figcaption>
      </figure>
    </x-ui.reveal>
  </x-ui.section>

  <x-site.page-cta :locale="$locale" id="agence-cta-titre" eyebrow="Contact" />
@endsection
