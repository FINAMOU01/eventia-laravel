<?php

namespace App\Support;

/** View helpers shared by the Blade components (ports of lib/cn.ts and lib/motion.ts). */
final class Ui
{
    /** Port of lib/cn.ts: joins the truthy class names. */
    public static function cn(mixed ...$classes): string
    {
        return implode(' ', array_filter($classes, fn ($class) => is_string($class) && $class !== ''));
    }

    /** Port of components/ui/button.tsx buttonClasses(). */
    public static function buttonClasses(string $variant = 'primary', string $size = 'md', ?string $className = null): string
    {
        $base = 'group/button inline-flex items-center justify-center gap-2.5 font-sans font-medium whitespace-nowrap select-none transition-[color,background-color,border-color,box-shadow,translate] disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50';
        $variants = [
            'primary' => 'rounded-control bg-cta text-button text-cta-fg uppercase shadow-soft hover:bg-cta-hover hover:shadow-lift motion-safe:hover:-translate-y-0.5',
            'secondary' => 'rounded-control border border-accent text-button text-accent uppercase hover:bg-accent hover:text-canvas',
            'text' => 'min-h-11 text-small text-accent',
        ];
        $sizes = ['md' => 'min-h-12 px-7', 'lg' => 'min-h-14 px-9'];

        return self::cn($base, $variants[$variant], $variant !== 'text' ? $sizes[$size] : null, $className);
    }

    /**
     * Initial (hidden) inline style of a reveal variant, as Framer Motion renders it on the server.
     * Variants mirror lib/motion.ts: fade, up (16px), left, right and draw (hairline scaleX).
     */
    public static function revealStyle(string $variant): string
    {
        return match ($variant) {
            'fade' => 'opacity:0',
            'up' => 'opacity:0;transform:translateY(16px)',
            'left' => 'opacity:0;transform:translateX(-16px)',
            'right' => 'opacity:0;transform:translateX(16px)',
            'draw' => 'transform:scaleX(0)',
        };
    }
}
