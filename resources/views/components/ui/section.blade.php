@props(['tone' => 'light', 'spacing' => 'default', 'contained' => true])
@php
    $toneClass = ['light' => 'tone-light', 'surface' => 'tone-surface', 'deep' => 'tone-deep'][$tone];
    $spacingClass = ['default' => 'py-section', 'compact' => 'py-section-sm', 'none' => ''][$spacing];
@endphp
<section {{ $attributes->class([$toneClass, 'bg-canvas text-fg', $spacingClass]) }}>
  @if ($contained)
    <x-ui.container>{{ $slot }}</x-ui.container>
  @else
    {{ $slot }}
  @endif
</section>
