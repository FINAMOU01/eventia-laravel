@props(['as' => 'div', 'grid' => false])
<{{ $as }} {{ $attributes->class(['site-container', 'site-grid' => $grid]) }}>{{ $slot }}</{{ $as }}>
