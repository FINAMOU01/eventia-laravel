@props(['label', 'files' => null, 'motif', 'tone' => 'deep', 'compact' => false, 'locale'])
@php
    $labels = [
        'fr' => ['aria' => 'Média à remplacer :', 'long' => 'Média à remplacer', 'short' => 'À remplacer'],
        'en' => ['aria' => 'Media to be replaced:', 'long' => 'Media to be replaced', 'short' => 'To be replaced'],
    ][$locale];
    $tones = [
        'deep' => [
            'base' => 'bg-linear-to-b from-ink via-deep to-primary text-white',
            'glow' => 'from-sky/40 via-sky/5 to-transparent',
            'line' => 'border-white/30',
            'soft' => 'border-white/15',
            'fill' => 'from-white/5 via-white/10 to-sky/35',
            'stroke' => 'text-white/20',
            'scrim' => 'from-ink/85',
            'muted' => 'text-white/80',
        ],
        'light' => [
            'base' => 'bg-linear-to-b from-surface to-surface-2 text-deep',
            'glow' => 'from-white via-white/40 to-transparent',
            'line' => 'border-primary/25',
            'soft' => 'border-primary/15',
            'fill' => 'from-white/40 via-white/70 to-sky/30',
            'stroke' => 'text-primary/15',
            'scrim' => 'from-surface-2',
            'muted' => 'text-muted',
        ],
    ];
    $t = $tones[$tone];
@endphp
{{-- Premium stand-in until real EVENTIA media is delivered; always labelled as such. --}}
<div role="img" aria-label="{{ $labels['aria'] }} {{ $label }}" class="{{ Ui::cn('absolute inset-0 overflow-hidden', $t['base']) }}">
  <div aria-hidden="true" class="absolute inset-0 transition-transform duration-700 ease-eventia motion-safe:group-hover/media:scale-103">
    <div class="{{ Ui::cn('absolute inset-0 bg-radial-[at_50%_62%]', $t['glow']) }}"></div>
    @if ($motif === 'arch')
      <div class="{{ Ui::cn('absolute bottom-[22%] left-1/2 h-[52%] w-[40%] -translate-x-1/2 rounded-t-full border bg-linear-to-b', $t['line'], $t['fill']) }}"></div>
      <div class="{{ Ui::cn('absolute bottom-[22%] left-1/2 h-[44%] w-[28%] -translate-x-1/2 rounded-t-full border', $t['soft']) }}"></div>
      <svg class="{{ Ui::cn('absolute inset-x-0 bottom-0 h-[22%] w-full', $t['stroke']) }}" viewBox="0 0 100 100" preserveAspectRatio="none" fill="none">
        @foreach ([-60, -20, 15, 50, 85, 120, 160] as $x)
          <line x1="50" y1="0" x2="{{ $x }}" y2="100" stroke="currentColor" vector-effect="non-scaling-stroke"></line>
        @endforeach
        @foreach ([14, 36, 66] as $y)
          <line x1="0" y1="{{ $y }}" x2="100" y2="{{ $y }}" stroke="currentColor" vector-effect="non-scaling-stroke"></line>
        @endforeach
      </svg>
    @elseif ($motif === 'spotlight')
      <div class="{{ Ui::cn('absolute inset-x-[18%] top-0 bottom-[24%] bg-linear-to-b opacity-70', $t['fill']) }}" style="clip-path:polygon(42% 0, 58% 0, 100% 100%, 0 100%)"></div>
      <div class="{{ Ui::cn('absolute bottom-[16%] left-1/2 h-[14%] w-[70%] -translate-x-1/2 rounded-[50%] border', $t['line']) }}"></div>
      <div class="{{ Ui::cn('absolute bottom-[19%] left-1/2 h-[8%] w-[46%] -translate-x-1/2 rounded-[50%] border', $t['soft']) }}"></div>
    @else
      <div class="{{ Ui::cn('absolute top-[24%] left-1/2 aspect-square w-[22%] -translate-x-1/2 rounded-full border', $t['line']) }}"></div>
      <div class="{{ Ui::cn('absolute bottom-0 left-1/2 h-[40%] w-[56%] -translate-x-1/2 rounded-t-full border border-b-0 bg-linear-to-b', $t['line'], $t['fill']) }}"></div>
    @endif
  </div>

  <div aria-hidden="true" class="{{ Ui::cn('absolute inset-x-0 bottom-0 h-2/5 bg-linear-to-t to-transparent', $t['scrim']) }}"></div>

  <div aria-hidden="true" class="absolute inset-3 sm:inset-4">
    <span class="{{ Ui::cn('absolute top-0 left-0 size-5 border-t border-l', $t['line']) }}"></span>
    <span class="{{ Ui::cn('absolute top-0 right-0 size-5 border-t border-r', $t['line']) }}"></span>
    <span class="{{ Ui::cn('absolute bottom-0 left-0 size-5 border-b border-l', $t['line']) }}"></span>
    <span class="{{ Ui::cn('absolute right-0 bottom-0 size-5 border-r border-b', $t['line']) }}"></span>
  </div>

  <div aria-hidden="true" class="{{ Ui::cn('absolute flex flex-col justify-between', $compact ? 'inset-5' : 'inset-6 sm:inset-8') }}">
    <div class="flex items-start justify-between gap-3">
      @unless ($compact)<p class="text-eyebrow font-medium uppercase">EVENTIA</p>@endunless
      <p class="{{ Ui::cn('rounded-control border px-2.5 py-1 text-[0.625rem] tracking-[0.14em] whitespace-nowrap uppercase', $compact ? 'ml-auto' : null, $t['line']) }}">{{ $compact ? $labels['short'] : $labels['long'] }}</p>
    </div>
    <div class="flex flex-col gap-1">
      <p class="{{ Ui::cn('font-display', $compact ? 'text-small' : 'text-h3') }}">{{ $label }}</p>
      @if (! $compact && $files)
        <p class="{{ Ui::cn('hidden text-small break-all sm:block', $t['muted']) }}">{{ implode(' · ', $files) }}</p>
      @endif
    </div>
  </div>
</div>
