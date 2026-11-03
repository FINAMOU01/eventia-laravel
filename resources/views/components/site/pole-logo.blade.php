@props(['pole', 'class' => 'h-10 w-auto', 'fallbackClass' => 'text-eyebrow font-medium tracking-[0.18em] uppercase'])
@php $logo = Media::poleLogo($pole['id']); @endphp
{{-- Official division logo as delivered by the client; until it is provided, the division name is shown in text. --}}
@if ($logo)
  <img src="{{ Media::url($logo) }}" alt="{{ $pole['name'] }}" class="{{ Ui::cn('block object-contain', $class) }}" decoding="async" {{ $attributes }}>
@else
  <span class="{{ $fallbackClass }}" {{ $attributes }}>{{ $pole['name'] }}</span>
@endif
