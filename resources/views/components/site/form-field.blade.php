@props([
    'name',
    'label',
    'type' => 'text',
    'required' => false,
    'options' => [],
    'wide' => false,
    'hint' => null,
    'form',
    'accept' => null,
    'placeholder' => null,
])
@php
    $id = "{$form}-{$name}";
    $errorId = "{$id}-erreur";
    $hintId = $hint ? "{$id}-aide" : null;
    $inputClasses = 'w-full rounded-none border-0 border-b border-input bg-transparent px-0 py-3 text-body text-fg transition-[border-color,box-shadow] duration-300 placeholder:text-fg-muted/60 hover:border-fg/40 focus:border-accent focus:shadow-[0_1px_0_0_var(--color-accent)] focus-visible:outline-none aria-invalid:border-fg aria-invalid:shadow-[0_1px_0_0_var(--color-fg)]';
    $describedBy = fn () => "errors.{$name} ? '".trim("{$errorId} ".($hintId ?? ''))."' : ".($hintId ? "'{$hintId}'" : 'null');
    $common = new \Illuminate\View\ComponentAttributeBag(array_filter([
        'id' => $id,
        'name' => $name,
        'required' => $required ?: null,
        'aria-describedby' => $hintId,
        'placeholder' => $placeholder,
    ], fn ($value) => $value !== null));
@endphp
<div @class(['flex flex-col', 'sm:col-span-2' => $wide])>
  <label for="{{ $id }}" class="text-eyebrow font-medium tracking-[0.14em] text-fg-muted uppercase">{{ $label }}@if ($required)<span aria-hidden="true" class="text-accent"> *</span>@endif</label>

  @if ($type === 'textarea')
    <textarea {{ $common->merge($attributes->except('value')->getAttributes()) }} rows="5" :aria-invalid="errors.{{ $name }} ? 'true' : null" :aria-describedby="{{ $describedBy() }}" class="{{ Ui::cn($inputClasses, 'min-h-36 resize-y') }}">{{ old($name) }}</textarea>
  @elseif ($type === 'select')
    <select {{ $common->merge($attributes->except('value')->getAttributes()) }} :aria-invalid="errors.{{ $name }} ? 'true' : null" :aria-describedby="{{ $describedBy() }}" class="{{ Ui::cn($inputClasses, 'cursor-pointer appearance-none bg-[length:1rem] bg-[right_0.25rem_center] bg-no-repeat pr-8') }}" style="background-image:url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%235b616b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E&quot;)">
      <option value="" disabled @selected(old($name, $attributes->get('value')) === null)></option>
      @foreach ($options as $value => $optionLabel)
        <option value="{{ $value }}" @selected(old($name, $attributes->get('value')) === $value)>{{ $optionLabel }}</option>
      @endforeach
    </select>
  @elseif ($type === 'file')
    {{-- Native file input kept accessible; the visible part follows the site's field style. --}}
    <div class="relative mt-1">
      <input {{ $common->merge($attributes->except('value')->getAttributes()) }} type="file" @if ($accept) accept="{{ $accept }}" @endif x-on:change="fileName = $event.target.files[0]?.name || ''" :aria-invalid="errors.{{ $name }} ? 'true' : null" :aria-describedby="{{ $describedBy() }}" class="peer absolute inset-0 z-10 cursor-pointer opacity-0">
      <div class="flex items-center gap-3 border-b border-input py-3 text-body text-fg transition-[border-color,box-shadow] duration-300 peer-hover:border-fg/40 peer-focus-visible:border-accent peer-focus-visible:shadow-[0_1px_0_0_var(--color-accent)]" :class="errors.{{ $name }} && 'border-fg shadow-[0_1px_0_0_var(--color-fg)]'">
        <x-icon name="upload" class="size-4 shrink-0 text-accent" />
        <span class="truncate" :class="fileName ? 'text-fg' : 'text-fg-muted/60'" x-text="fileName || {{ \Illuminate\Support\Js::from($placeholder ?? '') }}">{{ $placeholder }}</span>
      </div>
    </div>
  @else
    <input {{ $common->merge($attributes->except('value')->getAttributes()) }} type="{{ $type }}" value="{{ old($name, $attributes->get('value')) }}" :aria-invalid="errors.{{ $name }} ? 'true' : null" :aria-describedby="{{ $describedBy() }}" class="{{ $inputClasses }}">
  @endif

  @if ($hint)
    <p id="{{ $hintId }}" class="mt-2 text-small text-fg-muted">{{ $hint }}</p>
  @endif
  <p id="{{ $errorId }}" x-show="errors.{{ $name }}" @if (! $errors->has($name)) x-cloak @endif class="mt-2 flex items-center gap-1.5 text-small text-fg">
    <x-icon name="alert-circle" class="size-4 shrink-0 text-accent" />
    <span x-text="errors.{{ $name }}">{{ $errors->first($name) }}</span>
  </p>
</div>
