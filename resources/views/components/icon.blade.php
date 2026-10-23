@props(['name'])
@php
    // Lucide icons used by the Next.js source (lucide-react), rendered with the same markup and class names.
    $icons = [
        'menu' => ['lucide-menu', '<path d="M4 5h16"></path><path d="M4 12h16"></path><path d="M4 19h16"></path>'],
        'x' => ['lucide-x', '<path d="M18 6 6 18"></path><path d="m6 6 12 12"></path>'],
        'arrow-right' => ['lucide-arrow-right', '<path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>'],
        'arrow-left' => ['lucide-arrow-left', '<path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path>'],
        'pause' => ['lucide-pause', '<rect x="14" y="3" width="5" height="18" rx="1"></rect><rect x="5" y="3" width="5" height="18" rx="1"></rect>'],
        'play' => ['lucide-play', '<path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path>'],
        'alert-circle' => ['lucide-circle-alert lucide-alert-circle', '<circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line>'],
        'check-circle-2' => ['lucide-circle-check lucide-check-circle-2', '<circle cx="12" cy="12" r="10"></circle><path d="m16 9-5.5 5.5L8 12"></path>'],
        'loader-2' => ['lucide-loader-circle lucide-loader-2', '<path d="M21 12a9 9 0 1 1-6.219-8.56"></path>'],
        'mail' => ['lucide-mail', '<path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect>'],
        'map-pin' => ['lucide-map-pin', '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle>'],
        'phone' => ['lucide-phone', '<path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>'],
    ];
    [$iconClass, $paths] = $icons[$name];
@endphp
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" {{ $attributes->class(['lucide '.$iconClass])->merge(['aria-hidden' => 'true']) }}>{!! $paths !!}</svg>
