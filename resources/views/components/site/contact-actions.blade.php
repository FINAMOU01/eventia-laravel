@props(['locale'])
@php
    $t = [
        'fr' => ['whatsapp' => 'Échanger sur WhatsApp', 'writeEmail' => 'Écrire un e-mail'],
        'en' => ['whatsapp' => 'Chat on WhatsApp', 'writeEmail' => 'Send an e-mail'],
    ][$locale];
    $text = Site::text($locale);
@endphp
<div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
  <x-ui.link :href="Site::whatsappHref($text['whatsappContact'])" target="_blank" appearance="secondary" size="lg" class="w-full sm:w-auto">
    <x-slot:icon><x-ui.whatsapp-icon /></x-slot:icon>
    {{ $t['whatsapp'] }}
  </x-ui.link>
  <x-ui.link href="mailto:{{ Site::CONTACT['email'] }}" appearance="text" class="justify-center sm:justify-start">{{ $t['writeEmail'] }}</x-ui.link>
</div>
