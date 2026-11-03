@props(['pole', 'class' => 'size-16', 'fallbackClass' => 'text-eyebrow font-medium tracking-[0.18em] uppercase'])
@php $logo = Media::poleLogo($pole['id']); @endphp
{{-- Official division logo as a square tile on its own background (white for the blue logos, blue for Hôtesses), never recoloured; until it is provided, the division name is shown in text. --}}
@if ($logo)
  <img src="{{ Media::url($logo) }}" alt="{{ $pole['name'] }}" width="480" height="480" class="{{ Ui::cn('block aspect-square shrink-0 rounded-media object-cover shadow-lg shadow-ink/25', $class) }}" decoding="async" {{ $attributes }}>
@else
  <span class="{{ $fallbackClass }}" {{ $attributes }}>{{ $pole['name'] }}</span>
@endif
