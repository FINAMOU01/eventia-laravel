<?php

namespace App\Support;

/**
 * Official EVENTIA SARL content (client specification), French reference and English translation.
 *
 * A `null` value marks content the client has not provided yet: views then display a visible
 * "content to be provided" box instead of inventing text. Fill these values in to publish the content.
 */
final class Content
{
    private static array $cache = [];

    public static function get(string $locale): array
    {
        return self::$cache[$locale] ??= $locale === 'en' ? self::en() : self::fr();
    }

    /** Dotted keys of every value still awaiting client content, e.g. "poles.0.description". */
    public static function pending(string $locale = 'fr'): array
    {
        $pending = [];
        $walk = function (array $data, string $prefix) use (&$walk, &$pending) {
            foreach ($data as $key => $value) {
                $path = $prefix === '' ? (string) $key : "{$prefix}.{$key}";
                if ($value === null) {
                    $pending[] = $path;
                } elseif (is_array($value)) {
                    $walk($value, $path);
                }
            }
        };
        $walk(self::get($locale), '');

        return $pending;
    }

    public static function pole(string $id, string $locale): array
    {
        return collect(self::get($locale)['poles'])->firstWhere('id', $id);
    }

    /** Pre-filled application e-mail listing the requested documents (same wording as the previous site). */
    public static function applicationHref(string $locale): string
    {
        $documents = implode("\n", array_map(fn ($document) => "- {$document}", self::get($locale)['recruitment']['documents']));

        return $locale === 'en'
            ? Site::mailtoHref('Application — EVENTIA', "Hello,\n\nI would like to join the EVENTIA team. Please find attached:\n{$documents}\n\nKind regards,\n", Site::CONTACT['recruitmentEmail'])
            : Site::mailtoHref('Candidature — EVENTIA', "Bonjour,\n\nJe souhaite rejoindre l’équipe EVENTIA. Vous trouverez ci-joint :\n{$documents}\n\nCordialement,\n", Site::CONTACT['recruitmentEmail']);
    }

