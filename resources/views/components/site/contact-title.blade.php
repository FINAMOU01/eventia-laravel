@props(['locale'])
@php [$before, $accent] = $locale === 'fr' ? ['Parlons de ', 'votre projet'] : ['Let’s talk about ', 'your project']; @endphp
{{ $before }}<em class="text-accent italic">{{ $accent }}</em>.
