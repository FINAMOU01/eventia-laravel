@props([
    'media' => null,
    'ratio' => 'landscape',
    'sizes' => '(min-width: 1024px) 50vw, 100vw',
    'preload' => false,
    'interactive' => false,
    'scrim' => false,
    'caption' => null,
    'locale' => 'fr',
])
@php
    $ratioClasses = [
        'portrait' => 'aspect-3/4',
        'landscape' => 'aspect-4/3',
        'square' => 'aspect-square',
        'wide' => 'aspect-video',
        'vertical' => 'aspect-9/16',
        'fill' => 'size-full',
    ];
    $zoomClasses = $interactive ? 'transition-transform duration-700 ease-eventia motion-safe:group-hover/media:scale-103' : null;
    $className = $attributes->get('class');
    $kind = $media['kind'] ?? null;
@endphp
@if ($caption)<figure class="{{ $className }}">@endif
<div class="{{ Ui::cn('group/media relative isolate overflow-hidden rounded-media bg-surface-2', $ratioClasses[$ratio], ! $caption ? $className : null) }}">
  @if ($kind === 'image')
    <x-ui.img :src="$media['src']" :alt="$media['alt']" :sizes="$sizes" :preload="$preload" class="{{ Ui::cn(($media['fit'] ?? 'cover') === 'contain' ? 'object-contain' : 'object-cover', ($media['anchor'] ?? null) === 'top' ? 'object-top' : null, $zoomClasses) }}" />
  @elseif ($kind === 'video')
    <x-ui.lazy-video :sources="$media['sources']" :poster="$media['poster']" :alt="$media['alt']" :behavior="$media['behavior'] ?? 'ambient'" :captions="$media['captions'] ?? null" :sizes="$sizes" :preload="$preload" :poster-class="$zoomClasses" :locale="$locale" />
  @elseif ($kind === 'embed')
    <iframe src="{{ $media['src'] }}" title="{{ $media['title'] }}" loading="lazy" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowfullscreen class="absolute inset-0 size-full bg-ink"></iframe>
  @endif
  @if ($scrim)
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-linear-to-t from-ink/70 via-ink/10 to-transparent"></div>
  @endif
  {{ $slot }}
</div>
@if ($caption)<figcaption class="mt-3 text-small text-fg-muted">{{ $caption }}</figcaption></figure>@endif
