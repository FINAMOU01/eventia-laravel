<?php

namespace App\Support;

/**
 * Port of lib/content.ts (French, client-approved wording) and lib/content-en.ts (faithful English translation).
 * Expertise titles/descriptions and method steps are the client's exact wording.
 */
final class Content
{
    private static array $cache = [];

    public static function get(string $locale): array
    {
        return self::$cache[$locale] ??= $locale === 'en' ? self::en() : self::fr();
    }

    private static function fr(): array
    {
        $documents = ['CV', 'Lettre de motivation', 'Photo portrait récente', 'Photo récente en pied, sans filtre'];

        return [
            'expertises' => [
                [
                    'id' => 'accueil-representation',
                    'number' => '01',
                    'title' => 'Accueil & représentation',
                    'tagline' => 'Créer un premier contact qui valorise votre image.',
                    'description' => "Premier contact, première impression\u{00A0}: valoriser votre image auprès de vos publics.",
                    'group' => 'coeur',
                    'slot' => 'expertise-accueil',
                ],
                [
                    'id' => 'protocole-accompagnement',
                    'number' => '02',
                    'title' => 'Protocole & accompagnement',
                    'tagline' => 'Accueillir et accompagner vos invités avec attention.',
                    'description' => 'Accueillir et accompagner vos invités avec attention et professionnalisme.',
                    'group' => 'coeur',
                    'slot' => 'expertise-protocole',
                ],
                [
                    'id' => 'organisation-evenementielle',
                    'number' => '03',
                    'title' => 'Organisation événementielle',
                    'tagline' => 'Concevoir et coordonner vos événements avec précision.',
                    'description' => 'Des équipes mobilisées pour contribuer au bon déroulement de vos événements.',
                    'group' => 'coeur',
                    'slot' => 'expertise-organisation',
                ],
                [
                    'id' => 'activation-produits-marques',
                    'number' => '04',
                    'title' => 'Activation de produits & de marques',
                    'tagline' => 'Créer l’interaction entre votre marque et votre public.',
                    'description' => 'Créer une interaction forte entre votre marque, vos produits et votre public.',
                    'group' => 'coeur',
                    'slot' => 'expertise-activation',
                ],
                [
                    'id' => 'personnel-sur-mesure',
                    'number' => '05',
                    'title' => 'Personnel événementiel sur mesure',
                    'tagline' => 'Des équipes adaptées aux besoins de chaque événement.',
                    'description' => 'Des équipes adaptées à vos besoins, à votre événement et à votre image.',
                    'group' => 'coeur',
                    'slot' => 'expertise-personnel',
                ],
                [
                    'id' => 'wedding-planning',
                    'number' => '06',
                    'title' => 'Wedding Planning',
                    'tagline' => 'Imaginer et orchestrer des célébrations qui vous ressemblent.',
                    'description' => 'Imaginer et orchestrer des célébrations qui vous ressemblent.',
                    'group' => 'elargie',
                    'slot' => 'expertise-wedding',
                ],
                [
                    'id' => 'decoration-evenementielle',
                    'number' => '07',
                    'title' => 'Décoration événementielle',
                    'tagline' => 'Créer des univers élégants, cohérents et mémorables.',
                    'description' => 'Créer des univers élégants, cohérents et mémorables.',
                    'group' => 'elargie',
                    'slot' => 'expertise-decoration',
                ],
                [
                    'id' => 'restauration-evenementielle',
                    'number' => '08',
                    'title' => 'Restauration événementielle',
                    'tagline' => 'Proposer une expérience culinaire adaptée à chaque occasion.',
                    'description' => 'Proposer une expérience culinaire adaptée à chaque occasion.',
                    'group' => 'elargie',
                    'slot' => 'expertise-restauration',
                ],
                [
                    'id' => 'gestion-image',
                    'number' => '09',
                    'title' => 'Gestion d’image',
                    'tagline' => 'Soigner votre présence, votre image et celle de votre événement.',
                    'description' => 'Soigner votre présence, votre image et celle de votre événement.',
                    'group' => 'elargie',
                    'slot' => 'expertise-image',
                ],
            ],
            'method' => [
                ['verb' => 'Comprendre', 'text' => 'Identifier les besoins de votre événement.'],
                ['verb' => 'Constituer', 'text' => 'Constituer une équipe adaptée à la mission.'],
                ['verb' => 'Préparer', 'text' => 'Briefing et préparation des équipes.'],
                ['verb' => 'Accompagner', 'text' => 'Être présent sur le terrain et contribuer à la qualité de l’expérience.'],
            ],
            'realisationsIntro' => [
                'title' => 'Des événements. Des visages. Des expériences.',
                'intro' => 'EVENTIA en action à travers des événements qui nous ont fait confiance.',
                'category' => 'Événements premium',
                'context' => 'Partenaire du COMICA, EVENTIA a accompagné ces étapes avec ses équipes, contribuant à l’accueil, à l’accompagnement et à l’image de l’événement.',
            ],
            'realisations' => [
                [
                    'id' => 'littoral-sud-ouest-2026',
                    'number' => '01',
                    'type' => 'Concours régional',
                    'title' => 'Littoral & Sud-Ouest 2026',
                    'slots' => ['realisation-littoral-main', 'realisation-littoral-detail'],
                ],
                [
                    'id' => 'miss-cameroun-2026',
                    'number' => '02',
                    'type' => 'Finale nationale',
                    'title' => 'Miss Cameroun 2026',
                    'slots' => ['realisation-miss-main', 'realisation-miss-side', 'realisation-miss-detail', 'realisation-miss-extra'],
                ],
            ],
            'eventiaSpot' => [
                'kind' => 'file',
                'src' => '/media/hero/hero.mp4',
                'orientation' => 'landscape',
                'title' => 'Le spot EVENTIA',
            ],
            'teamValues' => ['Élégance', 'Professionnalisme', 'Dynamisme', 'Engagement'],
            // Client-approved wording only.
            'team' => [
                'headline' => ['Une vision.', 'Une équipe.', 'Une ambition.'],
                'summary' => 'EVENTIA réunit des équipes préparées, briefées et engagées autour d’une même exigence : faire de chaque événement une expérience professionnelle, élégante et mémorable.',
                'quote' => 'L’accueil est le premier reflet de votre image.',
                'leader' => [
                    'name' => 'Noura Njikam',
                    'role' => 'PDG — EVENTIA',
                    'titles' => 'Miss Cameroun 2024 · Miss World Cameroun 2026',
                ],
                'agency' => 'EVENTIA est une agence spécialisée dans l’accueil, la représentation, l’animation et l’accompagnement événementiel. Elle met à disposition des équipes préparées, dynamiques et engagées pour accompagner entreprises, institutions et organisateurs.',
                'ambition' => 'Faire de chaque rencontre avec votre public une expérience qui vous ressemble.',
                'crew' => 'Autour de Noura Njikam, une équipe préparée, briefée et engagée, présente sur le terrain pour représenter votre image.',
            ],
            // Client-approved wording only; do not add criteria the client has not provided.
            'recruitment' => [
                'title' => 'Rejoignez l’équipe EVENTIA',
                'tagline' => 'Des profils. Des personnalités. Une même exigence.',
                'intro' => 'EVENTIA recherche des profils dynamiques, élégants et professionnels, capables de représenter une marque et d’offrir une expérience irréprochable au public.',
                'pageIntro' => 'Nous recherchons des personnalités capables d’incarner l’élégance, le professionnalisme et l’énergie EVENTIA.',
                'note' => 'Les candidatures sont étudiées selon les besoins et les missions.',
                'closing' => 'Votre image commence par les personnes qui vous représentent.',
                'previewProfiles' => [
                    'Hôtesses événementielles',
                    'Profils bilingues français / anglais',
                    'Profils dynamiques et souriants',
                    'Excellente présentation',
                    'Très bon relationnel',
                ],
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
                'documents' => $documents,
            ],
            // Pre-filled application e-mail listing the requested documents.
            'applicationHref' => Site::mailtoHref(
                'Candidature — EVENTIA',
                "Bonjour,\n\nJe souhaite rejoindre l’équipe EVENTIA. Vous trouverez ci-joint :\n"
                    .implode("\n", array_map(fn ($document) => "- {$document}", $documents))
                    ."\n\nCordialement,\n",
                Site::CONTACT['recruitmentEmail'],
            ),
        ];
    }

