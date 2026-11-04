@extends('layouts.app')

@php
    $recruitment = Content::get($locale)['recruitment'];
    [$titleBefore, $titleAfter] = explode($recruitment['titleAccent'], $recruitment['title'], 2);
    $t = [
        'fr' => ['eyebrow' => 'Recrutement · Candidature', 'back' => 'Retour au recrutement'],
        'en' => ['eyebrow' => 'Careers · Application', 'back' => 'Back to careers'],
    ][$locale];
@endphp

@section('content')
  {{-- Compact hero, same deep backdrop as the division pages. --}}
  <section aria-labelledby="candidature-page-titre" class="tone-deep relative isolate overflow-hidden bg-ink text-fg">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(ellipse_70%_60%_at_85%_0%,rgb(4_58_164/0.55),transparent_70%),radial-gradient(ellipse_60%_50%_at_0%_100%,rgb(0_48_106/0.8),transparent_70%)]"></div>
    <x-ui.container class="pt-[calc(var(--header-height)+2.5rem)] pb-section lg:pt-[calc(var(--header-height)+3.5rem)]">
      <x-ui.reveal-group :stagger="0.14" :delay="0.1" class="max-w-3xl">
        <x-ui.reveal-item>
          <a href="{{ I18n::localizeHref(Metadata::PATHS['recrutement'], $locale) }}" class="group/back inline-flex items-center gap-3 font-sans text-button tracking-[0.12em] text-fg-muted uppercase transition-colors hover:text-fg"><x-icon name="arrow-left" class="size-4 transition-transform duration-300 group-hover/back:-translate-x-1" />{{ $t['back'] }}</a>
        </x-ui.reveal-item>
        <x-ui.reveal-item class="mt-8">
          <x-ui.eyebrow>{{ $t['eyebrow'] }}</x-ui.eyebrow>
        </x-ui.reveal-item>
        <x-ui.reveal-item>
          <h1 id="candidature-page-titre" class="mt-6 font-display text-[clamp(2.5rem,1.3rem+4.2vw,5.25rem)] leading-[1.05] tracking-[-0.015em] text-white">{{ $titleBefore }}<em class="text-accent italic">{{ $recruitment['titleAccent'] }}</em>{{ $titleAfter }}</h1>
        </x-ui.reveal-item>
        <x-ui.reveal-item>
          <p class="mt-6 max-w-xl text-lead text-white/85">{{ $recruitment['note'] }}</p>
        </x-ui.reveal-item>
      </x-ui.reveal-group>
    </x-ui.container>
  </section>

  {{-- Application form (moved from the recruitment page). --}}
  <x-ui.section tone="surface" aria-label="{{ $locale === 'fr' ? 'Formulaire de candidature' : 'Application form' }}">
    <x-ui.reveal class="mx-auto max-w-3xl">
      <x-site.application-form :locale="$locale" />
    </x-ui.reveal>
  </x-ui.section>
@endsection
