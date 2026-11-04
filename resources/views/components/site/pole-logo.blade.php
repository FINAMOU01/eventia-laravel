@props(['pole', 'class' => 'size-16', 'fallbackClass' => 'text-eyebrow font-medium tracking-[0.18em] uppercase', 'lockupClass' => 'text-[22px]'])
@php
    $lockup = Media::poleLockup($pole['id']);
    $logo = $lockup ? null : Media::poleLogo($pole['id']);
@endphp
@if ($lockup)
  {{--
    Transparent lockup, like the EVENTIA SARL logo: official symbol and "Eventia" wordmark (cut from the client's artwork, not redrawn)
    with the division name in Poppins, royal blue #0069BC. Sized in em: the font-size (lockupClass) is the wordmark height.
  --}}
  <span role="img" aria-label="{{ $pole['name'] }}" class="{{ Ui::cn('inline-flex shrink-0 items-center gap-[0.5em] self-start leading-none', $lockupClass) }}" {{ $attributes->except('class') }}>
    <img src="{{ Media::url($lockup['symbol']) }}" alt="" class="block h-[2.1em] w-auto" decoding="async">
    <span class="flex flex-col items-center">
      <img src="{{ Media::url($lockup['wordmark']) }}" alt="" class="block h-[1em] w-auto" decoding="async">
      <span class="mt-[0.6em] flex flex-col items-center font-brand text-[0.39em] leading-[1.195] tracking-[0.087em] whitespace-nowrap text-[#0069BC]">
        @foreach ($lockup['lines'] as $line)<span class="block">{{ $line }}</span>@endforeach
      </span>
    </span>
  </span>
@elseif ($logo)
  {{-- Official division logo as a square tile on its own background (white for the blue logos, blue for Hôtesses), never recoloured. --}}
  <img src="{{ Media::url($logo) }}" alt="{{ $pole['name'] }}" width="480" height="480" class="{{ Ui::cn('block aspect-square shrink-0 rounded-media object-cover shadow-lg shadow-ink/25', $class) }}" decoding="async" {{ $attributes }}>
@else
  {{-- Until the logo is provided, the division name is shown in text. --}}
  <span class="{{ $fallbackClass }}" {{ $attributes }}>{{ $pole['name'] }}</span>
@endif
