@props(['locale', 'label', 'compact' => false])
@php
    $t = ['fr' => 'Contenu à fournir par le client', 'en' => 'Content to be provided by the client'][$locale];
@endphp
{{-- Visible stand-in for official wording not delivered yet; never replaced by invented text. --}}
<div data-pending-content {{ $attributes->class(['flex flex-col gap-2 rounded-card border border-dashed border-line', $compact ? 'px-5 py-4' : 'px-6 py-8 sm:px-8']) }}>
  <p class="inline-flex items-center gap-3 text-[0.625rem] font-medium tracking-[0.14em] text-fg-muted uppercase">
    <span aria-hidden="true" class="h-px w-6 bg-current"></span>{{ $t }}
  </p>
  <p @class(['font-display text-fg', 'text-small' => $compact, 'text-h3' => ! $compact])>{{ $label }}</p>
</div>
