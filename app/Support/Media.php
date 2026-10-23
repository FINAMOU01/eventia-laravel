<?php

namespace App\Support;

/** Port of lib/media.ts: media manifest, hero video and homepage carousel. */
final class Media
{
    public const HERO_VIDEO = [
        // Web encode of the client spot (master kept outside the project: eventia-assets/hero/Spot eventia.MOV).
        // H.264 1080p 30 fps, no audio, faststart.
        'sources' => [['src' => '/media/hero/hero.mp4', 'type' => 'video/mp4']],
        'poster' => '/media/hero/hero.jpg',
        'alt' => [
            'fr' => 'Hôtesses EVENTIA en uniforme bleu lors d’un événement',
            'en' => 'EVENTIA hostesses in blue uniforms at an event',
        ],
    ];

    private static function expertiseImage(string $label, string $file, string $alt): array
    {
        $src = "/media/expertise/{$file}";

        return ['label' => $label, 'files' => [$src], 'motif' => 'spotlight', 'media' => ['kind' => 'image', 'src' => $src, 'alt' => $alt]];
    }

    /**
     * Media manifest. To publish a real asset, drop the file in /public/media/... and set `media`.
     * A slot without `media` renders the labelled placeholder.
     */
    public static function slots(): array
    {
        return [
            'expertise-accueil' => self::expertiseImage(
                'Accueil & représentation',
                'acceuil&presentation.jpg',
                'Hôtesse EVENTIA en robe bleue accueillant un invité à l’entrée d’une réception',
            ),
            'expertise-protocole' => self::expertiseImage(
                'Protocole & accompagnement',
                'orientation&accompagne.jpg',
                'Hôtesse EVENTIA accompagnant un invité à travers une salle de réception',
            ),
            'expertise-organisation' => self::expertiseImage(
                'Organisation événementielle',
                'organisation.jpg',
                'Hôtesses EVENTIA vérifiant la mise en place d’une salle de réception avant l’arrivée des invités',
            ),
            'expertise-activation' => self::expertiseImage(
                'Activation de produits & de marques',
                'lancement de produit.jpg',
                'Hôtesses EVENTIA présentant des produits de beauté à des visiteuses sur un stand',
            ),
            'expertise-personnel' => self::expertiseImage(
                'Personnel événementiel sur mesure',
                'personnel evenementiel sur mesure.jpg',
                'Personnel événementiel EVENTIA lors d’un événement',
            ),
            'expertise-wedding' => self::expertiseImage('Wedding Planning', 'wedding planning.jpg', 'Illustration Wedding Planning EVENTIA'),
            'expertise-decoration' => self::expertiseImage(
                'Décoration événementielle',
                'decoration.jpg',
                'Illustration décoration événementielle EVENTIA',
            ),
            'expertise-restauration' => self::expertiseImage(
                'Restauration événementielle',
                'restoration.jpg',
                'Illustration restauration événementielle EVENTIA',
            ),
            'expertise-image' => self::expertiseImage('Gestion d’image', "gestion de l'image.jpg", 'Illustration gestion d’image EVENTIA'),

            'realisation-littoral-main' => [
                'label' => 'Littoral & Sud-Ouest 2026',
                'files' => ['/media/realisations/littoral-sud-ouest-2026/main.jpg'],
                'motif' => 'spotlight',
            ],
            'realisation-littoral-detail' => [
                'label' => 'Littoral & Sud-Ouest 2026 — détail',
                'files' => ['/media/realisations/littoral-sud-ouest-2026/detail-1.jpg'],
                'motif' => 'portrait',
            ],
            'realisation-miss-main' => [
                'label' => 'Miss Cameroun 2026',
                'files' => ['/media/realisations/miss-cameroun-2026/misscameroun1.jpg'],
                'motif' => 'spotlight',
                'media' => [
                    'kind' => 'image',
                    'src' => '/media/realisations/miss-cameroun-2026/misscameroun1.jpg',
                    'alt' => 'Hôtesses EVENTIA en uniforme bleu présentant les écharpes des lauréates sur la scène de Miss Cameroun',
                ],
            ],
            'realisation-miss-side' => [
                'label' => 'Miss Cameroun 2026 — photo',
                'files' => ['/media/realisations/miss-cameroun-2026/miss cameroun3.png'],
                'motif' => 'portrait',
                'media' => [
                    'kind' => 'image',
                    'src' => '/media/realisations/miss-cameroun-2026/miss cameroun3.png',
                    'alt' => 'Remise des écharpes sur la scène de la finale Miss Cameroun, avec une hôtesse EVENTIA en robe bleue',
                ],
            ],
            'realisation-miss-detail' => [
                'label' => 'Miss Cameroun 2026 — détail',
                'files' => ['/media/realisations/miss-cameroun-2026/miss cameroun2.jpg'],
                'motif' => 'arch',
                'media' => [
                    'kind' => 'image',
                    'src' => '/media/realisations/miss-cameroun-2026/miss cameroun2.jpg',
                    'alt' => 'Hôtesses EVENTIA remettant les sacs cadeaux aux candidates sur scène lors de Miss Cameroun',
                ],
            ],
            'realisation-miss-extra' => [
                'label' => 'Miss Cameroun 2026 — photo',
                'files' => ['/media/realisations/miss-cameroun-2026/miss cameroun5.jpeg'],
                'motif' => 'spotlight',
                'media' => [
                    'kind' => 'image',
                    'src' => '/media/realisations/miss-cameroun-2026/miss cameroun5.jpeg',
                    'alt' => 'Équipe d’hôtesses EVENTIA en robes longues bleues posant devant le mur de presse de Miss Cameroun 2026',
                ],
            ],
            'realisation-comica' => [
                'label' => 'Partenariat COMICA',
                'files' => ['/media/realisations/comica/COMICA_partenariat.jpg'],
                'motif' => 'arch',
                'media' => [
                    'kind' => 'image',
                    'src' => '/media/realisations/comica/COMICA_partenariat.jpg',
                    'alt' => 'Affiche : COMICA et Eventia annoncent leur partenariat pour Miss Cameroun 2026 — hôtesses événementielles et accueil des invités VVIP, finale nationale le 19 septembre 2026',
                    'fit' => 'contain',
                ],
            ],

            'equipe-noura' => [
                'label' => 'Portrait — Noura Njikam',
                'files' => ['/media/equipe/NouraPDG.PNG'],
                'motif' => 'portrait',
                'media' => [
                    'kind' => 'image',
                    'src' => '/media/equipe/NouraPDG.PNG',
                    'alt' => 'Portrait de Noura Njikam, PDG d’EVENTIA BY N.J, en tailleur bleu',
                    'anchor' => 'top',
                ],
            ],
            'equipe-groupe' => [
                'label' => 'L’équipe EVENTIA',
                'files' => ['/media/equipe/equipe1.jpg'],
                'motif' => 'spotlight',
                'media' => [
                    'kind' => 'image',
                    'src' => '/media/equipe/equipe1.jpg',
                    'alt' => 'Noura Njikam, Miss World Cameroun 2026, entourée des hôtesses EVENTIA en uniforme bleu',
                ],
            ],
            'equipe-terrain' => [
                'label' => 'L’équipe EVENTIA sur le terrain',
                'files' => ['/media/hero/hero.jpg'],
                'motif' => 'portrait',
                'media' => [
                    'kind' => 'image',
                    'src' => '/media/hero/hero.jpg',
                    'alt' => 'Hôtesses EVENTIA en uniforme bleu posant autour d’un kakémono Eventia',
                ],
            ],

            'recrutement-portrait' => [
                'label' => 'Recrutement',
                'files' => ['/media/recrutement/recrutement.png'],
                'motif' => 'portrait',
                'media' => [
                    'kind' => 'image',
                    'src' => '/media/recrutement/recrutement.png',
                    'alt' => 'Hôtesse EVENTIA souriante en uniforme bleu et foulard blanc',
                    'anchor' => 'top',
                ],
            ],
            'recrutement-equipe' => [
                'label' => 'Les hôtesses EVENTIA',
                'files' => ['/media/realisations/miss-cameroun-2026/mis cameroun4.PNG'],
                'motif' => 'spotlight',
                'media' => [
                    'kind' => 'image',
                    'src' => '/media/realisations/miss-cameroun-2026/mis cameroun4.PNG',
                    'alt' => 'Les hôtesses EVENTIA en robes de satin bleu roi devant le mur Eventia',
                ],
            ],
        ];
    }

