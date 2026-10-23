@props(['type' => 'button', 'variant' => 'primary', 'size' => 'md', 'icon' => null])
<button type="{{ $type }}" {{ $attributes->except('class')->merge(['class' => Ui::buttonClasses($variant, $size, $attributes->get('class'))]) }}><x-ui.button-content :variant="$variant" :icon="$icon">{{ $slot }}</x-ui.button-content></button>
