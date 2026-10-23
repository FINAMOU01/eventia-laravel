<?php

namespace App\Support;

/** Port of lib/metadata.ts: per-page title/description plus the FR/EN alternates search engines use. */
final class Metadata
{
    public const SITE_URL = 'https://eventianj.com';

    public const PATHS = [
        'home' => '/',
        'expertises' => '/expertises',
        'realisations' => '/realisations',
        'equipe' => '/equipe',
        'recrutement' => '/recrutement',
        'contact' => '/contact',
        'legal' => '/mentions-legales',
    ];

    private const PAGE_TEXT = [
        'fr' => [
            'expertises' => [
                'title' => 'Expertises',
                'description' => 'Accueil & représentation, protocole, organisation événementielle, activation de marques, personnel sur mesure, wedding planning, décoration, restauration et gestion d’image : découvrez les expertises d’EVENTIA BY N.J.',
            ],
            'realisations' => [
                'title' => 'Réalisations',
                'description' => 'Des événements. Des visages. Des expériences. EVENTIA en action : Concours régional Littoral & Sud-Ouest 2026 et Finale nationale Miss Cameroun 2026.',
            ],
            'equipe' => [
                'title' => 'L’équipe',
                'description' => 'Une vision. Une équipe. Une ambition. Découvrez la vision portée par Noura Njikam et les équipes EVENTIA : préparées, briefées et engagées.',
            ],
            'recrutement' => [
                'title' => 'Recrutement',
                'description' => 'Rejoignez l’équipe EVENTIA : hôtesses événementielles, profils bilingues français / anglais. Critères, documents demandés et candidature.',
            ],
            'contact' => [
                'title' => 'Contact',
                'description' => 'Demandez un devis ou contactez l’équipe EVENTIA BY N.J pour votre événement à Yaoundé.',
            ],
            'legal' => ['title' => 'Mentions légales'],
        ],
        'en' => [
            'expertises' => [
                'title' => 'Expertise',
                'description' => 'Reception & representation, protocol, event organisation, brand activation, tailored staff, wedding planning, decoration, catering and image management: discover the expertise of EVENTIA BY N.J.',
            ],
            'realisations' => [
                'title' => 'Our work',
                'description' => 'Events. Faces. Experiences. EVENTIA in action: the Littoral & South-West 2026 regional pageant and the Miss Cameroun 2026 national final.',
            ],
            'equipe' => [
                'title' => 'The team',
                'description' => 'One vision. One team. One ambition. Discover the vision led by Noura Njikam and the EVENTIA teams: prepared, briefed and committed.',
            ],
            'recrutement' => [
                'title' => 'Careers',
                'description' => 'Join the EVENTIA team: event hostesses, bilingual French / English profiles. Criteria, required documents and application.',
            ],
            'contact' => [
                'title' => 'Contact',
                'description' => 'Request a quote or contact the EVENTIA BY N.J team for your event in Yaoundé.',
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
        // The home page keeps the layout's default title and description.
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
