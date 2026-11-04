<?php

namespace App\Support;

/** Site-wide settings: identity, official contact details and navigation (EVENTIA SARL specification). */
final class Site
{
    public const NAME = 'EVENTIA SARL';

    public const PRIMARY_CTA_HREF = '/contact';

    // Official contact details from the client specification.
    public const CONTACT = [
        'email' => 'contact@eventianj.com',
        // Receives job applications and their CVs.
        'recruitmentEmail' => 'candidature@eventianj.com',
        'phoneDisplay' => '+237 692 23 73 87',
        'phoneHref' => 'tel:+237692237387',
        'phone2Display' => '+237 675 42 32 65',
        'phone2Href' => 'tel:+237675423265',
        'address' => 'Bastos, Yaoundé – Cameroun',
    ];

    public const WHATSAPP_NUMBER = '237692237387';

    /** Official social networks (LinkedIn removed at the client's request until the page exists). */
    public const SOCIALS = [
        ['id' => 'facebook', 'label' => ['fr' => 'Facebook', 'en' => 'Facebook'], 'url' => 'https://www.facebook.com/profile.php?id=61591566302411'],
        ['id' => 'instagram', 'label' => ['fr' => 'Instagram', 'en' => 'Instagram'], 'url' => 'https://www.instagram.com/eventia_ag/'],
    ];

    private const TEXT = [
        'fr' => [
            'title' => 'Nous créons ce qui vous distingue',
            'description' => 'Image, accueil et événementiel : trois expertises complémentaires pour valoriser votre identité, soigner l’expérience de vos publics et donner vie à vos projets.',
            'primaryCta' => 'Demander un devis',
            'whatsappDefault' => 'Bonjour, je souhaite obtenir des informations concernant les services EVENTIA.',
            'whatsappContact' => 'Bonjour, je souhaite échanger avec EVENTIA au sujet d’un projet.',
            // Previous signature, kept until the client provides the new EVENTIA SARL signature.
            'signature' => ['Accueillir', 'Représenter', 'Valoriser'],
            'backHome' => 'retour à l’accueil',
            'skipLink' => 'Aller au contenu',
            'nav' => [
                'accueil' => 'Accueil',
                'expertise' => 'Nos expertises',
                'agence' => 'L’agence',
                'recrutement' => 'Recrutement',
                'contact' => 'Contact',
            ],
        ],
        'en' => [
            'title' => 'We create what sets you apart',
            'description' => 'Image, hospitality and events: three complementary areas of expertise to enhance your identity, care for your audiences’ experience and bring your projects to life.',
            'primaryCta' => 'Request a quote',
            'whatsappDefault' => 'Hello, I would like some information about EVENTIA’s services.',
            'whatsappContact' => 'Hello, I would like to talk with EVENTIA about a project.',
            'signature' => ['Welcome', 'Represent', 'Elevate'],
            'backHome' => 'back to home',
            'skipLink' => 'Skip to content',
            'nav' => [
                'accueil' => 'Home',
                'expertise' => 'Our expertise',
                'agence' => 'The agency',
                'recrutement' => 'Careers',
                'contact' => 'Contact',
            ],
        ],
    ];

    private const NAVIGATION_ITEMS = [
        ['id' => 'accueil', 'href' => '/#accueil'],
        // "Nos expertises" opens the three divisions; the link itself leads to their presentation on the home page.
        ['id' => 'expertise', 'href' => '/#expertise', 'children' => true],
        ['id' => 'agence', 'href' => '/agence'],
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

    /**
     * @return list<array{id: string, href: string, label: string, children: list<array{id: string, href: string, number: string, label: string, signature: string}>}>
     */
    public static function navigation(string $locale): array
    {
        return array_map(fn (array $item) => [
            'id' => $item['id'],
            'href' => I18n::localizeHref($item['href'], $locale),
            'label' => self::TEXT[$locale]['nav'][$item['id']],
            'children' => ($item['children'] ?? false)
                ? array_map(fn (array $pole) => [
                    'id' => $pole['id'],
                    'href' => I18n::localizeHref(Metadata::PATHS[$pole['id']], $locale),
                    'number' => $pole['number'],
                    'label' => $pole['name'],
                    'signature' => $pole['signature'],
                ], Content::get($locale)['poles'])
                : [],
        ], self::NAVIGATION_ITEMS);
    }
}