    private static function fr(): array
    {
        return [
            'home' => [
                'eyebrow' => 'EVENTIA SARL',
                'title' => 'Nous créons ce qui vous distingue.',
                'text' => 'Image, accueil et événementiel : trois expertises complémentaires pour valoriser votre identité, soigner l’expérience de vos publics et donner vie à vos projets.',
                'polesEyebrow' => 'Nos expertises',
                'whyTitle' => 'Pourquoi EVENTIA ?',
                // Four commitments communicated by the client.
                'why' => null,
            ],
            'poles' => [
                [
                    'id' => 'image',
                    'number' => '01',
                    'name' => 'EVENTIA IMAGE & PERSONAL BRANDING',
                    'signature' => 'Votre image. Votre influence. Votre empreinte.',
                    'title' => 'Faites de votre image une force.',
                    'description' => null,
                    'slot' => 'expertise-image',
                    'gallery' => [],
                    'sections' => [
                        ['id' => 'services', 'eyebrow' => 'Nos services', 'layout' => 'list', 'items' => null],
                        ['id' => 'approche', 'eyebrow' => 'Notre approche', 'layout' => 'steps', 'items' => null],
                    ],
                ],
                [
                    'id' => 'hotesses',
                    'number' => '02',
                    'name' => 'EVENTIA HÔTESSES',
                    'signature' => 'L’élégance de l’accueil. La puissance de l’image.',
                    'title' => 'Le premier contact donne le ton.',
                    'description' => null,
                    'slot' => 'expertise-accueil',
                    'gallery' => ['expertise-protocole', 'expertise-personnel', 'expertise-activation', 'recrutement-portrait'],
                    'sections' => [
                        ['id' => 'services', 'eyebrow' => 'Nos services', 'layout' => 'list', 'items' => null],
                        ['id' => 'terrains', 'eyebrow' => 'Terrains d’intervention', 'layout' => 'grid', 'items' => null],
                    ],
                    // Real assignments: Miss Cameroun 2026 (photos moved from the former Réalisations page).
                    'missions' => [
                        'eyebrow' => 'Nos missions',
                        'category' => 'Événements premium',
                        'context' => 'Partenaire du COMICA, EVENTIA a accompagné ces étapes avec ses équipes, contribuant à l’accueil, à l’accompagnement et à l’image de l’événement.',
                        'type' => 'Finale nationale',
                        'title' => 'Miss Cameroun 2026',
                        'slots' => ['realisation-miss-main', 'realisation-miss-side', 'realisation-miss-detail', 'realisation-miss-extra'],
                        'poster' => 'realisation-comica',
                    ],
                ],
                [
                    'id' => 'events',
                    'number' => '03',
                    'name' => 'EVENTIA EVENTS',
                    'signature' => 'Le prestige en scène.',
                    'title' => 'Vos idées prennent vie. Chaque détail compte.',
                    'description' => null,
                    'slot' => 'expertise-organisation',
                    'gallery' => ['expertise-decoration', 'expertise-wedding', 'expertise-restauration'],
                    'sections' => [
                        ['id' => 'evenements', 'eyebrow' => 'Types d’événements', 'layout' => 'grid', 'items' => null],
                        ['id' => 'expertises', 'eyebrow' => 'Nos expertises', 'layout' => 'list', 'items' => null],
                    ],
                ],
            ],
            'agency' => [
                'title' => 'Une agence, trois expertises complémentaires.',
                'presentation' => null,
                'mission' => null,
                'signature' => null,
                // Five commitments.
                'commitments' => null,
            ],
            // Kept at the client's request on the agency page (previously validated wording).
            'team' => [
                'quote' => 'L’accueil est le premier reflet de votre image.',
                'leader' => [
                    'name' => 'Noura Njikam',
                    'role' => 'PDG — EVENTIA',
                    'titles' => 'Miss Cameroun 2024 · Miss World Cameroun 2026',
                ],
                'agency' => 'EVENTIA est une agence spécialisée dans l’accueil, la représentation, l’animation et l’accompagnement événementiel. Elle met à disposition des équipes préparées, dynamiques et engagées pour accompagner entreprises, institutions et organisateurs.',
                'ambition' => 'Faire de chaque rencontre avec votre public une expérience qui vous ressemble.',
            ],
            'recruitment' => [
                // Official wording provided by the client for the recruitment page.
                'title' => 'Rejoignez l’équipe EVENTIA',
                'titleAccent' => 'EVENTIA',
                'pageIntro' => 'Nous recherchons des personnalités capables d’incarner l’élégance, le professionnalisme et l’énergie EVENTIA.',
                'profilesTitle' => ['Des profils. Des personnalités.', 'Une même exigence.'],
                'profiles' => [
                    'Hôtesses événementielles',
                    'Profils bilingues français / anglais',
                    'Personnes dynamiques et souriantes',
                    'Excellent relationnel',
                    'Bonne présentation',
                ],
                'criteria' => [
                    ['label' => 'Taille minimale', 'value' => '1,70 m'],
                    ['label' => 'Âge', 'value' => '19–30 ans'],
                    ['value' => 'Français / Anglais'],
                    ['value' => 'Dynamisme et ponctualité'],
                    ['value' => 'Bonne présentation'],
                    ['value' => 'Bon relationnel'],
                ],
                'note' => 'Les candidatures sont étudiées selon les besoins et les missions.',
                'documents' => ['CV', 'Lettre de motivation', 'Photo portrait récente', 'Photo récente en pied, sans filtre'],
                // Choice list for "Type de mission recherché"; a free-text field is shown until the client provides it.
                'missionTypes' => null,
            ],
            'contact' => [
                'title' => 'Parlons de votre projet.',
                // Choice list for "Type de prestation"; a free-text field is shown until the client provides it.
                'serviceTypes' => null,
            ],
            // DRAFT to be validated by the client (no retention period invented).
            'privacy' => [
                'validated' => false,
                'quote' => 'Les informations transmises via ce formulaire sont utilisées uniquement par EVENTIA SARL pour étudier votre demande et vous recontacter. Elles ne sont ni vendues ni transmises à des tiers. Pour consulter, modifier ou supprimer vos données, écrivez à contact@eventianj.com.',
                'application' => 'Les informations et le CV transmis via ce formulaire sont utilisés uniquement par EVENTIA SARL pour étudier votre candidature et vous recontacter. Ils ne sont ni vendus ni transmis à des tiers. Pour consulter, modifier ou supprimer vos données, écrivez à candidature@eventianj.com.',
            ],
        ];
    }

