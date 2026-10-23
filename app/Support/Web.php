<?php

namespace App\Support;

/** Small helpers that reproduce JavaScript behaviour the Next.js source relied on. */
final class Web
{
    /** Same output as JavaScript's encodeURIComponent(). */
    public static function encodeURIComponent(string $value): string
    {
        return strtr(rawurlencode($value), [
            '%21' => '!',
            '%2A' => '*',
            '%27' => "'",
            '%28' => '(',
            '%29' => ')',
        ]);
    }

    /** Two-digit index used by the numbered lists ("01", "02", …). */
    public static function pad(int $number): string
    {
        return str_pad((string) $number, 2, '0', STR_PAD_LEFT);
    }
}
