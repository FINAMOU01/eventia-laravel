@props(['variant' => 'up', 'as' => 'div'])
<{{ $as }} data-reveal-item="{{ $variant }}" {{ $attributes->merge(['style' => Ui::revealStyle($variant)]) }}>{{ $slot }}</{{ $as }}>
