@props(['locale', 'basePath', 'class' => null])
@php
    $names = ['fr' => 'Français', 'en' => 'English'];
    $groupLabel = ['fr' => 'Langue', 'en' => 'Language'][$locale];
@endphp
{{-- FR / EN toggle pointing to the same page in the other language. --}}
<nav aria-label="{{ $groupLabel }}" class="{{ Ui::cn('flex items-center gap-1 text-button uppercase', $class) }}">
  @foreach (I18n::LOCALES as $index => $target)
    @if ($index > 0)
      <span aria-hidden="true" class="text-fg-muted/50">/</span>
    @endif
    {{-- Plain link: each language has its own layout, so a full page load is expected. --}}
    <a href="{{ I18n::localizeHref($basePath, $target) }}" hreflang="{{ $target }}" lang="{{ $target }}" @if ($target === $locale) aria-current="true" @endif data-remember-locale="{{ $target }}" @class(['px-1 py-2 transition-colors', 'text-fg' => $target === $locale, 'text-fg-muted hover:text-fg' => $target !== $locale])><span aria-hidden="true">{{ $target }}</span><span class="sr-only">{{ $names[$target] }}</span></a>
  @endforeach
</nav>
