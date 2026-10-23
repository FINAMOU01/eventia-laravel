@props(['locale'])
@php
    $content = Content::get($locale);
    $realisations = collect($content['realisations'])->keyBy('id');
    $slides = [];
    foreach (Media::REALISATIONS_SHOWCASE as $photo) {
        if ($realisation = $realisations->get($photo['realisationId'])) {
            $slides[] = ['src' => $photo['src'], 'alt' => $photo['alt'][$locale], 'realisation' => $realisation];
        }
    }
    $count = count($slides);
    $current = $slides[0] ?? null;
    $intro = $content['realisationsIntro'];
    $t = [
        'fr' => ['eyebrow' => 'Nos réalisations', 'roledescription' => 'carrousel', 'cta' => 'Voir nos réalisations'],
        'en' => ['eyebrow' => 'Our work', 'roledescription' => 'carousel', 'cta' => 'See our work'],
    ][$locale];
    $captions = array_map(fn ($slide) => ['id' => $slide['realisation']['id'], 'type' => $slide['realisation']['type'], 'title' => $slide['realisation']['title']], $slides);
@endphp
{{-- Homepage preview: full-bleed photo carousel; the full portfolio lives on /realisations. --}}
<section
  id="realisations"
  aria-labelledby="realisations-titre"
  aria-roledescription="{{ $t['roledescription'] }}"
  x-data="realisationsCarousel({ slides: @js($captions) })"
  x-on:focusin="hasFocus = true"
  x-on:focusout="if (!$el.contains($event.relatedTarget)) hasFocus = false"
  class="tone-deep relative isolate flex h-[min(90svh,54rem)] min-h-[40rem] overflow-hidden bg-ink text-fg"
>
  @foreach ($slides as $index => $slide)
    <div
      aria-hidden="{{ $index === 0 ? 'false' : 'true' }}"
      :aria-hidden="active === {{ $index }} ? 'false' : 'true'"
      @class(['absolute inset-0 -z-20 transition-opacity duration-[1400ms] ease-in-out', 'opacity-100' => $index === 0, 'opacity-0' => $index !== 0])
      :class="{ 'opacity-100': active === {{ $index }}, 'opacity-0': active !== {{ $index }} }"
    >
      <x-ui.img
        :src="$slide['src']"
        :alt="$slide['alt']"
        sizes="100vw"
        @class(['object-cover transition-transform duration-[9000ms] ease-out', 'scale-100' => $index === 0, 'scale-[1.06]' => $index !== 0])
        x-bind:class="{ 'scale-100': active === {{ $index }}, 'scale-[1.06]': active !== {{ $index }} }"
      />
    </div>
  @endforeach

  <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-deep/25"></div>
  <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-linear-to-t from-ink/95 via-ink/45 to-ink/55 lg:bg-linear-to-r lg:from-ink/90 lg:via-ink/50 lg:to-ink/10"></div>
  <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 bottom-0 -z-10 h-1/2 bg-linear-to-t from-ink/80 to-transparent"></div>

  <x-ui.container class="flex flex-1 flex-col justify-end pt-[calc(var(--header-height)+2rem)] pb-8 lg:pb-12">
    <div class="max-w-3xl">
      <h2 id="realisations-titre" class="inline-flex items-center gap-3 font-sans text-eyebrow font-medium text-accent uppercase"><span aria-hidden="true" class="h-px w-8 bg-current"></span>{{ $t['eyebrow'] }}</h2>

      <div aria-live="polite" x-bind:aria-live="isPlaying ? 'off' : 'polite'" class="mt-6 min-h-[8.5rem] sm:min-h-[9.5rem] lg:min-h-[11rem]">
        @if ($current)
          <p x-ref="swap">
            <span class="block font-sans text-eyebrow font-medium tracking-[0.18em] text-white/80 uppercase" x-text="slides[shown].type">{{ $current['realisation']['type'] }}</span><span class="sr-only"> : </span><span class="mt-3 block font-display text-[clamp(2.25rem,1.3rem+3.6vw,4.75rem)] leading-[1.04] tracking-[-0.01em] text-white" x-text="slides[shown].title">{{ $current['realisation']['title'] }}</span>
          </p>
        @endif
      </div>

      <p class="mt-6 max-w-xl text-lead text-white/85">{{ $intro['intro'] }}</p>
      <p class="mt-3 max-w-xl text-small text-white/65">{{ $intro['context'] }}</p>

      <x-ui.link :href="I18n::localizeHref('/realisations', $locale)" appearance="primary" size="lg" icon="arrow-right" class="mt-8 w-full sm:w-auto">{{ $t['cta'] }}</x-ui.link>
    </div>
  </x-ui.container>
</section>
