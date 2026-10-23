@extends('layouts.app')

@php
    $content = Content::get($locale);
    $recruitment = $content['recruitment'];
    $applicationHref = $content['applicationHref'];
    $t = [
        'fr' => [
            'eyebrow' => 'Recrutement',
            'apply' => 'Postuler',
            'profiles' => 'Profils recherchés',
            'criteria' => 'Critères',
            'howTo' => 'Comment postuler',
            'sendTo' => 'Envoyez votre candidature à',
            'documents' => 'Documents demandés',
            'closingCta' => 'Postuler chez EVENTIA',
        ],
        'en' => [
            'eyebrow' => 'Careers',
            'apply' => 'Apply',
            'profiles' => 'Profiles we are looking for',
            'criteria' => 'Criteria',
            'howTo' => 'How to apply',
            'sendTo' => 'Send your application to',
            'documents' => 'Documents required',
            'closingCta' => 'Apply to EVENTIA',
        ],
    ][$locale];
    $slotImage = function (string $id) use ($locale) {
        $media = Media::slot($id, $locale)['media'] ?? null;

        return ($media['kind'] ?? null) === 'image' ? $media : null;
    };
    $heroImage = $slotImage('recrutement-equipe');
    $closingImage = $slotImage('equipe-groupe');
@endphp

@section('content')
  {{-- Hero --}}
  <section aria-labelledby="recrutement-page-titre" class="tone-deep relative isolate flex min-h-[min(88svh,48rem)] overflow-hidden bg-ink text-fg">
    @if ($heroImage)
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
          <h1 id="recrutement-page-titre" class="mt-6 font-display text-[clamp(2.5rem,1.3rem+4.2vw,5.25rem)] leading-[1.05] tracking-[-0.015em] text-white">@if ($locale === 'fr')Rejoignez l’équipe <em class="text-accent italic">EVENTIA</em>@else Join the <em class="text-accent italic">EVENTIA</em> team @endif</h1>
        </x-ui.reveal-item>
        <x-ui.reveal-item>
          <p class="mt-6 max-w-xl text-lead text-white/85">{{ $recruitment['pageIntro'] }}</p>
        </x-ui.reveal-item>
        <x-ui.reveal-item class="mt-8">
          <x-ui.link :href="$applicationHref" appearance="primary" size="lg" icon="arrow-right" class="w-full sm:w-auto">{{ $t['apply'] }}</x-ui.link>
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
          <h2 id="profils-titre" class="mt-6 font-display text-[clamp(2rem,1.4rem+2.2vw,3.25rem)] leading-[1.1] tracking-[-0.01em] text-fg">@if ($locale === 'fr')Des profils. Des personnalités. <em class="text-accent italic">Une même exigence.</em>@else Profiles. Personalities. <em class="text-accent italic">One shared standard.</em>@endif</h2>
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

  {{-- Closing --}}
  <section aria-labelledby="recrutement-fin-titre" class="tone-deep relative isolate flex min-h-[min(80svh,42rem)] items-center overflow-hidden bg-ink text-fg">
    @if ($closingImage)
      <x-ui.img :src="$closingImage['src']" alt="" sizes="100vw" class="-z-20 object-cover" />
    @endif
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-ink/70"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,transparent_20%,rgb(10_16_32/0.6)_100%)]"></div>

    <x-ui.container class="py-section">
      <x-ui.reveal class="mx-auto flex max-w-4xl flex-col items-center gap-10 text-center">
        <h2 id="recrutement-fin-titre" class="font-display text-[clamp(2.25rem,1.3rem+3.6vw,4.75rem)] leading-[1.08] tracking-[-0.01em] text-white">@if ($locale === 'fr')Votre image commence par les <em class="text-accent italic">personnes qui vous représentent</em>.@else Your image starts with the <em class="text-accent italic">people who represent you</em>.@endif</h2>
        <x-ui.link :href="$applicationHref" appearance="primary" size="lg" icon="arrow-right" class="w-full sm:w-auto">{{ $t['closingCta'] }}</x-ui.link>
      </x-ui.reveal>
    </x-ui.container>
  </section>
@endsection
