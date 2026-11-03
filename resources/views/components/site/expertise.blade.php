@props(['locale'])
@php
    $home = Content::get($locale)['home'];
    $agency = Content::get($locale)['agency'];
    // Same interactive section as before, now presenting the three divisions (photo, name, signature, description, page).
    $items = array_map(function (array $pole) use ($locale) {
        $media = Media::slot($pole['slot'], $locale)['media'] ?? null;

        return [
            ...$pole,
            'image' => ($media['kind'] ?? null) === 'image' ? $media['src'] : null,
            'href' => I18n::localizeHref(Metadata::PATHS[$pole['id']], $locale),
        ];
    }, Content::get($locale)['poles']);
    $count = count($items);
    $total = Web::pad($count);
    $current = $items[0];
    $t = [
        'fr' => [
            'cta' => 'Découvrir le pôle',
            'previous' => 'Pôle précédent',
            'next' => 'Pôle suivant',
            'counter' => ['Pôle ', ' sur '],
            'pending' => 'Descriptions officielles des trois pôles',
        ],
        'en' => [
            'cta' => 'Discover the division',
            'previous' => 'Previous division',
            'next' => 'Next division',
            'counter' => ['Division ', ' of '],
            'pending' => 'Official descriptions of the three divisions',
        ],
    ][$locale];
    $slides = array_map(fn ($item) => ['id' => $item['id'], 'number' => $item['number'], 'title' => $item['name'], 'tagline' => $item['signature'], 'description' => $item['description'], 'href' => $item['href']], $items);
    $missingDescriptions = collect($items)->contains(fn ($item) => $item['description'] === null);
@endphp
{{-- Homepage divisions: full-bleed photo driven by an interactive list (desktop) or a swipeable slider (mobile). --}}
<section
  id="expertise"
  aria-labelledby="expertise-titre"
  x-data="expertiseSlider({ items: @js($slides) })"
  x-on:pointerenter="$event.pointerType === 'mouse' && (isHovered = true)"
  x-on:pointerleave="$event.pointerType === 'mouse' && (isHovered = false)"
  x-on:focusin="hasFocus = $event.target.matches(':focus-visible')"
  x-on:focusout="if (!$el.contains($event.relatedTarget)) hasFocus = false"
  class="tone-deep relative isolate overflow-clip bg-ink text-fg"