    // English label/alt per slot; the French text above stays the reference.
    private const TEXT_EN = [
        'expertise-accueil' => [
            'label' => 'Reception & representation',
            'alt' => 'EVENTIA hostess in a blue dress welcoming a guest at the entrance of a reception',
        ],
        'expertise-protocole' => [
            'label' => 'Protocol & guest assistance',
            'alt' => 'EVENTIA hostess accompanying a guest through a reception hall',
        ],
        'expertise-organisation' => [
            'label' => 'Event organisation',
            'alt' => 'EVENTIA hostesses checking the set-up of a reception hall before the guests arrive',
        ],
        'expertise-activation' => [
            'label' => 'Product & brand activation',
            'alt' => 'EVENTIA hostesses presenting beauty products to visitors at a stand',
        ],
        'expertise-personnel' => ['label' => 'Tailored event staff', 'alt' => 'EVENTIA event staff at an event'],
        'expertise-wedding' => ['label' => 'Wedding Planning', 'alt' => 'EVENTIA Wedding Planning illustration'],
        'expertise-decoration' => ['label' => 'Event decoration', 'alt' => 'EVENTIA event decoration illustration'],
        'expertise-restauration' => ['label' => 'Event catering', 'alt' => 'EVENTIA event catering illustration'],
        'expertise-image' => ['label' => 'Image management', 'alt' => 'EVENTIA image management illustration'],
        'realisation-littoral-main' => ['label' => 'Littoral & South-West 2026'],
        'realisation-littoral-detail' => ['label' => 'Littoral & South-West 2026 — detail'],
        'realisation-miss-main' => [
            'label' => 'Miss Cameroun 2026',
            'alt' => 'EVENTIA hostesses in blue uniforms presenting the winners’ sashes on the Miss Cameroun stage',
        ],
        'realisation-miss-side' => [
            'label' => 'Miss Cameroun 2026 — photo',
            'alt' => 'Sash ceremony on the stage of the Miss Cameroun final, with an EVENTIA hostess in a blue dress',
        ],
        'realisation-miss-detail' => [
            'label' => 'Miss Cameroun 2026 — detail',
            'alt' => 'EVENTIA hostesses handing gift bags to the contestants on stage at Miss Cameroun',
        ],
        'realisation-miss-extra' => [
            'label' => 'Miss Cameroun 2026 — photo',
            'alt' => 'Team of EVENTIA hostesses in long blue dresses posing in front of the Miss Cameroun 2026 press wall',
        ],
        'realisation-comica' => [
            'label' => 'COMICA partnership',
            'alt' => 'Poster: COMICA and Eventia announce their partnership for Miss Cameroun 2026 — event hostesses and VVIP guest reception, national final on 19 September 2026',
        ],
        'equipe-noura' => [
            'label' => 'Portrait — Noura Njikam',
            'alt' => 'Portrait of Noura Njikam, CEO of EVENTIA BY N.J, in a blue suit',
        ],
        'equipe-groupe' => [
            'label' => 'The EVENTIA team',
            'alt' => 'Noura Njikam, Miss World Cameroun 2026, surrounded by EVENTIA hostesses in blue uniforms',
        ],
        'equipe-terrain' => [
            'label' => 'The EVENTIA team on site',
            'alt' => 'EVENTIA hostesses in blue uniforms posing around an Eventia roll-up banner',
        ],
        'recrutement-portrait' => ['label' => 'Careers', 'alt' => 'Smiling EVENTIA hostess in a blue uniform and white scarf'],
        'recrutement-equipe' => [
            'label' => 'The EVENTIA hostesses',
            'alt' => 'EVENTIA hostesses in royal blue satin dresses in front of the Eventia wall',
        ],
    ];

