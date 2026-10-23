@props(['src', 'alt' => '', 'sizes' => null, 'preload' => false])
{{-- Equivalent of next/image with `fill`: absolutely positioned, sized by its parent. --}}
<img alt="{{ $alt }}" @if ($preload) fetchpriority="high" @else loading="lazy" @endif decoding="async" data-nimg="fill" {{ $attributes }} style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent" @if ($sizes) sizes="{{ $sizes }}" @endif src="{{ Media::url($src) }}">
@if ($preload)
  @push('preload')
    <link rel="preload" as="image" href="{{ Media::url($src) }}" fetchpriority="high">
  @endpush
@endif
