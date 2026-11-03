@props(['items', 'layout' => 'list', 'locale', 'pendingLabel'])
{{--
  Official lists of the client (commitments, services, field contexts, event types…).
  Items are strings or ['title' => …, 'text' => …]. Layouts reuse existing site patterns:
    list  -> numbered rows (former Expertises page)
    grid  -> large values in a ruled grid (former recruitment criteria)
    steps -> numbered columns with a drawn hairline (former Method section)
  Null items show the "content to be provided" box.
--}}
@php
    $normalize = fn ($item) => is_array($item) ? ['title' => $item['title'] ?? null, 'text' => $item['text'] ?? null] : ['title' => $item, 'text' => null];
@endphp
@if ($items === null)
  <x-site.pending-content :locale="$locale" :label="$pendingLabel" />
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
        <span aria-hidden="true" class="mt-6 flex items-center gap-3 text-accent">
          <span class="size-2 shrink-0 rounded-full bg-accent"></span>
          <x-ui.reveal-item as="span" variant="draw" class="block h-px flex-1 origin-left bg-accent/40"></x-ui.reveal-item>
          @if ($index !== count($items) - 1)<x-icon name="arrow-right" class="hidden size-4 lg:block" />@endif
        </span>
        <h3 class="mt-6 font-sans text-button tracking-[0.18em] text-fg uppercase">{{ $item['title'] }}</h3>
        @if ($item['text'])<p class="mt-3 max-w-xs text-body text-fg-muted">{{ $item['text'] }}</p>@endif
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
