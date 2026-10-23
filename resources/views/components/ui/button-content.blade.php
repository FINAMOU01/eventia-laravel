@props(['variant' => 'primary', 'icon' => null])
{{-- Shared inner markup so Button and Link render identical CTAs (ButtonContent). --}}
<span @class(['link-underline' => $variant === 'text'])>{{ $slot }}</span>@if ($icon)<span aria-hidden="true" class="inline-flex shrink-0 transition-transform motion-safe:group-hover/button:translate-x-0.5 [&_svg]:size-4">@if (is_string($icon))<x-icon :name="$icon" />@else{{ $icon }}@endif</span>@endif
