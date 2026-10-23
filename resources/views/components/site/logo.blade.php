@props(['class' => null, 'preload' => false])
<img alt="Logo EVENTIA BY N.J." @unless ($preload) loading="lazy" @endunless width="2000" height="2000" decoding="async" data-nimg="1" @if ($preload) fetchpriority="high" @endif class="{{ Ui::cn('block h-12 w-auto object-contain lg:h-14', $class) }}" style="color:transparent" src="/media/brand/logo.png">
