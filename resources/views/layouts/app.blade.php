@php
    /** @var string $locale */
    /** @var string $page */
    $meta = Metadata::page($page, $locale);
    $pathname = '/'.ltrim(request()->path(), '/');
    $iconVersion = fn (string $file) => substr(md5_file(public_path($file)), 0, 13);
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" class="antialiased">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @if ($locale === 'fr')
    {{-- Static string (no user input), run before paint so English visitors never see the French page first. --}}
    <script>{!! I18n::browserLanguageRedirect() !!}</script>
  @endif
  @php $logo = Media::responsive('/media/brand/logo.png', null, 2000); @endphp
  <link rel="preload" as="image" imagesrcset="{{ $logo['srcset'] }}" fetchpriority="high">
  @stack('preload')
  <title>{{ $meta['title'] }}</title>
  <meta name="description" content="{{ $meta['description'] }}">
  @if ($meta['noindex'])
    <meta name="robots" content="noindex">
  @endif
  <link rel="canonical" href="{{ $meta['canonical'] }}">
  @foreach ($meta['alternates'] as $hreflang => $href)
    <link rel="alternate" hreflang="{{ $hreflang }}" href="{{ $href }}">
  @endforeach
  <link rel="icon" href="/favicon.ico?favicon.{{ $iconVersion('favicon.ico') }}.ico" sizes="48x48" type="image/x-icon">
  <link rel="icon" href="/icon.png?icon.{{ $iconVersion('icon.png') }}.png" sizes="512x512" type="image/png">
  <link rel="apple-touch-icon" href="/apple-icon.png?apple-icon.{{ $iconVersion('apple-icon.png') }}.png" sizes="180x180" type="image/png">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh">
  <a href="#contenu" class="sr-only rounded-control bg-cta px-5 py-3 text-button text-cta-fg uppercase focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50">{{ Site::text($locale)['skipLink'] }}</a>
  <x-site.header :locale="$locale" :pathname="$pathname" />
  <main id="contenu" tabindex="-1" @if ($page === 'legal') class="pt-(--header-height)" @endif>
    @yield('content')
  </main>
  <x-site.footer :locale="$locale" />
  <x-site.quick-actions :locale="$locale" />
</body>
</html>
