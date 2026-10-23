@extends('layouts.app')

@php
    $content = Content::get($locale);
    $t = [
        'fr' => [
            'eyebrow' => 'Nos expertises',
            'lead' => 'EVENTIA met à votre disposition des équipes formées, préparées et professionnelles, adaptées à chaque type d’événement et d’expérience de marque.',
            'groups' => ['coeur' => 'Cœur de métier', 'elargie' => 'Offre élargie'],
            'list' => 'Nos neuf expertises',
            'method' => 'Notre méthode',
            'ctaEyebrow' => 'Vous avez un événement à préparer ?',
        ],
        'en' => [
            'eyebrow' => 'Our expertise',
            'lead' => 'EVENTIA provides trained, prepared and professional teams, adapted to every type of event and brand experience.',
            'groups' => ['coeur' => 'Core business', 'elargie' => 'Extended offer'],
            'list' => 'Our nine areas of expertise',
            'method' => 'Our method',
            'ctaEyebrow' => 'Do you have an event to prepare?',
        ],
    ][$locale];
    $groups = [['id' => 'coeur', 'range' => '01 — 05'], ['id' => 'elargie', 'range' => '06 — 09']];
@endphp

@section('content')
  {{-- Hero --}}
  <section aria-labelledby="expertises-titre" class="tone-deep relative isolate overflow-hidden bg-ink text-fg">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(ellipse_70%_60%_at_85%_0%,rgb(4_58_164/0.55),transparent_70%),radial-gradient(ellipse_60%_50%_at_0%_100%,rgb(0_48_106/0.8),transparent_70%)]"></div>
    <span aria-hidden="true" class="pointer-events-none absolute -right-[0.06em] bottom-[-0.2em] -z-10 font-display text-[clamp(8rem,4rem+16vw,22rem)] leading-none text-white/[0.035] italic select-none">{{ $locale === 'fr' ? 'Expertises' : 'Expertise' }}</span>

    <x-ui.container class="pt-[calc(var(--header-height)+2.5rem)] pb-section lg:pt-[calc(var(--header-height)+3.5rem)]">
      <x-ui.reveal-group :stagger="0.14" :delay="0.1" class="site-grid items-end gap-y-8">
        <x-ui.reveal-item class="col-span-full lg:col-span-8">
          <x-ui.eyebrow>{{ $t['eyebrow'] }}</x-ui.eyebrow>
          <h1 id="expertises-titre" class="mt-6 font-display text-[clamp(2.5rem,1.3rem+4.2vw,5.25rem)] leading-[1.05] tracking-[-0.015em] text-fg">@if ($locale === 'fr')Des équipes adaptées <br class="hidden sm:block">à <em class="text-accent italic">chaque événement</em>.@else Teams adapted <br class="hidden sm:block">to <em class="text-accent italic">every event</em>.@endif</h1>
        </x-ui.reveal-item>
        <x-ui.reveal-item class="col-span-full lg:col-span-4 lg:pb-3">
          <p class="max-w-md border-l border-accent/60 pl-5 text-lead text-fg-muted">{{ $t['lead'] }}</p>
        </x-ui.reveal-item>
      </x-ui.reveal-group>
    </x-ui.container>
  </section>

  {{-- The nine expertises, in two groups --}}
  <section aria-label="{{ $t['list'] }}" class="tone-light bg-canvas text-fg">
    <x-ui.container>
      @foreach ($groups as $group)
        @php $titleId = "expertises-{$group['id']}-titre"; @endphp
        <section aria-labelledby="{{ $titleId }}" class="site-grid gap-y-4 border-t border-line py-section first:border-t-0">
          <div class="col-span-full lg:col-span-4">
            <x-ui.reveal class="lg:sticky lg:top-[calc(var(--header-height)+2.5rem)]">
              <x-ui.eyebrow>{{ $group['range'] }}</x-ui.eyebrow>
              <h2 id="{{ $titleId }}" class="mt-5 font-display text-h3 text-fg">{{ $t['groups'][$group['id']] }}</h2>
            </x-ui.reveal>
          </div>
          <ol class="col-span-full lg:col-span-8">
            @foreach (array_filter($content['expertises'], fn ($item) => $item['group'] === $group['id']) as $item)
              <li id="{{ $item['id'] }}" class="group/expertise relative border-b border-line last:border-b-0">
                <x-ui.reveal class="grid gap-6 py-10 sm:grid-cols-[auto_minmax(0,1fr)] sm:gap-x-10 lg:py-12 xl:grid-cols-[auto_minmax(0,1fr)_minmax(0,40%)] xl:items-center">
                  <span aria-hidden="true" class="font-display text-[clamp(3rem,2.2rem+3vw,5.5rem)] leading-[0.85] text-accent/20 transition-colors duration-700 ease-eventia group-hover/expertise:text-accent/60 sm:w-[2.2ch] xl:self-start">{{ $item['number'] }}</span>
                  <div class="min-w-0 sm:pt-2">
                    <h3 class="font-display text-h2 [overflow-wrap:break-word] hyphens-auto text-fg transition-transform duration-500 ease-eventia motion-safe:group-hover/expertise:translate-x-1.5 xl:text-[clamp(1.75rem,0.9rem+1.1vw,2.5rem)]">{{ $item['title'] }}</h3>
                    <p class="mt-4 max-w-text text-lead text-fg-muted">{{ $item['description'] }}</p>
                  </div>
                  <x-site.media-slot-frame :name="$item['slot']" :locale="$locale" ratio="landscape" tone="light" class="sm:col-start-2 xl:col-start-3" sizes="(min-width: 1280px) 25vw, (min-width: 640px) 70vw, 100vw" />
                </x-ui.reveal>
                <span aria-hidden="true" class="absolute -bottom-px left-0 h-px w-0 bg-accent transition-[width] duration-700 ease-eventia group-hover/expertise:w-full"></span>
              </li>
            @endforeach
          </ol>
        </section>
      @endforeach
    </x-ui.container>
  </section>

  {{-- Method --}}
  <x-ui.section tone="deep" aria-labelledby="methode-titre">
    <div class="site-grid gap-y-8">
      <x-ui.reveal class="col-span-full lg:col-span-7">
        <x-ui.eyebrow>{{ $t['method'] }}</x-ui.eyebrow>
        <h2 id="methode-titre" class="mt-5 text-h2 text-fg">@if ($locale === 'fr')Comprendre, constituer, préparer, <em class="text-accent italic">accompagner</em>.@else Understand, assemble, prepare, <em class="text-accent italic">support</em>.@endif</h2>
      </x-ui.reveal>
    </div>

    <x-ui.reveal-group as="ol" :stagger="0.14" class="mt-14 grid gap-12 sm:grid-cols-2 lg:mt-20 lg:grid-cols-4 lg:gap-8">
      @foreach ($content['method'] as $index => $step)
        <x-ui.reveal-item as="li" class="group/step flex flex-col">
          <span aria-hidden="true" class="font-display text-[clamp(3.5rem,2.5rem+3vw,5.5rem)] leading-none text-accent/35 transition-colors duration-500 group-hover/step:text-accent">{{ Web::pad($index + 1) }}</span>
          <span aria-hidden="true" class="mt-6 flex items-center gap-3 text-accent">
            <span class="size-2 shrink-0 rounded-full bg-accent"></span>
            <x-ui.reveal-item as="span" variant="draw" class="block h-px flex-1 origin-left bg-accent/40"></x-ui.reveal-item>
            @if ($index !== count($content['method']) - 1)<x-icon name="arrow-right" class="hidden size-4 lg:block" />@endif
          </span>
          <h3 class="mt-6 font-sans text-button tracking-[0.18em] text-fg uppercase">{{ $step['verb'] }}</h3>
          <p class="mt-3 max-w-xs text-body text-fg-muted">{{ $step['text'] }}</p>
        </x-ui.reveal-item>
      @endforeach
    </x-ui.reveal-group>
  </x-ui.section>

  <x-site.page-cta :locale="$locale" id="expertises-cta-titre" :eyebrow="$t['ctaEyebrow']" />
@endsection
