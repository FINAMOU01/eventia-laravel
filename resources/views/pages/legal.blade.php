@extends('layouts.app')

@php
    $t = [
        'fr' => [
            'eyebrow' => 'Informations',
            'title' => 'Mentions légales',
            'publisher' => 'Éditeur du site',
            'location' => 'Localisation',
            'contact' => 'Contact',
            'pending' => 'Les informations légales complémentaires seront publiées sur cette page dès qu’elles seront disponibles.',
        ],
        'en' => [
            'eyebrow' => 'Information',
            'title' => 'Legal notice',
            'publisher' => 'Site publisher',
            'location' => 'Location',
            'contact' => 'Contact',
            'pending' => 'Additional legal information will be published on this page as soon as it becomes available.',
        ],
    ][$locale];
    $contact = Site::CONTACT;
@endphp

{{-- Only information supplied by the client; legal registration details are added once provided. --}}
@section('content')
  <x-ui.section tone="light" aria-labelledby="mentions-titre">
    <div class="max-w-3xl py-section">
      <x-ui.eyebrow>{{ $t['eyebrow'] }}</x-ui.eyebrow>
      <h1 id="mentions-titre" class="mt-6 text-h2 text-fg">{{ $t['title'] }}</h1>

      <dl class="mt-12 grid gap-6 border-t border-line pt-8 text-body">
        <div>
          <dt class="text-eyebrow font-medium tracking-[0.14em] text-fg-muted uppercase">{{ $t['publisher'] }}</dt>
          <dd class="mt-1 text-fg">{{ Site::NAME }}</dd>
        </div>
        <div>
          <dt class="text-eyebrow font-medium tracking-[0.14em] text-fg-muted uppercase">{{ $t['location'] }}</dt>
          <dd class="mt-1 text-fg">{{ $contact['address'] }}</dd>
        </div>
        <div>
          <dt class="text-eyebrow font-medium tracking-[0.14em] text-fg-muted uppercase">{{ $t['contact'] }}</dt>
          <dd class="mt-1 flex flex-col text-fg">
            <a href="mailto:{{ $contact['email'] }}" class="hover:text-accent">{{ $contact['email'] }}</a>
            <a href="{{ $contact['phoneHref'] }}" class="hover:text-accent">{{ $contact['phoneDisplay'] }}</a>
          </dd>
        </div>
      </dl>

      <p class="mt-10 text-small text-fg-muted">{{ $t['pending'] }}</p>
    </div>
  </x-ui.section>
@endsection
