@extends('layouts.app')

@php
    $content = Content::get($locale);
    $recruitment = $content['recruitment'];
    $t = [
        'fr' => ['eyebrow' => 'Recrutement', 'apply' => 'Postuler', 'profiles' => 'Profils recherchés', 'profilesPending' => 'Profils recherchés par EVENTIA'],
        'en' => ['eyebrow' => 'Careers', 'apply' => 'Apply', 'profiles' => 'Profiles we are looking for', 'profilesPending' => 'Profiles EVENTIA is looking for'],
    ][$locale];
    $heroImage = Media::slot('recrutement-equipe', $locale)['media'] ?? null;
@endphp

@section('content')
  {{-- Hero: same photo and treatment as before. --}}
  <section aria-labelledby="recrutement-page-titre" class="tone-deep relative isolate flex min-h-[min(88svh,48rem)] overflow-hidden bg-ink text-fg">
    @if (($heroImage['kind'] ?? null) === 'image')
      <x-ui.img :src="$heroImage['src']" :alt="$heroImage['alt']" :preload="true" sizes="100vw" class="-z-20 object-cover" />
    @endif
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-deep/30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-linear-to-t from-ink/95 via-ink/55 to-ink/60 lg:bg-linear-to-r lg:from-ink/90 lg:via-ink/55 lg:to-ink/20"></div>

    <x-ui.container class="flex flex-1 flex-col justify-end pt-[calc(var(--header-height)+3rem)] pb-section lg:pb-16">
      <x-ui.reveal-group :stagger="0.14" :delay="0.1" class="max-w-3xl">
        <x-ui.reveal-item>
          <x-ui.eyebrow>{{ $t['eyebrow'] }}</x-ui.eyebrow>
        </x-ui.reveal-item>
        <x-ui.reveal-item>
          <h1 id="recrutement-page-titre" class="mt-6 font-display text-[clamp(2.5rem,1.3rem+4.2vw,5.25rem)] leading-[1.05] tracking-[-0.015em] text-white">{{ $recruitment['title'] }}</h1>
        </x-ui.reveal-item>
        <x-ui.reveal-item class="mt-8">
          <x-ui.link href="#candidature" appearance="primary" size="lg" icon="arrow-right" class="w-full sm:w-auto">{{ $t['apply'] }}</x-ui.link>
        </x-ui.reveal-item>
      </x-ui.reveal-group>
    </x-ui.container>
  </section>

  {{-- Profiles sought, beside the existing recruitment portrait. --}}
  <x-ui.section tone="light" aria-labelledby="profils-titre">
    <div class="site-grid gap-y-12 lg:py-6">
      <div class="col-span-full lg:col-span-5">
        <x-ui.reveal>
          <x-ui.eyebrow>EVENTIA SARL</x-ui.eyebrow>
          <h2 id="profils-titre" class="mt-6 text-h2 text-fg">{{ $t['profiles'] }}</h2>
        </x-ui.reveal>
        <x-ui.reveal variant="fade" :delay="0.1" class="mt-10 max-w-sm max-lg:mx-auto lg:max-w-none">
          <x-site.media-slot-frame name="recrutement-portrait" :locale="$locale" ratio="portrait" tone="light" sizes="(min-width: 1024px) 38vw, 80vw" />
        </x-ui.reveal>
      </div>
      <div class="col-span-full lg:col-span-6 lg:col-start-7 lg:self-center">
        <x-site.item-list :items="$recruitment['profiles']" layout="list" :locale="$locale" :pending-label="$t['profilesPending']" />
      </div>
    </div>
  </x-ui.section>

  {{-- Application form. --}}
  <x-ui.section tone="surface" aria-label="{{ $t['apply'] }}">
    <div class="site-grid lg:py-6">
      <x-ui.reveal class="col-span-full lg:col-span-8 lg:col-start-3">
        <x-site.application-form :locale="$locale" />
      </x-ui.reveal>
    </div>
  </x-ui.section>
@endsection
