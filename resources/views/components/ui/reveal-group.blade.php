@props(['stagger' => 0.08, 'delay' => 0, 'as' => 'div'])
{{-- Staggers its RevealItem children when the group enters the viewport. --}}
<{{ $as }} data-reveal-group data-stagger="{{ $stagger }}" data-delay="{{ $delay }}" {{ $attributes }}>{{ $slot }}</{{ $as }}>
