@props(['locale'])
@php
    $content = Content::get($locale);
    $team = $content['team'];
    $t = [
        'fr' => ['eyebrow' => 'L’équipe', 'values' => 'Nos valeurs', 'cta' => 'Découvrir l’équipe'],
        'en' => ['eyebrow' => 'The team', 'values' => 'Our values', 'cta' => 'Meet the team'],
    ][$locale];
@endphp
{{-- Homepage preview; the full presentation lives on /equipe. --}}
<x-ui.section id="equipe" tone="light" aria-labelledby="equipe-titre">
  <div class="site-grid items-center gap-y-12 lg:py-6">
    <x-ui.reveal variant="fade" class="col-span-full lg:col-span-7">
      <x-site.media-slot-frame name="equipe-groupe" :locale="$locale" ratio="landscape" tone="light" sizes="(min-width: 1024px) 58vw, 100vw" />
    </x-ui.reveal>

    <x-ui.reveal :delay="0.1" class="col-span-full lg:col-span-5 lg:pl-6 xl:pl-10">
      <x-ui.eyebrow>{{ $t['eyebrow'] }}</x-ui.eyebrow>
      <h2 id="equipe-titre" class="mt-6 font-display text-[clamp(2.25rem,1.5rem+2.6vw,3.75rem)] leading-[1.08] tracking-[-0.01em] text-fg">@foreach ($team['headline'] as $index => $line)<span class="block">@if ($index === 1)<em class="text-accent italic">{{ $line }}</em>@else{{ $line }}@endif</span>@endforeach</h2>
      <p class="mt-6 text-lead text-fg-muted">{{ $team['summary'] }}</p>

      <ul aria-label="{{ $t['values'] }}" class="mt-8 flex flex-wrap items-center gap-x-3 gap-y-2 text-eyebrow font-medium tracking-[0.18em] text-fg uppercase">
        @foreach ($content['teamValues'] as $index => $value)
          <li class="flex items-center gap-3">@if ($index > 0)<span aria-hidden="true" class="size-1 rounded-full bg-accent"></span>@endif{{ $value }}</li>
        @endforeach
      </ul>

      <x-ui.link :href="I18n::localizeHref('/equipe', $locale)" appearance="primary" size="lg" icon="arrow-right" class="mt-10 w-full sm:w-auto">{{ $t['cta'] }}</x-ui.link>
    </x-ui.reveal>
  </div>

  <x-ui.reveal class="mx-auto mt-section max-w-4xl border-t border-line pt-section text-center">
    <figure>
      <blockquote>
        <p class="font-display text-h2 text-fg italic"><x-site.team-quote :locale="$locale" /></p>
      </blockquote>
      <figcaption class="mt-6 text-eyebrow font-medium tracking-[0.18em] text-fg-muted uppercase">{{ $team['leader']['name'] }} <span aria-hidden="true">·</span> {{ $team['leader']['role'] }}</figcaption>
    </figure>
  </x-ui.reveal>
</x-ui.section>
