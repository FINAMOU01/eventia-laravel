@props(['src', 'alt' => '', 'sizes' => null, 'preload' => false])
{{-- Equivalent of next/image with `fill`: absolutely positioned, sized by its parent, responsive WebP copies. --}}
@php $image = Media::responsive($src, $sizes); @endphp
<img alt="{{ $alt }}" @if ($preload) fetchpriority="high" @else loading="lazy" @endif decoding="async" data-nimg="fill" {{ $attributes }} style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent" @if ($sizes) sizes="{{ $sizes }}" @endif @if ($image['srcset']) srcset="{{ $image['srcset'] }}" @endif src="{{ $image['src'] }}">
@if ($preload)
  @push('preload')
    <link rel="preload" as="image" @if ($image['srcset']) imagesrcset="{{ $image['srcset'] }}" @if ($sizes) imagesizes="{{ $sizes }}" @endif @else href="{{ $image['src'] }}" @endif fetchpriority="high">
  @endpush
@endif
