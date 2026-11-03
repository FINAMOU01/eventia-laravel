<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/** Every page of the EVENTIA SARL structure answers with the right title, canonical URL and language. */
class PagesTest extends TestCase
{
    public static function pages(): array
    {
        return [
            ['/', 'fr', 'EVENTIA SARL — Nous créons ce qui vous distingue', 'https://eventianj.com'],
            ['/expertises/image-personal-branding', 'fr', 'EVENTIA IMAGE &amp; PERSONAL BRANDING | EVENTIA SARL', 'https://eventianj.com/expertises/image-personal-branding'],
            ['/expertises/hotesses', 'fr', 'EVENTIA HÔTESSES | EVENTIA SARL', 'https://eventianj.com/expertises/hotesses'],
            ['/expertises/events', 'fr', 'EVENTIA EVENTS | EVENTIA SARL', 'https://eventianj.com/expertises/events'],
            ['/agence', 'fr', 'L’agence | EVENTIA SARL', 'https://eventianj.com/agence'],
            ['/recrutement', 'fr', 'Recrutement | EVENTIA SARL', 'https://eventianj.com/recrutement'],
            ['/contact', 'fr', 'Contact et demande de devis | EVENTIA SARL', 'https://eventianj.com/contact'],
            ['/mentions-legales', 'fr', 'Mentions légales | EVENTIA SARL', 'https://eventianj.com/mentions-legales'],
            ['/en', 'en', 'EVENTIA SARL — We create what sets you apart', 'https://eventianj.com/en'],
            ['/en/expertises/image-personal-branding', 'en', 'EVENTIA IMAGE &amp; PERSONAL BRANDING | EVENTIA SARL', 'https://eventianj.com/en/expertises/image-personal-branding'],
            ['/en/expertises/hotesses', 'en', 'EVENTIA HÔTESSES | EVENTIA SARL', 'https://eventianj.com/en/expertises/hotesses'],
            ['/en/expertises/events', 'en', 'EVENTIA EVENTS | EVENTIA SARL', 'https://eventianj.com/en/expertises/events'],
            ['/en/agence', 'en', 'The agency | EVENTIA SARL', 'https://eventianj.com/en/agence'],
            ['/en/recrutement', 'en', 'Careers | EVENTIA SARL', 'https://eventianj.com/en/recrutement'],
            ['/en/contact', 'en', 'Contact and quote request | EVENTIA SARL', 'https://eventianj.com/en/contact'],
            ['/en/mentions-legales', 'en', 'Legal notice | EVENTIA SARL', 'https://eventianj.com/en/mentions-legales'],
        ];
    }

    #[DataProvider('pages')]
    public function test_page_renders(string $uri, string $locale, string $title, string $canonical): void
    {
        $response = $this->get($uri);

        $response->assertOk();
        $response->assertSee('<html lang="'.$locale.'"', false);
        $response->assertSee('<title>'.$title.'</title>', false);
        $response->assertSee('<link rel="canonical" href="'.$canonical.'">', false);
        $response->assertSee('id="contenu"', false);
    }

    public static function redirects(): array
    {
        return [
            ['/expertises', '/#expertise'],
            ['/realisations', '/expertises/hotesses'],
            ['/equipe', '/agence'],
            ['/en/expertises', '/en#expertise'],
            ['/en/realisations', '/en/expertises/hotesses'],
            ['/en/equipe', '/en/agence'],
        ];
    }

    #[DataProvider('redirects')]
    public function test_former_urls_redirect_permanently(string $from, string $to): void
    {
        $this->get($from)->assertStatus(301)->assertRedirect($to);
    }

    public function test_navigation_offers_the_three_divisions(): void
    {
        $this->get('/')
            ->assertSee('id="sous-menu-expertises"', false)
            ->assertSeeInOrder(['EVENTIA IMAGE &amp; PERSONAL BRANDING', 'EVENTIA HÔTESSES', 'EVENTIA EVENTS'], false)
            ->assertSee('href="/expertises/hotesses"', false);
    }

    public function test_official_contact_details(): void
    {
        $this->get('/contact')
            ->assertSee('Bastos, Yaoundé – Cameroun')
            ->assertSee('tel:+237692237387', false)
            ->assertSee('tel:+237675423265', false)
            ->assertSee('mailto:contact@eventianj.com', false)
            ->assertSee('https://wa.me/237692237387', false)
            ->assertDontSee('656', false)
            ->assertDontSee('BY N.J');
    }

