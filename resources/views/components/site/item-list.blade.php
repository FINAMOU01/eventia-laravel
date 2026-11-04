@props(['items', 'layout' => 'list', 'locale', 'pendingLabel'])
{{--
  Official lists of the client (commitments, services, field contexts, event types…).
  Items are strings or ['title' => …, 'text' => …]. Layouts reuse existing site patterns:
    list  -> numbered rows (former Expertises page)
    grid  -> large values in a ruled grid (former recruitment criteria)
    steps -> numbered columns with a drawn hairline (former Method section)
    bullets -> compact two-column list with gold dots (division services)
    inline -> one sentence separated by gold dots (field contexts, event types)
  Null items show the "content to be provided" box.
--}}
@php
    $normalize = fn ($item) => is_array($item) ? ['title' => $item['title'] ?? null, 'text' => $item['text'] ?? null] : ['title' => $item, 'text' => null];
@endphp
@if ($items === null)
  <x-site.pending-content :locale="$locale" :label="$pendingLabel" />
@elseif ($layout === 'bullets')
  {{-- Compact two-column list with a gold dot (division services). --}}
  <x-ui.reveal-group as="ul" :stagger="0.06" class="grid border-t border-line sm:grid-cols-2 sm:gap-x-10">
    @foreach (array_map($normalize, $items) as $item)
      <x-ui.reveal-item as="li" class="group/bullet flex gap-4 border-b border-line py-5 lg:py-6">
        <span aria-hidden="true" class="mt-[0.7em] size-1.5 shrink-0 rounded-full bg-accent transition-transform duration-500 group-hover/bullet:scale-150"></span>
        <span class="text-lead text-fg">{{ $item['title'] }}@if ($item['text'])<span class="mt-1 block text-body text-fg-muted">{{ $item['text'] }}</span>@endif</span>
      </x-ui.reveal-item>
    @endforeach
  </x-ui.reveal-group>
@elseif ($layout === 'inline')
  {{-- Short words: one centred sentence; longer phrases (event types): a 3-column grid, same dots and typeface. --}}
  @php $long = max(array_map(fn ($item) => mb_strlen($normalize($item)['title']), $items)) > 30; @endphp
  <x-ui.reveal-group as="ul" :stagger="0.07" @class([
      'font-display leading-[1.3] text-fg',
      'flex flex-wrap items-center justify-center gap-x-9 gap-y-4 text-[clamp(1.5rem,1.1rem+1.6vw,2.5rem)]' => ! $long,
      'grid gap-x-10 gap-y-6 text-[clamp(1.25rem,1.05rem+0.8vw,1.75rem)] sm:grid-cols-2 lg:grid-cols-3' => $long,
  ])>
    @foreach (array_map($normalize, $items) as $item)
      <x-ui.reveal-item as="li" @class(['flex gap-3.5', 'items-center' => ! $long, 'items-baseline' => $long])>
        <span aria-hidden="true" @class(['size-1.5 shrink-0 rounded-full bg-accent', 'translate-y-[0.15em]' => ! $long, '-translate-y-[0.2em]' => $long])></span>
        <span>{{ $item['title'] }}</span>
      </x-ui.reveal-item>
    @endforeach
  </x-ui.reveal-group>
@elseif ($layout === 'grid')
  <x-ui.reveal-group as="ul" :stagger="0.08" class="grid sm:grid-cols-2 lg:grid-cols-3">
    @foreach (array_map($normalize, $items) as $item)
      <x-ui.reveal-item as="li" class="flex min-h-36 flex-col justify-end gap-3 border-t border-line py-8 sm:pr-8 lg:min-h-44">
        <span class="font-display text-[clamp(1.5rem,1.2rem+1.2vw,2.25rem)] leading-[1.1] text-fg">{{ $item['title'] }}</span>
        @if ($item['text'])<span class="text-body text-fg-muted">{{ $item['text'] }}</span>@endif
      </x-ui.reveal-item>
    @endforeach
  </x-ui.reveal-group>
@elseif ($layout === 'steps')
  <x-ui.reveal-group as="ol" :stagger="0.14" class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
    @foreach (array_map($normalize, $items) as $index => $item)
      <x-ui.reveal-item as="li" class="group/step flex flex-col">
        <span aria-hidden="true" class="font-display text-[clamp(3.5rem,2.5rem+3vw,5.5rem)] leading-none text-accent/35 transition-colors duration-500 group-hover/step:text-accent">{{ Web::pad($index + 1) }}</span>
        <span aria-hidden="true" class="mt-6 flex h-4 items-center gap-3 text-accent">
          <span class="size-2 shrink-0 rounded-full bg-accent"></span>
          <x-ui.reveal-item as="span" variant="draw" class="block h-px flex-1 origin-left bg-accent/40"></x-ui.reveal-item>
          @if ($index !== count($items) - 1)<x-icon name="arrow-right" class="hidden size-4 lg:block" />@endif
        </span>
        @if ($item['text'])
          <h3 class="mt-6 font-sans text-button tracking-[0.18em] text-fg uppercase">{{ $item['title'] }}</h3>
          <p class="mt-3 max-w-xs text-body text-fg-muted">{{ $item['text'] }}</p>
        @else
          {{-- Plain sentence (e.g. commitments): kept readable instead of small caps. --}}
          <p class="mt-6 max-w-xs text-lead text-fg">{{ $item['title'] }}</p>
        @endif
      </x-ui.reveal-item>
    @endforeach
  </x-ui.reveal-group>
@else
  <ol class="border-t border-line">
    @foreach (array_map($normalize, $items) as $index => $item)
      <li class="group/expertise relative border-b border-line">
        <x-ui.reveal class="grid gap-4 py-8 sm:grid-cols-[auto_minmax(0,1fr)] sm:gap-x-10 lg:py-10">
          <span aria-hidden="true" class="font-display text-[clamp(2.5rem,2rem+2vw,4rem)] leading-[0.85] text-accent/20 transition-colors duration-700 ease-eventia group-hover/expertise:text-accent/60 sm:w-[2.2ch]">{{ Web::pad($index + 1) }}</span>
          <div class="min-w-0 sm:pt-1">
            <h3 class="font-display text-[clamp(1.5rem,1.2rem+1vw,2.25rem)] leading-[1.15] [overflow-wrap:break-word] hyphens-auto text-fg transition-transform duration-500 ease-eventia motion-safe:group-hover/expertise:translate-x-1.5">{{ $item['title'] }}</h3>
            @if ($item['text'])<p class="mt-3 max-w-text text-lead text-fg-muted">{{ $item['text'] }}</p>@endif
          </div>
        </x-ui.reveal>
        <span aria-hidden="true" class="absolute -bottom-px left-0 h-px w-0 bg-accent transition-[width] duration-700 ease-eventia group-hover/expertise:w-full"></span>
      </li>
    @endforeach
  </ol>
@endif
