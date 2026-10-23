@props(['locale'])
@php [$open, $close] = I18n::quoteMarks($locale); @endphp
{{-- Noura Njikam's quote, with "votre image" highlighted; shared with /equipe. --}}
@if ($locale === 'fr'){{ $open }}L’accueil est le premier reflet de <span class="text-accent">votre image</span>.{{ $close }}@else{{ $open }}Hospitality is the first reflection of <span class="text-accent">your image</span>.{{ $close }}@endif
