@props(['href', 'appearance' => 'inline', 'size' => null, 'icon' => null, 'target' => null, 'rel' => null])
@php
    // "inline" for links inside text; button variants for CTAs.
    $opensNewTab = $target === '_blank';
    $classes = $appearance === 'inline'
        ? Ui::cn('text-accent underline decoration-1 underline-offset-4 transition-colors hover:text-fg', $attributes->get('class'))
        : Ui::buttonClasses($appearance, $size ?? 'md', $attributes->get('class'));
    $newTab = $opensNewTab ? '<span class="sr-only"> (nouvel onglet)</span>' : '';
@endphp
<a href="{{ $href }}" {{ $attributes->except('class')->merge(['class' => $classes, 'target' => $target, 'rel' => $opensNewTab ? 'noopener noreferrer' : $rel]) }}>@if ($appearance === 'inline'){{ $slot }}@else<x-ui.button-content :variant="$appearance" :icon="$icon">{{ $slot }}</x-ui.button-content>@endif{!! $newTab !!}</a>
