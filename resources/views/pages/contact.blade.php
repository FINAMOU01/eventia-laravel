@extends('layouts.app')

@php
    $t = [
        'fr' => [
            'lead' => 'Décrivez-nous votre projet et notre équipe pourra mieux comprendre votre besoin.',
            'region' => 'Coordonnées et demande de devis',
            'details' => 'Coordonnées',
        ],
        'en' => [
            'lead' => 'Tell us about your project so our team can better understand your needs.',
            'region' => 'Contact details and quote request',
            'details' => 'Contact details',
        ],
    ][$locale];
@endphp

@section('content')
  {{-- Hero --}}
  <section aria-labelledby="contact-page-titre" class="tone-deep relative isolate overflow-hidden bg-ink text-fg">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(ellipse_70%_60%_at_85%_0%,rgb(4_58_164/0.55),transparent_70%),radial-gradient(ellipse_60%_50%_at_0%_100%,rgb(0_48_106/0.8),transparent_70%)]"></div>
    <span aria-hidden="true" class="pointer-events-none absolute -right-[0.06em] bottom-[-0.2em] -z-10 font-display text-[clamp(8rem,4rem+16vw,22rem)] leading-none text-white/[0.035] italic select-none">Contact</span>

    <x-ui.container class="pt-[calc(var(--header-height)+2.5rem)] pb-section lg:pt-[calc(var(--header-height)+3.5rem)]">
      <x-ui.reveal-group :stagger="0.14" :delay="0.1" class="site-grid items-end gap-y-8">
        <x-ui.reveal-item class="col-span-full lg:col-span-8">
          <x-ui.eyebrow>Contact</x-ui.eyebrow>
          <h1 id="contact-page-titre" class="mt-6 font-display text-[clamp(2.5rem,1.3rem+4.2vw,5.25rem)] leading-[1.05] tracking-[-0.015em] text-fg"><x-site.contact-title :locale="$locale" /></h1>
        </x-ui.reveal-item>
        <x-ui.reveal-item class="col-span-full lg:col-span-4 lg:pb-3">
          <p class="max-w-md border-l border-accent/60 pl-5 text-lead text-fg-muted">{{ $t['lead'] }}</p>
        </x-ui.reveal-item>
      </x-ui.reveal-group>
    </x-ui.container>
  </section>

  <x-ui.section tone="light" aria-label="{{ $t['region'] }}">
    <div class="lg:py-6">
      <x-site.contact-block :locale="$locale">
        <x-slot:aside>
          <x-ui.eyebrow>{{ $t['details'] }}</x-ui.eyebrow>
          <p class="mt-6 font-display text-h3 text-fg">@if ($locale === 'fr')Contactez directement l’équipe <em class="text-accent italic">EVENTIA</em>.@else Contact the <em class="text-accent italic">EVENTIA</em> team directly.@endif</p>
          <div class="mt-8">
            <x-site.contact-details :locale="$locale" />
          </div>
          <div class="mt-10">
            <x-site.contact-actions :locale="$locale" />
          </div>
        </x-slot:aside>
      </x-site.contact-block>
    </div>
  </x-ui.section>
@endsection