    /** Homepage Réalisations carousel, in display order. Add an item to add a slide (real event photos only). */
    public const REALISATIONS_SHOWCASE = [
        [
            'realisationId' => 'miss-cameroun-2026',
            'src' => '/media/realisations/miss-cameroun-2026/mis cameroun4.PNG',
            'alt' => [
                'fr' => 'Les hôtesses EVENTIA en robes de satin bleu roi devant le mur Eventia lors de Miss Cameroun 2026',
                'en' => 'EVENTIA hostesses in royal blue satin dresses in front of the Eventia wall at Miss Cameroun 2026',
            ],
        ],
        [
            'realisationId' => 'miss-cameroun-2026',
            'src' => '/media/realisations/miss-cameroun-2026/misscameroun1.jpg',
            'alt' => [
                'fr' => 'Hôtesses EVENTIA en uniforme bleu présentant les écharpes des lauréates sur la scène de Miss Cameroun',
                'en' => 'EVENTIA hostesses in blue uniforms presenting the winners’ sashes on the Miss Cameroun stage',
            ],
        ],
        [
            'realisationId' => 'miss-cameroun-2026',
            'src' => '/media/realisations/miss-cameroun-2026/miss cameroun3.png',
            'alt' => [
                'fr' => 'Remise des écharpes sur la scène de la finale Miss Cameroun, avec une hôtesse EVENTIA en robe bleue',
                'en' => 'Sash ceremony on the stage of the Miss Cameroun final, with an EVENTIA hostess in a blue dress',
            ],
        ],
        [
            'realisationId' => 'miss-cameroun-2026',
            'src' => '/media/realisations/miss-cameroun-2026/miss cameroun2.jpg',
            'alt' => [
                'fr' => 'Hôtesses EVENTIA remettant les sacs cadeaux aux candidates sur scène lors de Miss Cameroun',
                'en' => 'EVENTIA hostesses handing gift bags to the contestants on stage at Miss Cameroun',
            ],
        ],
    ];

