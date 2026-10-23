@props(['name', 'locale', 'ratio' => 'landscape', 'sizes' => null, 'preload' => false, 'tone' => 'deep', 'compact' => false, 'caption' => null])
{{-- Renders the real asset when declared in Media::slots(), otherwise a labelled placeholder. --}}
@php
    $mediaSlot = Media::slot($name, $locale);
    $media = $mediaSlot['media'] ?? null;
@endphp
<x-ui.media-frame :media="$media" :ratio="$ratio" :sizes="$sizes ?? '(min-width: 1024px) 50vw, 100vw'" :preload="$media ? $preload : false" :interactive="true" :caption="$caption" :locale="$locale" class="{{ $attributes->get('class') }}">
  @unless ($media)
    <x-site.media-placeholder :label="$mediaSlot['label']" :files="$mediaSlot['files']" :motif="$mediaSlot['motif']" :tone="$tone" :compact="$compact" :locale="$locale" />
  @endunless
</x-ui.media-frame>
