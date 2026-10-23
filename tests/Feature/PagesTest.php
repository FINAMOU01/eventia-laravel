<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/** Every URL of the Next.js site answers with the same title, canonical URL and language as the original. */
class PagesTest extends TestCase
{
    public static function pages(): array
    {
        return [
            ['/', 'fr', 'EVENTIA BY N.J — L’excellence de l’accueil au service de votre image', 'https://eventianj.com'],
            ['/expertises', 'fr', 'Expertises | EVENTIA BY N.J', 'https://eventianj.com/expertises'],
            ['/realisations', 'fr', 'Réalisations | EVENTIA BY N.J', 'https://eventianj.com/realisations'],
            ['/equipe', 'fr', 'L’équipe | EVENTIA BY N.J', 'https://eventianj.com/equipe'],
            ['/recrutement', 'fr', 'Recrutement | EVENTIA BY N.J', 'https://eventianj.com/recrutement'],
            ['/contact', 'fr', 'Contact | EVENTIA BY N.J', 'https://eventianj.com/contact'],
            ['/mentions-legales', 'fr', 'Mentions légales | EVENTIA BY N.J', 'https://eventianj.com/mentions-legales'],
            ['/en', 'en', 'EVENTIA BY N.J — Hospitality excellence in service of your image', 'https://eventianj.com/en'],
            ['/en/expertises', 'en', 'Expertise | EVENTIA BY N.J', 'https://eventianj.com/en/expertises'],
            ['/en/realisations', 'en', 'Our work | EVENTIA BY N.J', 'https://eventianj.com/en/realisations'],
            ['/en/equipe', 'en', 'The team | EVENTIA BY N.J', 'https://eventianj.com/en/equipe'],
            ['/en/recrutement', 'en', 'Careers | EVENTIA BY N.J', 'https://eventianj.com/en/recrutement'],
            ['/en/contact', 'en', 'Contact | EVENTIA BY N.J', 'https://eventianj.com/en/contact'],
            ['/en/mentions-legales', 'en', 'Legal notice | EVENTIA BY N.J', 'https://eventianj.com/en/mentions-legales'],
        ];
    }

    #[DataProvider('pages')]
    public function test_page_renders(string $uri, string $locale, string $title, string $canonical): void
    {
        $response = $this->get($uri);

        $response->assertOk();
        $response->assertSee('<html lang="'.$locale.'"', false);
        $response->assertSee('<title>'.e($title).'</title>', false);
        $response->assertSee('<link rel="canonical" href="'.$canonical.'">', false);
        $response->assertSee('id="contenu"', false);
    }

    public function test_only_the_legal_notice_is_not_indexed(): void
    {
        $this->get('/mentions-legales')->assertSee('<meta name="robots" content="noindex">', false);
        $this->get('/en/mentions-legales')->assertSee('<meta name="robots" content="noindex">', false);
        $this->get('/')->assertDontSee('name="robots"', false);
    }

    public function test_only_french_pages_carry_the_browser_language_redirect(): void
    {
        $this->get('/contact')->assertSee('location.replace("/en"', false);
        $this->get('/en/contact')->assertDontSee('location.replace("/en"', false);
    }

    public function test_contact_and_recruitment_addresses(): void
    {
        $this->get('/contact')->assertSee('mailto:contact@eventianj.com', false);
        $this->get('/recrutement')
            ->assertSee('mailto:candidature@eventianj.com?subject=Candidature%20%E2%80%94%20EVENTIA', false)
            ->assertSee('candidature@eventianj.com</a>', false);
    }

    public function test_unknown_url_returns_the_next_js_style_404(): void
    {
        $this->get('/nexiste-pas')
            ->assertNotFound()
            ->assertSee('This page could not be found.');
    }
}
