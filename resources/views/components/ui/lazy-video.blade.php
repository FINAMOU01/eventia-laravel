@props([
    'sources',
    'poster',
    'alt',
    // ambient: muted loop, loaded only when near the viewport, paused off-screen.
    // controls: poster + play button; the file is fetched only after the click.
    'behavior',
    'sizes',
    'preload' => false,
    'captions' => null,
    'posterClass' => null,
    // Position of the ambient play/pause button.
    'controlClass' => 'right-3 bottom-3',
    'locale' => 'fr',
])
@php
    $labels = [
        'fr' => ['pause' => 'Mettre la vidéo en pause', 'play' => 'Lire la vidéo', 'playNamed' => 'Lire la vidéo :'],
        'en' => ['pause' => 'Pause the video', 'play' => 'Play the video', 'playNamed' => 'Play the video:'],
    ][$locale];
    $isAmbient = $behavior === 'ambient';
@endphp
<div class="absolute inset-0" x-data="lazyVideo({ ambient: @js($isAmbient), types: @js(array_column($sources, 'type')) })">
  <x-ui.img :src="$poster" :alt="$isAmbient ? $alt : ''" :sizes="$sizes" :preload="$preload" class="{{ Ui::cn('object-cover', $posterClass) }}" />

  <template x-if="shouldLoad">
    <video
      class="absolute inset-0 size-full object-cover opacity-0 transition-opacity duration-700"
      :class="{ 'opacity-100': hasStarted }"
      playsinline
      @if ($isAmbient) loop muted aria-hidden="true" tabindex="-1" @else controls aria-label="{{ $alt }}" @endif
      preload="auto"
      x-init="start($el)"
      @playing="hasStarted = true; isPlaying = true"
      @pause="isPlaying = false"
    >
      @foreach ($sources as $source)
        <source src="{{ Media::url($source['src']) }}" type="{{ $source['type'] }}">
      @endforeach
      @if ($captions)
        <track kind="captions" src="{{ $captions }}" srclang="fr" label="Français" default>
      @endif
    </video>
  </template>

  @if ($isAmbient)
    <x-ui.icon-button x-show="canPlay" x-cloak :label="$labels['play']" x-bind:aria-label="isPlaying ? {{ \Illuminate\Support\Js::from($labels['pause']) }} : {{ \Illuminate\Support\Js::from($labels['play']) }}" variant="overlay" x-on:click="toggle()" class="{{ Ui::cn('absolute z-10', $controlClass) }}">
      <x-slot:icon><x-icon name="pause" x-show="isPlaying" x-cloak /><x-icon name="play" x-show="!isPlaying" /></x-slot:icon>
    </x-ui.icon-button>
  @else
    <div x-show="canPlay && !shouldLoad" x-cloak class="absolute inset-0 z-10 grid place-items-center">
      <x-ui.icon-button :label="$labels['playNamed'].' '.$alt" icon="play" variant="overlay" size="lg" x-on:click="toggle()" />
    </div>
  @endif
</div>
