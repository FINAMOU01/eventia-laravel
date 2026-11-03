<?php

namespace App\Support;

/** Page URLs, titles, descriptions and the FR/EN alternates search engines use to pair both versions. */
final class Metadata
{
    public const SITE_URL = 'https://eventianj.com';

    public const PATHS = [
        'home' => '/',
        'image' => '/expertises/image-personal-branding',
        'hotesses' => '/expertises/hotesses',
        'events' => '/expertises/events',
        'agence' => '/agence',
        'recrutement' => '/recrutement',
        'contact' => '/contact',
        'legal' => '/mentions-legales',
    ];

    /** Former URLs (previous site structure), permanently redirected to their new home. */
    public const REDIRECTS = [
        '/expertises' => '/#expertise',
        '/realisations' => '/expertises/hotesses',
        '/equipe' => '/agence',
    ];

    // Descriptions reuse the official wording of each page (signature and title); nothing is added.
    private const PAGE_TEXT = [
        'fr' => [
            'image' => [
                'title' => 'EVENTIA IMAGE & PERSONAL BRANDING',
                'description' => 'Votre image. Votre influence. Votre empreinte. Faites de votre image une force.',
            ],
            'hotesses' => [
                'title' => 'EVENTIA HÔTESSES',
                'description' => 'L’élégance de l’accueil. La puissance de l’image. Le premier contact donne le ton.',
            ],
            'events' => [
                'title' => 'EVENTIA EVENTS',
                'description' => 'Le prestige en scène. Vos idées prennent vie. Chaque détail compte.',
            ],
            'agence' => [
                'title' => 'L’agence',
                'description' => 'EVENTIA SARL : une agence, trois expertises complémentaires.',
            ],
            'recrutement' => [
                'title' => 'Recrutement',
                'description' => 'Rejoignez les équipes EVENTIA.',
            ],
            'contact' => [
                'title' => 'Contact et demande de devis',
                'description' => 'Parlons de votre projet. EVENTIA SARL, Bastos, Yaoundé – Cameroun.',
            ],
            'legal' => ['title' => 'Mentions légales'],
        ],
        'en' => [
            'image' => [
                'title' => 'EVENTIA IMAGE & PERSONAL BRANDING',
                'description' => 'Your image. Your influence. Your mark. Make your image a strength.',
            ],
            'hotesses' => [
                'title' => 'EVENTIA HÔTESSES',
                'description' => 'The elegance of hospitality. The power of image. The first contact sets the tone.',
            ],
            'events' => [
                'title' => 'EVENTIA EVENTS',
                'description' => 'Prestige on stage. Your ideas come to life. Every detail matters.',
            ],
            'agence' => [
                'title' => 'The agency',
                'description' => 'EVENTIA SARL: one agency, three complementary areas of expertise.',
            ],
            'recrutement' => [
                'title' => 'Careers',
                'description' => 'Join the EVENTIA teams.',
            ],
            'contact' => [
                'title' => 'Contact and quote request',
                'description' => 'Let’s talk about your project. EVENTIA SARL, Bastos, Yaoundé – Cameroon.',
            ],
            'legal' => ['title' => 'Legal notice'],
        ],
    ];

    /**
     * @return array{title: string, description: string, canonical: string, alternates: array<string, string>, noindex: bool}
     */
    public static function page(string $page, string $locale): array
    {
        $site = Site::text($locale);
        $path = self::PATHS[$page];
        // The home page keeps the default title and description.
        $text = $page === 'home' ? [] : self::PAGE_TEXT[$locale][$page];

        return [
            'title' => isset($text['title']) ? $text['title'].' | '.Site::NAME : Site::NAME.' — '.$site['title'],
            'description' => $text['description'] ?? $site['description'],
            'canonical' => self::absolute(I18n::localizeHref($path, $locale)),
            'alternates' => [
                'fr' => self::absolute($path),
                'en' => self::absolute(I18n::localizeHref($path, 'en')),
                'x-default' => self::absolute($path),
            ],
            'noindex' => $page === 'legal',
        ];
    }

    // Same resolution as Next.js metadataBase: "/" maps to the bare origin.
    private static function absolute(string $path): string
    {
        return $path === '/' ? self::SITE_URL : self::SITE_URL.$path;
    }
}
