@props(['class' => null, 'preload' => false])
@php $image = Media::responsive('/media/brand/logo.png', null, 2000); @endphp
<img alt="Logo EVENTIA BY N.J." @unless ($preload) loading="lazy" @endunless width="2000" height="2000" decoding="async" data-nimg="1" @if ($preload) fetchpriority="high" @endif class="{{ Ui::cn('block h-12 w-auto object-contain lg:h-14', $class) }}" style="color:transparent" @if ($image['srcset']) srcset="{{ $image['srcset'] }}" @endif src="{{ $image['src'] }}">
