@props(['variant' => 'up', 'delay' => 0, 'as' => 'div'])
{{-- Standalone element revealed once when it enters the viewport (components/ui/reveal.tsx). --}}
<{{ $as }} data-reveal="{{ $variant }}" @if ($delay) data-reveal-delay="{{ $delay }}" @endif {{ $attributes->merge(['style' => Ui::revealStyle($variant)]) }}>{{ $slot }}</{{ $as }}>