    private static function en(): array
    {
        $documents = ['CV', 'Cover letter', 'Recent portrait photo', 'Recent full-length photo, unfiltered'];

        return [
            'expertises' => [
                [
                    'id' => 'accueil-representation',
                    'number' => '01',
                    'title' => 'Reception & representation',
                    'tagline' => 'Creating a first contact that enhances your image.',
                    'description' => 'First contact, first impression: showcasing your image to your audiences.',
                    'group' => 'coeur',
                    'slot' => 'expertise-accueil',
                ],
                [
                    'id' => 'protocole-accompagnement',
                    'number' => '02',
                    'title' => 'Protocol & guest assistance',
                    'tagline' => 'Welcoming and accompanying your guests with care.',
                    'description' => 'Welcoming and accompanying your guests with attention and professionalism.',
                    'group' => 'coeur',
                    'slot' => 'expertise-protocole',
                ],
                [
                    'id' => 'organisation-evenementielle',
                    'number' => '03',
                    'title' => 'Event organisation',
                    'tagline' => 'Planning and coordinating your events with precision.',
                    'description' => 'Teams mobilised to help your events run smoothly.',
                    'group' => 'coeur',
                    'slot' => 'expertise-organisation',
                ],
                [
                    'id' => 'activation-produits-marques',
                    'number' => '04',
                    'title' => 'Product & brand activation',
                    'tagline' => 'Creating interaction between your brand and your audience.',
                    'description' => 'Creating strong interaction between your brand, your products and your audience.',
                    'group' => 'coeur',
                    'slot' => 'expertise-activation',
                ],
                [
                    'id' => 'personnel-sur-mesure',
                    'number' => '05',
                    'title' => 'Tailored event staff',
                    'tagline' => 'Teams adapted to the needs of every event.',
                    'description' => 'Teams adapted to your needs, your event and your image.',
                    'group' => 'coeur',
                    'slot' => 'expertise-personnel',
                ],
                [
                    'id' => 'wedding-planning',
                    'number' => '06',
                    'title' => 'Wedding Planning',
                    'tagline' => 'Imagining and orchestrating celebrations that reflect who you are.',
                    'description' => 'Imagining and orchestrating celebrations that reflect who you are.',
                    'group' => 'elargie',
                    'slot' => 'expertise-wedding',
                ],
                [
                    'id' => 'decoration-evenementielle',
                    'number' => '07',
                    'title' => 'Event decoration',
                    'tagline' => 'Creating elegant, coherent and memorable settings.',
                    'description' => 'Creating elegant, coherent and memorable settings.',
                    'group' => 'elargie',
                    'slot' => 'expertise-decoration',
                ],
                [
                    'id' => 'restauration-evenementielle',
                    'number' => '08',
                    'title' => 'Event catering',
                    'tagline' => 'Offering a culinary experience suited to every occasion.',
                    'description' => 'Offering a culinary experience suited to every occasion.',
                    'group' => 'elargie',
                    'slot' => 'expertise-restauration',
                ],
                [
                    'id' => 'gestion-image',
                    'number' => '09',
                    'title' => 'Image management',
                    'tagline' => 'Taking care of your presence, your image and that of your event.',
                    'description' => 'Taking care of your presence, your image and that of your event.',
                    'group' => 'elargie',
                    'slot' => 'expertise-image',
                ],
            ],
            'method' => [
                ['verb' => 'Understand', 'text' => 'Identify the needs of your event.'],
                ['verb' => 'Assemble', 'text' => 'Build a team suited to the assignment.'],
                ['verb' => 'Prepare', 'text' => 'Briefing and preparation of the teams.'],
                ['verb' => 'Support', 'text' => 'Be present on site and contribute to the quality of the experience.'],
            ],
            'realisationsIntro' => [
                'title' => 'Events. Faces. Experiences.',
                'intro' => 'EVENTIA in action at events that placed their trust in us.',
                'category' => 'Premium events',
                'context' => 'As a partner of COMICA, EVENTIA supported these stages with its teams, contributing to the welcome, the guest assistance and the image of the event.',
            ],
            'realisations' => [
                [
                    'id' => 'littoral-sud-ouest-2026',
                    'number' => '01',
                    'type' => 'Regional pageant',
                    'title' => 'Littoral & South-West 2026',
                    'slots' => ['realisation-littoral-main', 'realisation-littoral-detail'],
                ],
                [
                    'id' => 'miss-cameroun-2026',
                    'number' => '02',
                    'type' => 'National final',
                    'title' => 'Miss Cameroun 2026',
                    'slots' => ['realisation-miss-main', 'realisation-miss-side', 'realisation-miss-detail', 'realisation-miss-extra'],
                ],
            ],
            'eventiaSpot' => [
                'kind' => 'file',
                'src' => '/media/hero/hero.mp4',
                'orientation' => 'landscape',
                'title' => 'The EVENTIA film',
            ],
            'teamValues' => ['Elegance', 'Professionalism', 'Energy', 'Commitment'],
            'team' => [
                'headline' => ['One vision.', 'One team.', 'One ambition.'],
                'summary' => 'EVENTIA brings together prepared, briefed and committed teams around one shared standard: making every event a professional, elegant and memorable experience.',
                'quote' => 'Hospitality is the first reflection of your image.',
                'leader' => [
                    'name' => 'Noura Njikam',
                    'role' => 'CEO — EVENTIA',
                    'titles' => 'Miss Cameroun 2024 · Miss World Cameroun 2026',
                ],
                'agency' => 'EVENTIA is an agency specialising in hospitality, representation, event animation and event support. It provides prepared, dynamic and committed teams to support companies, institutions and organisers.',
                'ambition' => 'Making every encounter with your audience an experience that reflects who you are.',
                'crew' => 'Around Noura Njikam, a prepared, briefed and committed team, present on site to represent your image.',
            ],
            'recruitment' => [
                'title' => 'Join the EVENTIA team',
                'tagline' => 'Profiles. Personalities. One shared standard.',
                'intro' => 'EVENTIA is looking for dynamic, elegant and professional profiles, able to represent a brand and offer the public a flawless experience.',
                'pageIntro' => 'We are looking for personalities able to embody the elegance, professionalism and energy of EVENTIA.',
                'note' => 'Applications are reviewed according to needs and assignments.',
                'closing' => 'Your image starts with the people who represent you.',
                'previewProfiles' => [
                    'Event hostesses',
                    'Bilingual French / English profiles',
                    'Dynamic, smiling profiles',
                    'Excellent presentation',
                    'Very good interpersonal skills',
                ],
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
                'documents' => $documents,
            ],
            'applicationHref' => Site::mailtoHref(
                'Application — EVENTIA',
                "Hello,\n\nI would like to join the EVENTIA team. Please find attached:\n"
                    .implode("\n", array_map(fn ($document) => "- {$document}", $documents))
                    ."\n\nKind regards,\n",
                Site::CONTACT['recruitmentEmail'],
            ),
        ];
    }
}