>
  <x-ui.container class="grid gap-y-10 py-section lg:min-h-[min(50rem,100svh)] lg:grid-cols-12 lg:grid-rows-[auto_1fr] lg:gap-x-6 lg:py-24">
    <div class="lg:col-span-5 lg:row-start-1">
      <x-ui.eyebrow>{{ $home['polesEyebrow'] }}</x-ui.eyebrow>
      <h2 id="expertise-titre" class="mt-6 font-display text-[clamp(2.25rem,1.5rem+2.4vw,3.75rem)] leading-[1.08] tracking-[-0.01em] text-white">{{ $agency['title'] }}</h2>
      @if ($missingDescriptions)
        <x-site.pending-content :locale="$locale" :label="$t['pending']" :compact="true" class="mt-8 max-w-md" />
      @endif
    </div>

    {{-- Mobile: a swipeable photo slider; desktop: the photo becomes the full-bleed backdrop of the list. --}}
    <div class="lg:contents">
      <div
        x-on:touchstart="touchStart($event)"
        x-on:touchend="touchEnd($event)"
        class="relative mx-[calc(var(--gutter)*-1)] flex min-h-[34rem] flex-col justify-end overflow-hidden bg-deep sm:min-h-[38rem] lg:absolute lg:inset-0 lg:-z-10 lg:mx-0 lg:block lg:min-h-0"
      >
        @foreach ($items as $index => $item)
          @if ($item['image'])
            <div
              aria-hidden="true"
              @class(['absolute inset-0 transition-opacity duration-700 ease-eventia', 'opacity-100' => $index === 0, 'opacity-0' => $index !== 0])
              :class="{ 'opacity-100': active === {{ $index }}, 'opacity-0': active !== {{ $index }} }"
            >
              <x-ui.img
                :src="$item['image']"
                alt=""
                sizes="100vw"
                @class(['object-cover transition-transform duration-[2400ms] ease-eventia', 'scale-100' => $index === 0, 'scale-[1.07]' => $index !== 0])
                x-bind:class="{ 'scale-100': active === {{ $index }}, 'scale-[1.07]': active !== {{ $index }} }"
              />
            </div>
          @endif
        @endforeach
        <div aria-hidden="true" class="absolute inset-0 bg-linear-to-t from-ink via-ink/60 to-ink/15 lg:bg-linear-to-r lg:from-ink/95 lg:via-ink/70 lg:to-ink/50"></div>
        <div aria-hidden="true" class="absolute inset-0 hidden bg-linear-to-t from-ink/70 via-transparent to-ink/50 lg:block"></div>
        <div aria-hidden="true" class="absolute inset-0 bg-deep/15 mix-blend-multiply"></div>

        <div class="relative px-(--gutter) pt-28 pb-8 lg:hidden">
          <div aria-live="polite" x-bind:aria-live="isPlaying ? 'off' : 'polite'" class="min-h-[21rem] sm:min-h-[16.5rem]">
            <div x-ref="swap">
              <span aria-hidden="true" class="block font-display text-5xl leading-none text-accent italic" x-text="items[shown].number">{{ $current['number'] }}</span>
              <h3 class="mt-4 font-display text-[clamp(1.75rem,1.2rem+2.6vw,2.5rem)] leading-[1.1] text-white" x-text="items[shown].title">{{ $current['name'] }}</h3>
              <p class="mt-4 max-w-md font-display text-h3 text-white/85 italic" x-text="items[shown].tagline">{{ $current['signature'] }}</p>
              <p class="mt-3 max-w-md text-body text-white/75" x-show="items[shown].description" x-text="items[shown].description">{{ $current['description'] }}</p>
            </div>
          </div>

          <a href="{{ $current['href'] }}" x-bind:href="items[active].href" class="group/cta mt-8 flex items-center justify-between gap-4 border-t border-white/40 pt-4 font-sans text-button tracking-[0.12em] text-white uppercase transition-colors hover:text-accent">{{ $t['cta'] }}<x-icon name="arrow-right" class="size-5 transition-transform duration-300 group-hover/cta:translate-x-1" /></a>
        </div>
      </div>

      <div class="flex items-center justify-between pt-5 lg:hidden">
        <p class="font-display text-lg text-white/50"><span class="sr-only">{{ $t['counter'][0] }}</span><span class="text-accent" x-text="items[active].number">{{ $current['number'] }}</span><span aria-hidden="true">/</span><span class="sr-only">{{ $t['counter'][1] }}</span>{{ $total }}</p>
        <div class="flex items-center gap-2">
          <button type="button" aria-label="{{ $t['previous'] }}" x-on:click="goTo(-1)" class="inline-flex size-12 cursor-pointer items-center justify-center rounded-full text-white transition-colors hover:text-accent"><x-icon name="arrow-left" class="size-5" /></button>
          <button type="button" aria-label="{{ $t['next'] }}" x-on:click="goTo(1)" class="relative inline-flex size-12 cursor-pointer items-center justify-center rounded-full text-white transition-colors hover:text-accent">
            <svg aria-hidden="true" viewBox="0 0 48 48" class="absolute inset-0 size-full -rotate-90">
              <circle cx="24" cy="24" r="23" fill="none" stroke="currentColor" stroke-opacity="0.25"></circle>
              <circle x-ref="progress" x-show="isPlaying" cx="24" cy="24" r="23" fill="none" stroke="var(--color-sky)" stroke-width="1.5" pathLength="1" stroke-dasharray="0px 1px" style="display:none"></circle>
            </svg>
            <x-icon name="arrow-right" class="size-5" />
          </button>
        </div>
      </div>

      <ol class="hidden lg:col-span-6 lg:col-start-7 lg:row-span-2 lg:row-start-1 lg:block lg:self-center">
        @foreach ($items as $index => $item)
          @php
              $isActive = $index === 0;
              $descriptionId = "pole-{$item['id']}-texte";
          @endphp
          <li class="relative border-t border-white/15 last:border-b">
            <span aria-hidden="true" @class(['absolute -top-px left-0 h-px bg-accent transition-[width] duration-700 ease-eventia', 'w-full' => $isActive, 'w-0' => ! $isActive]) :class="{ 'w-full': active === {{ $index }}, 'w-0': active !== {{ $index }} }"></span>
            <button
              type="button"
              aria-expanded="{{ $isActive ? 'true' : 'false' }}"
              :aria-expanded="active === {{ $index }} ? 'true' : 'false'"
              aria-controls="{{ $descriptionId }}"
              x-on:click="active = {{ $index }}"
              x-on:focus="active = {{ $index }}"
              x-on:pointerenter="$event.pointerType === 'mouse' && (active = {{ $index }})"
              class="group/item flex w-full cursor-pointer items-baseline gap-5 py-5 text-left"
            >
              <span @class(['w-8 shrink-0 font-display text-base italic transition-colors duration-500', 'text-accent' => $isActive, 'text-white/35 group-hover/item:text-white/60' => ! $isActive]) :class="{ 'text-accent': active === {{ $index }}, 'text-white/35 group-hover/item:text-white/60': active !== {{ $index }} }">{{ $item['number'] }}</span>
              <span @class(['font-display text-[clamp(1.25rem,1.05rem+0.6vw,1.75rem)] leading-snug transition-[color,translate] duration-500 ease-eventia', 'translate-x-1.5 text-white' => $isActive, 'text-white/55 group-hover/item:text-white/85' => ! $isActive]) :class="{ 'translate-x-1.5 text-white': active === {{ $index }}, 'text-white/55 group-hover/item:text-white/85': active !== {{ $index }} }">{{ $item['name'] }}</span>
            </button>
            <div id="{{ $descriptionId }}" @class(['grid transition-[grid-template-rows,opacity] duration-500 ease-eventia', 'grid-rows-[1fr] opacity-100' => $isActive, 'grid-rows-[0fr] opacity-0' => ! $isActive]) :class="{ 'grid-rows-[1fr] opacity-100': active === {{ $index }}, 'grid-rows-[0fr] opacity-0': active !== {{ $index }} }">
              <div class="overflow-hidden pl-[3.25rem]">
                <div @class(['flex flex-col items-start gap-4 pb-6 transition-transform duration-700 ease-eventia', 'translate-y-0' => $isActive, '-translate-y-2' => ! $isActive]) :class="{ 'translate-y-0': active === {{ $index }}, '-translate-y-2': active !== {{ $index }} }">
                  @if (Media::poleLogo($item['id']))
                    <x-site.pole-logo :pole="$item" class="h-12 w-auto" />
                  @endif
                  <p class="font-display text-h3 text-white/90 italic">{{ $item['signature'] }}</p>
                  @if ($item['description'])
                    <p class="text-body text-white/80">{{ $item['description'] }}</p>
                  @endif
                  <a href="{{ $item['href'] }}" class="group/cta inline-flex items-center gap-3 font-sans text-button tracking-[0.12em] text-white uppercase transition-colors hover:text-accent">{{ $t['cta'] }}<x-icon name="arrow-right" class="size-4 transition-transform duration-300 group-hover/cta:translate-x-1" /></a>
                </div>
              </div>
            </div>
          </li>
        @endforeach
      </ol>
    </div>

    <div class="hidden flex-col gap-10 lg:col-span-5 lg:row-start-2 lg:flex lg:self-end">
      <p aria-hidden="true" class="hidden items-baseline gap-3 font-display text-white lg:flex">
        <span class="relative block h-[clamp(5rem,3rem+4vw,7.5rem)] w-[2.1ch] overflow-hidden text-[clamp(5rem,3rem+4vw,7.5rem)] leading-none italic">
          @foreach ($items as $index => $item)
            <span @class(['absolute inset-0 text-accent transition-[opacity,translate] duration-700 ease-eventia', 'translate-y-0 opacity-100' => $index === 0, 'translate-y-6 opacity-0' => $index !== 0]) :class="{ 'translate-y-0 opacity-100': active === {{ $index }}, 'translate-y-6 opacity-0': active !== {{ $index }} }">{{ $item['number'] }}</span>
          @endforeach
        </span>
        <span class="text-h3 text-white/40">/ {{ $total }}</span>
      </p>

      <x-ui.link :href="$current['href']" x-bind:href="items[active].href" appearance="primary" size="lg" icon="arrow-right" class="w-full sm:w-auto sm:self-start">{{ $t['cta'] }}</x-ui.link>
    </div>
  </x-ui.container>
</section>
