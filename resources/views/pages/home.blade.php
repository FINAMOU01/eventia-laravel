@extends('layouts.app')

@php
    $home = Content::get($locale)['home'];
    $t = [
        'fr' => ['why' => 'Les quatre engagements d’EVENTIA', 'ctaEyebrow' => 'Contact'],
        'en' => ['why' => 'EVENTIA’s four commitments', 'ctaEyebrow' => 'Contact'],
    ][$locale];
@endphp

@section('content')
  <x-site.hero :locale="$locale" />
  <x-site.expertise :locale="$locale" />

  {{-- Pourquoi EVENTIA ? — four commitments communicated by the client. --}}
  <x-ui.section id="pourquoi" tone="light" aria-labelledby="pourquoi-titre">
    <div class="site-grid gap-y-8">
      <x-ui.reveal class="col-span-full lg:col-span-7">
        <x-ui.eyebrow>EVENTIA SARL</x-ui.eyebrow>
        <h2 id="pourquoi-titre" class="mt-5 text-h2 text-fg">{{ $home['whyTitle'] }}</h2>
      </x-ui.reveal>
    </div>
    <div class="mt-14 lg:mt-20">
      <x-site.item-list :items="$home['why']" layout="steps" :locale="$locale" :pending-label="$t['why']" />
    </div>
  </x-ui.section>

  <x-site.contact :locale="$locale" />
@endsection