    public function test_official_titles_and_signatures(): void
    {
        $this->get('/')
            ->assertSeeInOrder([
                'Conseil en image, personal branding et communication pour faire rayonner votre identité.',
                'Des équipes d’accueil, de protocole et d’activation pour offrir une expérience professionnelle à vos publics.',
                'Conception et coordination d’événements professionnels, institutionnels, culturels et privés.',
            ])
            ->assertDontSee('Descriptions officielles des trois pôles')
            ->assertSeeInOrder([
                'Pourquoi EVENTIA',
                'Trois expertises complémentaires, mobilisables séparément ou ensemble.',
                'Des solutions adaptées aux objectifs et au budget du client.',
                'Une organisation structurée, de la préparation à l’exécution.',
                'Une attention portée à l’image, au service et aux détails.',
            ])
            ->assertDontSee('Les quatre engagements d’EVENTIA');
        $this->get('/')->assertSee('EVENTIA SARL')->assertSee('Pourquoi EVENTIA ?');
        $this->get('/expertises/image-personal-branding')->assertSee('Faites de votre image une force.')->assertSee('Votre image. Votre influence. Votre empreinte.')
            ->assertSeeInOrder([
                'Nos services', 'Conseil en image et positionnement', 'Personal branding et image publique', 'Communication et visibilité médiatique',
                'Présence digitale et réseaux sociaux', 'Préparation aux prises de parole et media training', 'Stylisme, préparation visuelle et shootings',
                'identité visuelle, cartes de visite, plaquettes, brochures et visuels digitaux',
                'Notre approche', 'Écouter.', 'Clarifier votre positionnement.', 'Construire les bons supports.', 'Renforcer votre visibilité.',
            ])
            ->assertDontSee('Contenu à fournir par le client')
            ->assertDontSee('aria-label="Le pôle en images"', false);
        $this->get('/expertises/hotesses')->assertSee('Le premier contact donne le ton.')->assertSee('L’élégance de l’accueil. La puissance de l’image.')->assertSee('Miss Cameroun 2026');
        $this->get('/expertises/events')->assertSee('Vos idées prennent vie. Chaque détail compte.')->assertSee('Le prestige en scène.');
        $this->get('/agence')->assertSee('Une agence, trois expertises complémentaires.')->assertSee('Noura Njikam');
        $this->get('/recrutement')
            ->assertSee('Rejoignez l’équipe <em class="text-accent italic">EVENTIA</em>', false)
            ->assertSee('Nous recherchons des personnalités capables d’incarner l’élégance, le professionnalisme et l’énergie EVENTIA.')
            ->assertSeeInOrder(['Taille minimale', '1,70 m', 'Âge', '19–30 ans'])
            ->assertSeeInOrder(['Hôtesses événementielles', 'Profils bilingues français / anglais', 'Personnes dynamiques et souriantes', 'Dynamisme et ponctualité', 'Excellent relationnel', 'Bonne présentation'])
            ->assertDontSee('Bon relationnel')->assertDontSee('id="criteres-titre"', false)
            ->assertSeeInOrder(['CV', 'Lettre de motivation', 'Photo portrait récente', 'Photo récente en pied, sans filtre'])
            ->assertSee('Les candidatures sont étudiées selon les besoins et les missions.')
            ->assertSee('mailto:candidature@eventianj.com?subject=Candidature%20%E2%80%94%20EVENTIA&amp;body=Bonjour%2C%0A%0AJe%20souhaite%20rejoindre%20l%E2%80%99%C3%A9quipe%20EVENTIA.%20Vous%20trouverez%20ci-joint%20%3A%0A-%20CV%0A-%20Lettre%20de%20motivation%0A-%20Photo%20portrait%20r%C3%A9cente%0A-%20Photo%20r%C3%A9cente%20en%20pied%2C%20sans%20filtre%0A%0ACordialement%2C%0A', false)
            ->assertDontSee('data-pending-content', false);
        $this->get('/contact')->assertSee('Envoyer ma demande');
    }

    public function test_only_the_legal_notice_is_not_indexed(): void
    {
        $this->get('/mentions-legales')->assertSee('<meta name="robots" content="noindex">', false);
        $this->get('/')->assertDontSee('name="robots"', false);
    }

    public function test_only_french_pages_carry_the_browser_language_redirect(): void
    {
        $this->get('/contact')->assertSee('location.replace("/en"', false);
        $this->get('/en/contact')->assertDontSee('location.replace("/en"', false);
    }

    public function test_unknown_url_returns_404(): void
    {
        $this->get('/nexiste-pas')->assertNotFound()->assertSee('This page could not be found.');
    }
}
