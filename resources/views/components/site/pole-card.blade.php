@props(['pole', 'locale', 'label', 'sizes' => '(min-width: 768px) 50vw, 100vw'])
{{-- Division photo card: main photo, scrim, number, logo (or name), signature and "Discover"; hover zoom like the site's photo frames. --}}
@php $photo = Media::slot($pole['slot'], $locale)['media'] ?? null; @endphp
<a href="{{ I18n::localizeHref(Metadata::PATHS[$pole['id']], $locale) }}" {{ $attributes->class('group/pole relative isolate flex min-h-72 flex-col justify-end overflow-hidden rounded-media bg-deep p-6 lg:p-8') }}>
  @if (($photo['kind'] ?? null) === 'image')
    <x-ui.img :src="$photo['src']" :sizes="$sizes" class="-z-20 object-cover transition-transform duration-700 ease-eventia motion-safe:group-hover/pole:scale-105" />
  @endif
  <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-linear-to-t from-ink/95 via-ink/50 to-ink/10"></div>
  <span aria-hidden="true" class="font-display text-h3 leading-none text-accent">{{ $pole['number'] }}</span>
  <x-site.pole-logo :pole="$pole" class="mt-4 size-16 lg:size-20" fallback-class="mt-4 font-sans text-eyebrow font-medium tracking-[0.18em] text-white/80 uppercase" />
  <span class="mt-3 max-w-md font-display text-[clamp(1.375rem,1.1rem+1vw,2rem)] leading-[1.2] text-white italic transition-transform duration-500 ease-eventia motion-safe:group-hover/pole:translate-x-1.5">{{ $pole['signature'] }}</span>
  <span class="mt-5 inline-flex items-center gap-3 font-sans text-button tracking-[0.12em] text-white uppercase transition-colors group-hover/pole:text-accent">{{ $label }}<x-icon name="arrow-right" class="size-4 transition-transform duration-300 group-hover/pole:translate-x-1" /></span>
</a>
