@extends('layouts.app')

@php
    $content = Content::get($locale);
    $recruitment = $content['recruitment'];
    $applicationHref = Content::applicationHref($locale);
    $t = [
        'fr' => [
            'eyebrow' => 'Recrutement',
            'apply' => 'Postuler',
            'profiles' => 'Profils recherchés',
            'criteria' => 'Critères',
            'howTo' => 'Comment postuler',
            'sendTo' => 'Envoyez votre candidature à',
            'documents' => 'Documents demandés',
            'form' => 'Formulaire de candidature',
        ],
        'en' => [
            'eyebrow' => 'Careers',
            'apply' => 'Apply',
            'profiles' => 'Profiles we are looking for',
            'criteria' => 'Criteria',
            'howTo' => 'How to apply',
            'sendTo' => 'Send your application to',
            'documents' => 'Documents required',
            'form' => 'Application form',
        ],
    ][$locale];
    $heroImage = Media::slot('recrutement-equipe', $locale)['media'] ?? null;
    // Official title with its accent word, as on the previous page ("Rejoignez l’équipe EVENTIA").
    [$titleBefore, $titleAfter] = explode($recruitment['titleAccent'], $recruitment['title'], 2);
@endphp

@section('content')
  {{-- Hero --}}
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
          <h1 id="recrutement-page-titre" class="mt-6 font-display text-[clamp(2.5rem,1.3rem+4.2vw,5.25rem)] leading-[1.05] tracking-[-0.015em] text-white">{{ $titleBefore }}<em class="text-accent italic">{{ $recruitment['titleAccent'] }}</em>{{ $titleAfter }}</h1>
        </x-ui.reveal-item>
        <x-ui.reveal-item>
          <p class="mt-6 max-w-xl text-lead text-white/85">{{ $recruitment['pageIntro'] }}</p>
        </x-ui.reveal-item>
        <x-ui.reveal-item class="mt-8">
          <x-ui.link href="#candidature" appearance="primary" size="lg" icon="arrow-right" class="w-full sm:w-auto">{{ $t['apply'] }}</x-ui.link>
        </x-ui.reveal-item>
      </x-ui.reveal-group>
    </x-ui.container>
  </section>

  {{-- Profiles --}}
  <x-ui.section tone="light" aria-labelledby="profils-titre">
    <div class="site-grid gap-y-12 lg:py-6">
      <div class="col-span-full lg:col-span-5">
        <x-ui.reveal>
          <x-ui.eyebrow>{{ $t['profiles'] }}</x-ui.eyebrow>
          <h2 id="profils-titre" class="mt-6 font-display text-[clamp(2rem,1.4rem+2.2vw,3.25rem)] leading-[1.1] tracking-[-0.01em] text-fg">{{ $recruitment['profilesTitle'][0] }} <em class="text-accent italic">{{ $recruitment['profilesTitle'][1] }}</em></h2>
        </x-ui.reveal>
        <x-ui.reveal variant="fade" :delay="0.1" class="mt-10 max-w-sm max-lg:mx-auto lg:max-w-none">
          <x-site.media-slot-frame name="recrutement-portrait" :locale="$locale" ratio="portrait" tone="light" sizes="(min-width: 1024px) 38vw, 80vw" />
        </x-ui.reveal>
      </div>

      <x-ui.reveal-group as="ol" :stagger="0.1" class="col-span-full border-t border-line lg:col-span-6 lg:col-start-7 lg:self-center">
        @foreach ($recruitment['profiles'] as $index => $profile)
          <x-ui.reveal-item as="li" class="group/profile flex items-baseline gap-6 border-b border-line py-6 lg:py-8">
            <span aria-hidden="true" class="w-8 shrink-0 font-display text-h3 leading-none text-accent/40">{{ Web::pad($index + 1) }}</span>
            <span class="font-display text-[clamp(1.5rem,1.1rem+1.4vw,2.5rem)] leading-[1.15] text-fg transition-transform duration-500 ease-eventia motion-safe:group-hover/profile:translate-x-1.5">{{ $profile }}</span>
          </x-ui.reveal-item>
        @endforeach
      </x-ui.reveal-group>
    </div>
  </x-ui.section>

  {{-- Criteria --}}
  <x-ui.section tone="deep" aria-labelledby="criteres-titre">
    <x-ui.reveal>
      <x-ui.eyebrow>{{ $t['eyebrow'] }}</x-ui.eyebrow>
      <h2 id="criteres-titre" class="mt-5 text-h2 text-fg">{{ $t['criteria'] }}</h2>
    </x-ui.reveal>

    <x-ui.reveal-group as="ul" :stagger="0.08" class="mt-12 grid sm:grid-cols-2 lg:mt-16 lg:grid-cols-3">
      @foreach ($recruitment['criteria'] as $criterion)
        <x-ui.reveal-item as="li" class="flex min-h-36 flex-col justify-end gap-3 border-t border-line py-8 sm:pr-8 lg:min-h-44">
          @isset($criterion['label'])
            <span class="text-eyebrow font-medium tracking-[0.18em] text-accent uppercase">{{ $criterion['label'] }}</span>
          @endisset
          <span class="font-display text-[clamp(1.75rem,1.3rem+1.6vw,2.75rem)] leading-[1.1] text-fg">{{ $criterion['value'] }}</span>
        </x-ui.reveal-item>
      @endforeach
    </x-ui.reveal-group>
  </x-ui.section>

  {{-- How to apply --}}
  <x-ui.section tone="surface" aria-labelledby="postuler-titre">
    <div class="site-grid gap-y-12 lg:py-6">
      <x-ui.reveal class="col-span-full lg:col-span-6">
        <x-ui.eyebrow>{{ $t['howTo'] }}</x-ui.eyebrow>
        <h2 id="postuler-titre" class="mt-6 font-display text-[clamp(2rem,1.4rem+2.2vw,3.25rem)] leading-[1.12] tracking-[-0.01em] text-fg">{{ $t['sendTo'] }} <a href="{{ $applicationHref }}" class="mt-3 block text-[clamp(1.25rem,0.95rem+1.1vw,2rem)] text-accent italic underline decoration-1 underline-offset-[0.2em] transition-colors [overflow-wrap:anywhere] hover:text-fg">{{ Site::CONTACT['recruitmentEmail'] }}</a></h2>
        <div class="mt-10 flex flex-col gap-4">
          <x-ui.link :href="$applicationHref" appearance="primary" size="lg" icon="arrow-right" class="w-full sm:w-auto sm:self-start">{{ $t['apply'] }}</x-ui.link>
          <p class="text-small text-fg-muted">{{ $recruitment['note'] }}</p>
        </div>
      </x-ui.reveal>

      <div class="col-span-full lg:col-span-5 lg:col-start-8">
        <x-ui.reveal>
          <h3 class="text-eyebrow font-medium tracking-[0.18em] text-fg-muted uppercase">{{ $t['documents'] }}</h3>
        </x-ui.reveal>
        <x-ui.reveal-group as="ol" :stagger="0.08" class="mt-6 border-t border-line">
          @foreach ($recruitment['documents'] as $index => $document)
            <x-ui.reveal-item as="li" class="flex items-baseline gap-5 border-b border-line py-5">
              <span aria-hidden="true" class="w-6 shrink-0 text-eyebrow text-accent">{{ Web::pad($index + 1) }}</span>
              <span class="font-display text-h3 text-fg">{{ $document }}</span>
            </x-ui.reveal-item>
          @endforeach
        </x-ui.reveal-group>
      </div>
    </div>
  </x-ui.section>

  {{-- Application form (CV upload), requested in the EVENTIA SARL specification. --}}
  <x-ui.section tone="light" aria-label="{{ $t['form'] }}">
    <div class="site-grid lg:py-6">
      <x-ui.reveal class="col-span-full lg:col-span-8 lg:col-start-3">
        <x-site.application-form :locale="$locale" />
      </x-ui.reveal>
    </div>
  </x-ui.section>
@endsection
