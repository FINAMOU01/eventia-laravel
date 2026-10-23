<?php

namespace App\Support;

/** Port of lib/i18n.ts: French lives at the root (existing URLs), English under /en. */
final class I18n
{
    public const LOCALES = ['fr', 'en'];

    /** Remembers an explicit language choice so the browser-language redirect never overrides it. */
    public const LOCALE_STORAGE_KEY = 'eventia-locale';

    public static function localizeHref(string $href, string $locale): string
    {
        if ($locale === 'fr' || ! str_starts_with($href, '/')) {
            return $href;
        }
        if ($href === '/') {
            return '/en';
        }
        if (str_starts_with($href, '/#')) {
            return '/en'.substr($href, 1);
        }

        return '/en'.$href;
    }

    public static function localeFromPathname(string $pathname): string
    {
        return $pathname === '/en' || str_starts_with($pathname, '/en/') ? 'en' : 'fr';
    }

    /** Locale-free path, e.g. "/en/equipe" -> "/equipe". */
    public static function stripLocale(string $pathname): string
    {
        if ($pathname === '/en') {
            return '/';
        }

        return str_starts_with($pathname, '/en/') ? substr($pathname, 3) : $pathname;
    }

    /** @return array{0: string, 1: string} */
    public static function quoteMarks(string $locale): array
    {
        return $locale === 'fr' ? ["«\u{00A0}", "\u{00A0}»"] : ['“', '”'];
    }

    /**
     * French pages: open the English version when the visitor chose English with the FR / EN switcher, or, without any
     * saved choice, when the browser is in English. Crawlers are left on the French page they requested.
     */
    public static function browserLanguageRedirect(): string
    {
        $key = json_encode(self::LOCALE_STORAGE_KEY);

        return '(function(){try{var s=localStorage.getItem('.$key.');if(s==="fr")return;if(s!=="en"){var l=(navigator.languages&&navigator.languages[0])||navigator.language||"";if(!/^en\\b/i.test(l)||/bot|crawl|spider|slurp|lighthouse/i.test(navigator.userAgent))return;}var p=location.pathname;location.replace("/en"+(p==="/"?"":p)+location.search+location.hash);}catch(e){}})();';
    }
}