    // English translation of the official French content (to be validated by the client).
    private static function en(): array
    {
        return [
            'home' => [
                'eyebrow' => 'EVENTIA SARL',
                'title' => 'We create what sets you apart.',
                'text' => 'Image, hospitality and events: three complementary areas of expertise to enhance your identity, care for your audiences’ experience and bring your projects to life.',
                'polesEyebrow' => 'Our expertise',
                'whyTitle' => 'Why EVENTIA?',
                'why' => null,
            ],
            'poles' => [
                [
                    'id' => 'image',
                    'number' => '01',
                    'name' => 'EVENTIA IMAGE & PERSONAL BRANDING',
                    'signature' => 'Your image. Your influence. Your mark.',
                    'title' => 'Make your image a strength.',
                    'description' => null,
                    'slot' => 'expertise-image',
                    'gallery' => [],
                    'sections' => [
                        ['id' => 'services', 'eyebrow' => 'Our services', 'layout' => 'list', 'items' => null],
                        ['id' => 'approche', 'eyebrow' => 'Our approach', 'layout' => 'steps', 'items' => null],
                    ],
                ],
                [
                    'id' => 'hotesses',
                    'number' => '02',
                    'name' => 'EVENTIA HÔTESSES',
                    'signature' => 'The elegance of hospitality. The power of image.',
                    'title' => 'The first contact sets the tone.',
                    'description' => null,
                    'slot' => 'expertise-accueil',
                    'gallery' => ['expertise-protocole', 'expertise-personnel', 'expertise-activation', 'recrutement-portrait'],
                    'sections' => [
                        ['id' => 'services', 'eyebrow' => 'Our services', 'layout' => 'list', 'items' => null],
                        ['id' => 'terrains', 'eyebrow' => 'Where we operate', 'layout' => 'grid', 'items' => null],
                    ],
                    'missions' => [
                        'eyebrow' => 'Our assignments',
                        'category' => 'Premium events',
                        'context' => 'As a partner of COMICA, EVENTIA supported these stages with its teams, contributing to the welcome, the guest assistance and the image of the event.',
                        'type' => 'National final',
                        'title' => 'Miss Cameroun 2026',
                        'slots' => ['realisation-miss-main', 'realisation-miss-side', 'realisation-miss-detail', 'realisation-miss-extra'],
                        'poster' => 'realisation-comica',
                    ],
                ],
                [
                    'id' => 'events',
                    'number' => '03',
                    'name' => 'EVENTIA EVENTS',
                    'signature' => 'Prestige on stage.',
                    'title' => 'Your ideas come to life. Every detail matters.',
                    'description' => null,
                    'slot' => 'expertise-organisation',
                    'gallery' => ['expertise-decoration', 'expertise-wedding', 'expertise-restauration'],
                    'sections' => [
                        ['id' => 'evenements', 'eyebrow' => 'Types of events', 'layout' => 'grid', 'items' => null],
                        ['id' => 'expertises', 'eyebrow' => 'Our expertise', 'layout' => 'list', 'items' => null],
                    ],
                ],
            ],
            'agency' => [
                'title' => 'One agency, three complementary areas of expertise.',
                'presentation' => null,
                'mission' => null,
                'signature' => null,
                'commitments' => null,
            ],
            'team' => [
                'quote' => 'Hospitality is the first reflection of your image.',
                'leader' => [
                    'name' => 'Noura Njikam',
                    'role' => 'CEO — EVENTIA',
                    'titles' => 'Miss Cameroun 2024 · Miss World Cameroun 2026',
                ],
                'agency' => 'EVENTIA is an agency specialising in hospitality, representation, event animation and event support. It provides prepared, dynamic and committed teams to support companies, institutions and organisers.',
                'ambition' => 'Making every encounter with your audience an experience that reflects who you are.',
            ],
            'recruitment' => [
                'title' => 'Join the EVENTIA team',
                'titleAccent' => 'EVENTIA',
                'pageIntro' => 'We are looking for personalities able to embody the elegance, professionalism and energy of EVENTIA.',
                'profilesTitle' => ['Profiles. Personalities.', 'One shared standard.'],
                'profiles' => [
                    'Event hostesses',
                    'Bilingual French / English profiles',
                    'Dynamic, smiling people',
                    'Excellent interpersonal skills',
                    'Good presentation',
                ],
                'criteria' => [
                    ['label' => 'Minimum height', 'value' => '1.70 m'],
                    ['label' => 'Age', 'value' => '19–30 years'],
                    ['value' => 'French / English'],
                    ['value' => 'Energy and punctuality'],
                    ['value' => 'Good presentation'],
                    ['value' => 'Good interpersonal skills'],
                ],
                'note' => 'Applications are reviewed according to needs and assignments.',
                'documents' => ['CV', 'Cover letter', 'Recent portrait photo', 'Recent full-length photo, unfiltered'],
                'missionTypes' => null,
            ],
            'contact' => [
                'title' => 'Let’s talk about your project.',
                'serviceTypes' => null,
            ],
            'privacy' => [
                'validated' => false,
                'quote' => 'The information sent through this form is used only by EVENTIA SARL to review your request and get back to you. It is neither sold nor shared with third parties. To access, correct or delete your data, write to contact@eventianj.com.',
                'application' => 'The information and CV sent through this form are used only by EVENTIA SARL to review your application and get back to you. They are neither sold nor shared with third parties. To access, correct or delete your data, write to candidature@eventianj.com.',
            ],
        ];
    }
}
