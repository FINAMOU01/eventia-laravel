@props(['label', 'icon', 'variant' => 'outline', 'size' => 'md', 'type' => 'button'])
@php
    $variants = [
        'solid' => 'bg-cta text-cta-fg hover:bg-cta-hover',
        'outline' => 'border border-line text-fg hover:border-accent hover:text-accent',
        'ghost' => 'text-fg hover:bg-fg/5',
        'overlay' => 'bg-ink/55 text-white backdrop-blur-sm hover:bg-ink/75',
    ];
    $sizes = ['md' => 'size-11 [&_svg]:size-5', 'lg' => 'size-16 [&_svg]:size-6'];
@endphp
<button type="{{ $type }}" aria-label="{{ $label }}" {{ $attributes->class(['inline-flex shrink-0 items-center justify-center rounded-control transition-colors disabled:pointer-events-none disabled:opacity-50', $variants[$variant], $sizes[$size]]) }}><span aria-hidden="true" class="inline-flex">@if (is_string($icon))<x-icon :name="$icon" />@else{{ $icon }}@endif</span></button>
