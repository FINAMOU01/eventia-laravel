<?php

namespace App\Support;

/** Port of lib/site.ts. */
final class Site
{
    public const NAME = 'EVENTIA BY N.J';

    public const PRIMARY_CTA_HREF = '/contact';

    public const CONTACT = [
        'email' => 'contact@eventianj.com',
        'recruitmentEmail' => 'candidature@eventianj.com',
        'phoneDisplay' => '+237 6 56 69 72 72',
        'phoneHref' => 'tel:+237656697272',
        'phone2Display' => '+237 6 75 42 32 65',
        'phone2Href' => 'tel:+237675423265',
        'address' => 'Bastos, Yaoundé',
    ];

    public const WHATSAPP_NUMBER = '237656697272';

    private const TEXT = [
        'fr' => [
            'title' => 'L’excellence de l’accueil au service de votre image',
            'description' => 'Hôtesses, personnel événementiel, protocole, organisation événementielle et activation de produits & de marques à Yaoundé.',
            'primaryCta' => 'Demander un devis',
            // Neutral until the name of the person answering is confirmed.
            'whatsappDefault' => 'Bonjour, je souhaite obtenir des informations concernant les services EVENTIA.',
            'whatsappContact' => 'Bonjour, je souhaite échanger avec EVENTIA au sujet d’un événement.',
            'signature' => ['Accueillir', 'Représenter', 'Valoriser'],
            'backHome' => 'retour à l’accueil',
            'skipLink' => 'Aller au contenu',
            'nav' => [
                'accueil' => 'Accueil',
                'expertise' => 'Expertises',
                'realisations' => 'Réalisations',
                'equipe' => 'L’équipe',
                'recrutement' => 'Recrutement',
                'contact' => 'Contact',
            ],
        ],
        'en' => [
            'title' => 'Hospitality excellence in service of your image',
            'description' => 'Hostesses, event staff, protocol, event organisation and product & brand activation in Yaoundé.',
            'primaryCta' => 'Request a quote',
            'whatsappDefault' => 'Hello, I would like some information about EVENTIA’s services.',
            'whatsappContact' => 'Hello, I would like to talk with EVENTIA about an event.',
            'signature' => ['Welcome', 'Represent', 'Elevate'],
            'backHome' => 'back to home',
            'skipLink' => 'Skip to content',
            'nav' => [
                'accueil' => 'Home',
                'expertise' => 'Expertise',
                'realisations' => 'Our work',
                'equipe' => 'The team',
                'recrutement' => 'Careers',
                'contact' => 'Contact',
            ],
        ],
    ];

    private const NAVIGATION_ITEMS = [
        ['id' => 'accueil', 'href' => '/#accueil'],
        ['id' => 'expertise', 'href' => '/expertises'],
        ['id' => 'realisations', 'href' => '/realisations'],
        ['id' => 'equipe', 'href' => '/equipe'],
        ['id' => 'recrutement', 'href' => '/recrutement'],
        ['id' => 'contact', 'href' => '/contact'],
    ];

    public static function text(string $locale): array
    {
        return self::TEXT[$locale];
    }

    public static function whatsappHref(string $message): string
    {
        return 'https://wa.me/'.self::WHATSAPP_NUMBER.'?text='.Web::encodeURIComponent($message);
    }

    public static function mailtoHref(string $subject, string $body, ?string $to = null): string
    {
        $to ??= self::CONTACT['email'];

        return 'mailto:'.$to.'?subject='.Web::encodeURIComponent($subject).'&body='.Web::encodeURIComponent($body);
    }

    /** @return list<array{id: string, href: string, label: string}> */
    public static function navigation(string $locale): array
    {
        return array_map(fn (array $item) => [
            'id' => $item['id'],
            'href' => I18n::localizeHref($item['href'], $locale),
            'label' => self::TEXT[$locale]['nav'][$item['id']],
        ], self::NAVIGATION_ITEMS);
    }
}