    public static function slot(string $id, string $locale): array
    {
        $slot = self::slots()[$id];
        if ($locale === 'fr') {
            return $slot;
        }
        $text = self::TEXT_EN[$id];
        $slot['label'] = $text['label'];
        if (isset($slot['media'], $text['alt']) && $slot['media']['kind'] !== 'embed') {
            $slot['media']['alt'] = $text['alt'];
        }

        return $slot;
    }

    /** Public URL of a file under /public, with each path segment percent-encoded (spaces, &, ' …). */
    public static function url(string $path): string
    {
        return implode('/', array_map('rawurlencode', explode('/', $path)));
    }

    /** next.config defaults: images.imageSizes + images.deviceSizes. */
    private const ALL_SIZES = [32, 48, 64, 96, 128, 256, 384, 640, 750, 828, 1080, 1200, 1920, 2048, 3840];

    private const DEVICE_SIZES = [640, 750, 828, 1080, 1200, 1920, 2048, 3840];

    private static ?array $optimized = null;

    /**
     * Responsive attributes of an image, as next/image computes them (getWidths in next/dist/shared/lib/get-img-props).
     * Uses the WebP copies built by scripts/optimize-images.mjs; falls back to the original file when none exist.
     *
     * @return array{src: string, srcset: ?string}
     */
    public static function responsive(string $src, ?string $sizes = null, ?int $width = null): array
    {
        self::$optimized ??= is_file($manifest = public_path('media-optimized/manifest.json'))
            ? json_decode(file_get_contents($manifest), true)
            : [];
        $entry = self::$optimized[$src] ?? null;
        if (! $entry) {
            return ['src' => self::url($src), 'srcset' => null];
        }

        if ($sizes !== null) {
            preg_match_all('/(^|\s)(1?\d?\d)vw/', $sizes, $matches);
            $percents = array_map('intval', $matches[2]);
            $widths = $percents
                ? array_values(array_filter(self::ALL_SIZES, fn ($size) => $size >= self::DEVICE_SIZES[0] * min($percents) * 0.01))
                : self::ALL_SIZES;
            $kind = 'w';
        } elseif ($width === null) {
            $widths = self::DEVICE_SIZES;
            $kind = 'w';
        } else {
            $last = self::ALL_SIZES[count(self::ALL_SIZES) - 1];
            $find = fn (int $w) => current(array_filter(self::ALL_SIZES, fn ($size) => $size >= $w)) ?: $last;
            $widths = array_values(array_unique([$find($width), $find($width * 2)]));
            $kind = 'x';
        }

        // The optimizer never upscales: widths past the original are served at the original size.
        $file = fn (int $w) => self::url($entry['folder'].'/'.min($w, $entry['width']).'.webp');
        $candidates = array_map(
            fn (int $w, int $i) => $file($w).' '.($kind === 'w' ? "{$w}w" : ($i + 1).'x'),
            $widths,
            array_keys($widths),
        );

        return ['src' => $file($widths[count($widths) - 1]), 'srcset' => implode(', ', $candidates)];
    }
}
