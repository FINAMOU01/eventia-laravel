@extends('layouts.app')

@php
    $content = Content::get($locale);
    $team = $content['team'];
    [$open, $close] = I18n::quoteMarks($locale);
    $t = [
        'fr' => [
            'heroAlt' => 'Noura Njikam, Miss World Cameroun 2026, entourée des hôtesses EVENTIA en uniforme bleu',
            'eyebrow' => 'L’équipe',
            'vision' => 'La vision',
            'quoteLabel' => 'Citation de Noura Njikam',
            'ourTeam' => 'Notre équipe',
            'mission' => 'Pour chaque mission, EVENTIA constitue une équipe adaptée, briefée et préparée selon les exigences de votre événement.',
            'values' => 'Nos valeurs',
            'onSite' => 'Sur le terrain',
            'ctaEyebrow' => 'Vous préparez votre prochain événement ?',
        ],
        'en' => [
            'heroAlt' => 'Noura Njikam, Miss World Cameroun 2026, surrounded by EVENTIA hostesses in blue uniforms',
            'eyebrow' => 'The team',
            'vision' => 'The vision',
            'quoteLabel' => 'Quote from Noura Njikam',
            'ourTeam' => 'Our team',
            'mission' => 'For every assignment, EVENTIA builds a suitable team, briefed and prepared according to the requirements of your event.',
            'values' => 'Our values',
            'onSite' => 'On site',
            'ctaEyebrow' => 'Preparing your next event?',
        ],
    ][$locale];
@endphp

@section('content')
  {{-- Hero --}}
  <section aria-labelledby="equipe-page-titre" class="tone-deep relative isolate flex h-[min(90svh,54rem)] min-h-[40rem] overflow-hidden bg-deep text-fg">
    {{-- The cut-out has a transparent background: this backdrop shows between the people. --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-30 bg-[radial-gradient(ellipse_80%_70%_at_60%_30%,rgb(4_58_164/0.9),transparent_70%),linear-gradient(to_bottom,var(--color-deep),var(--color-ink))]"></div>
    {{-- Starts below the fixed header so heads are never hidden or cropped. --}}
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
          <h1 id="equipe-page-titre" class="mt-6 font-display text-[clamp(2.5rem,1.3rem+3.8vw,5rem)] leading-[1.04] tracking-[-0.015em] text-white">@foreach ($team['headline'] as $index => $line)<span class="block">@if ($index === 1)<em class="text-accent italic">{{ $line }}</em>@else{{ $line }}@endif</span>@endforeach</h1>
        </x-ui.reveal-item>
        <x-ui.reveal-item>
          <p class="mt-6 max-w-xl text-lead text-white/85">{{ $team['summary'] }}</p>
        </x-ui.reveal-item>
      </x-ui.reveal-group>
    </x-ui.container>
  </section>

  {{-- Vision --}}
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

  {{-- Quote --}}
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

  {{-- Our team --}}
  <x-ui.section tone="surface" aria-labelledby="notre-equipe-titre">
    <div class="site-grid gap-y-10 lg:py-6">
      <x-ui.reveal class="col-span-full lg:col-span-5">
        <x-ui.eyebrow>{{ $t['ourTeam'] }}</x-ui.eyebrow>
        <h2 id="notre-equipe-titre" class="mt-6 font-display text-[clamp(2.25rem,1.5rem+2.6vw,3.75rem)] leading-[1.08] tracking-[-0.01em] text-fg">@if ($locale === 'fr')Préparée. Briefée. <em class="text-accent italic">Engagée.</em>@else Prepared. Briefed. <em class="text-accent italic">Committed.</em>@endif</h2>
      </x-ui.reveal>
      <x-ui.reveal :delay="0.1" class="col-span-full flex flex-col gap-6 lg:col-span-6 lg:col-start-7 lg:pt-14">
        <p class="text-lead text-fg-muted">{{ $team['crew'] }}</p>
        <p class="text-body text-fg-muted">{{ $t['mission'] }}</p>
      </x-ui.reveal>
    </div>

    <h3 class="sr-only">{{ $t['values'] }}</h3>
    <x-ui.reveal-group as="ol" :stagger="0.1" class="mt-14 grid border-t border-line sm:grid-cols-2 lg:mt-20 xl:grid-cols-4">
      @foreach ($content['teamValues'] as $index => $value)
        <x-ui.reveal-item as="li" class="flex min-w-0 items-baseline gap-4 border-b border-line py-8 sm:odd:pr-6 sm:even:border-l sm:even:pl-6 xl:flex-col xl:gap-6 xl:border-b-0 xl:border-l xl:py-10 xl:pl-6 xl:first:border-l-0 xl:first:pl-0">
          <span aria-hidden="true" class="font-display text-h3 leading-none text-accent/40">{{ Web::pad($index + 1) }}</span>
          <span class="font-display text-[clamp(1.625rem,1.1rem+1.5vw,2.5rem)] leading-none text-fg xl:text-[clamp(1.5rem,0.4rem+1.5vw,2.125rem)]">{{ $value }}.</span>
        </x-ui.reveal-item>
      @endforeach
    </x-ui.reveal-group>
  </x-ui.section>

  {{-- On site --}}
  <x-ui.section tone="light" aria-labelledby="terrain-titre">
    <div class="site-grid items-end gap-y-10">
      <x-ui.reveal class="col-span-full lg:col-span-5 lg:pb-10">
        <x-ui.eyebrow>{{ $t['onSite'] }}</x-ui.eyebrow>
        <h2 id="terrain-titre" class="mt-6 text-h2 text-fg">@if ($locale === 'fr')Présente sur le terrain pour <em class="text-accent italic">représenter votre image</em>.@else On site to <em class="text-accent italic">represent your image</em>.@endif</h2>
      </x-ui.reveal>
      <x-ui.reveal variant="fade" :delay="0.1" class="col-span-full sm:col-span-6 sm:col-start-2 md:col-span-5 md:col-start-3 lg:col-span-5 lg:col-start-7">
        <x-site.media-slot-frame name="equipe-terrain" :locale="$locale" ratio="portrait" tone="light" sizes="(min-width: 1024px) 40vw, 80vw" />
      </x-ui.reveal>
    </div>
  </x-ui.section>

  <x-site.page-cta :locale="$locale" id="equipe-cta-titre" :eyebrow="$t['ctaEyebrow']" />
@endsection
