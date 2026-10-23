@props(['video', 'locale' => 'fr'])
@php
    $labels = [
        'fr' => ['play' => 'Lire la vidéo :', 'close' => 'Fermer la vidéo'],
        'en' => ['play' => 'Play the video:', 'close' => 'Close the video'],
    ][$locale];
    $isPortrait = $video['orientation'] === 'portrait';
    if ($video['kind'] === 'facebook') {
        // width/height only set the ratio: the Facebook player scales to the iframe and letterboxes the video.
        [$w, $h] = $isPortrait ? [450, 800] : [1280, 720];
        $embedSrc = 'https://www.facebook.com/plugins/video.php?href='.Web::encodeURIComponent($video['url'])."&show_text=false&width={$w}&height={$h}";
    }
@endphp
{{-- A poster button that opens the video in a modal dialog (Escape, backdrop click and close button dismiss it). --}}
<div class="contents" x-data="videoLightbox">
  <button type="button" aria-haspopup="dialog" aria-label="{{ $labels['play'] }} {{ $video['title'] }}" x-on:click="open()" {{ $attributes->class(['group/video relative block w-full overflow-hidden text-left']) }}>
    {{ $slot }}
    <span aria-hidden="true" class="absolute inset-0 grid place-items-center">
      <span class="grid size-16 place-items-center rounded-full bg-white/90 text-deep shadow-lift transition-transform duration-500 ease-eventia group-hover/video:scale-110 lg:size-20">
        <x-icon name="play" class="size-6 translate-x-0.5 fill-current lg:size-7" />
      </span>
    </span>
  </button>

  <dialog
    x-ref="dialog"
    aria-label="{{ $video['title'] }}"
    x-on:close="close()"
    x-on:cancel.prevent="close()"
    x-on:keydown.escape.prevent="close()"
    x-on:click="$event.target === $el && close()"
    class="fixed inset-0 m-0 h-dvh max-h-none w-full max-w-none items-center justify-center bg-ink/92 p-4 text-white backdrop:bg-transparent open:flex sm:p-10"
  >
    <template x-if="isOpen">
      <div class="contents">
        <x-ui.icon-button :label="$labels['close']" icon="x" variant="overlay" x-on:click="close()" class="absolute top-4 right-4 z-10 sm:top-6 sm:right-6" />
        <div @class([
            'overflow-hidden rounded-media bg-black shadow-lift',
            'aspect-9/16 h-[min(85dvh,calc((100vw-2rem)*16/9))]' => $isPortrait,
            'aspect-video w-[min(100%,calc(85dvh*16/9))]' => ! $isPortrait,
        ])>
          @if ($video['kind'] === 'file')
            {{-- The web encode has no audio track, so starting playback on open is silent. --}}
            <video src="{{ Media::url($video['src']) }}" controls autoplay playsinline class="size-full bg-black object-contain"></video>
          @else
            <iframe src="{{ $embedSrc }}" title="{{ $video['title'] }}" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowfullscreen class="size-full"></iframe>
          @endif
        </div>
      </div>
    </template>
  </dialog>
</div>
