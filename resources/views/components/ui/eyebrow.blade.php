@props(['withRule' => true])
<p {{ $attributes->class(['inline-flex items-center gap-3 font-sans text-eyebrow font-medium text-accent uppercase']) }}>
  @if ($withRule)<span aria-hidden="true" class="h-px w-8 bg-current"></span>@endif{{ $slot }}
</p>
