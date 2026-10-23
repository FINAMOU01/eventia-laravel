@props(['locale'])
@php
    $label = ['fr' => 'Écrire sur WhatsApp (nouvel onglet)', 'en' => 'Message us on WhatsApp (new tab)'][$locale];
@endphp
{{-- Floating WhatsApp button, on every screen size. --}}
<a href="{{ Site::whatsappHref(Site::text($locale)['whatsappDefault']) }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $label }}" class="fixed right-4 bottom-[max(1rem,env(safe-area-inset-bottom))] z-30 inline-flex size-14 items-center justify-center rounded-full bg-whatsapp text-white shadow-lift transition-[translate] [--pulse-color:var(--color-whatsapp)] animate-cta-pulse hover:animate-none focus-visible:animate-none motion-safe:hover:-translate-y-0.5 md:right-6 md:bottom-6 lg:size-16"><x-ui.whatsapp-icon class="size-7 lg:size-8" /></a>
