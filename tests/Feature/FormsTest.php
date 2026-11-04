<?php

namespace Tests\Feature;

use App\Mail\JobApplicationReceived;
use App\Mail\QuoteRequestReceived;
use App\Models\JobApplication;
use App\Models\QuoteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Tests\TestCase;

/** Quote and application forms: success only when stored AND e-mailed, never a false success. */
class FormsTest extends TestCase
{
    use RefreshDatabase;

    private function quote(array $overrides = []): array
    {
        return [
            'name' => 'Awa Test',
            'organisation' => 'Société Test',
            'phone' => '+237 692 23 73 87',
            'email' => 'awa@example.com',
            'pole' => 'hotesses',
            'service_type' => 'Accueil',
            'project_date' => '2026-12-15',
            'location' => 'Yaoundé',
            'budget' => '',
            'description' => 'Six hôtesses pour un gala.',
            ...$overrides,
        ];
    }

    private function application(array $overrides = []): array
    {
        return [
            'name' => 'Marie Test',
            'phone' => '+237 675 42 32 65',
            'email' => 'marie@example.com',
            'city' => 'Douala',
            'mission_type' => 'Hôtesse',
            'experience' => 'Deux ans en salon.',
            'cv' => UploadedFile::fake()->create('cv.pdf', 300, 'application/pdf'),
            'cover_letter' => UploadedFile::fake()->create('lettre.docx', 80, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
            'photo_portrait' => UploadedFile::fake()->image('portrait.jpg', 600, 800),
            'photo_full' => UploadedFile::fake()->image('pied.png', 600, 1200),
            ...$overrides,
        ];
    }

    public function test_quote_request_is_stored_and_emailed(): void
    {
        Mail::fake();

        $this->postJson('/contact', $this->quote())->assertCreated()->assertJson(['ok' => true]);

        $quote = QuoteRequest::sole();
        $this->assertSame('hotesses', $quote->pole);
        $this->assertSame('fr', $quote->locale);
        $this->assertNotNull($quote->notified_at);
        Mail::assertSent(QuoteRequestReceived::class, fn ($mail) => $mail->hasTo('contact@eventianj.com') && $mail->hasReplyTo('awa@example.com'));
    }

    public function test_quote_request_is_not_reported_as_sent_when_the_email_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP down'));

        $this->postJson('/en/contact', $this->quote())
            ->assertStatus(503)
            ->assertJson(['ok' => false])
            ->assertJsonFragment(['message' => 'Your request could not be sent. Please try again in a few moments or write to us at contact@eventianj.com.']);

        // Kept for follow-up, flagged as not notified.
        $this->assertNull(QuoteRequest::sole()->notified_at);
    }

    public function test_quote_request_validation(): void
    {
        Mail::fake();

        $this->postJson('/contact', $this->quote(['email' => 'pas-un-email', 'pole' => 'autre', 'name' => '', 'phone' => 'abc']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'pole', 'name', 'phone']);

        $this->assertSame(0, QuoteRequest::count());
        Mail::assertNothingSent();
    }

    public function test_quote_budget_and_organisation_are_optional(): void
    {
        Mail::fake();

        $this->postJson('/contact', $this->quote(['budget' => null, 'organisation' => null]))->assertCreated();
    }

    public function test_bots_filling_the_hidden_field_are_rejected(): void
    {
        Mail::fake();

        $this->postJson('/contact', $this->quote(['website' => 'http://spam.example']))->assertStatus(422);
        $this->assertSame(0, QuoteRequest::count());
    }

    public function test_quote_form_works_without_javascript(): void
    {
        Mail::fake();

        $this->from('/contact')->post('/contact', $this->quote())
            ->assertRedirect('/contact#demande-devis')
            ->assertSessionHas('form_status', ['form' => 'quote', 'ok' => true, 'message' => null]);
    }

    public function test_application_is_stored_privately_and_emailed_with_the_four_documents(): void
    {
        Storage::fake('local');
        Mail::fake();

        $this->postJson('/recrutement/candidature', $this->application())->assertCreated();

        $application = JobApplication::sole();
        $this->assertSame(['cv', 'cover_letter', 'photo_portrait', 'photo_full'], array_keys($application->documents));
        foreach ($application->documents as $document) {
            $this->assertStringStartsWith('candidatures/', $document['path']);
            $this->assertStringNotContainsString($document['name'], $document['path'], 'The stored name must not be the visitor’s file name.');
            Storage::disk('local')->assertExists($document['path']);
        }
        $this->assertSame('lettre.docx', $application->documents['cover_letter']['name']);
        $this->assertNotNull($application->notified_at);
        Mail::assertSent(JobApplicationReceived::class, fn ($mail) => $mail->hasTo('candidature@eventianj.com') && count($mail->attachments()) === 4);
    }

    public function test_application_rejects_invalid_or_oversized_cv(): void
    {
        Storage::fake('local');
        Mail::fake();

        $this->postJson('/recrutement/candidature', $this->application(['cv' => UploadedFile::fake()->create('virus.exe', 10)]))
            ->assertStatus(422)->assertJsonValidationErrors(['cv']);
        $this->postJson('/recrutement/candidature', $this->application(['cv' => UploadedFile::fake()->create('cv.pdf', 6000, 'application/pdf')]))
            ->assertStatus(422)->assertJsonValidationErrors(['cv']);
        $this->postJson('/recrutement/candidature', $this->application(['cv' => null]))
            ->assertStatus(422)->assertJsonValidationErrors(['cv']);

        $this->assertSame(0, JobApplication::count());
    }

    public function test_application_requires_the_four_documents_in_the_right_formats(): void
    {
        Storage::fake('local');
        Mail::fake();

        $this->postJson('/recrutement/candidature', $this->application(['cover_letter' => null, 'photo_portrait' => null, 'photo_full' => null]))
            ->assertStatus(422)->assertJsonValidationErrors(['cover_letter', 'photo_portrait', 'photo_full']);
        $this->postJson('/recrutement/candidature', $this->application([
            'cover_letter' => UploadedFile::fake()->image('lettre.jpg'),
            'photo_portrait' => UploadedFile::fake()->create('portrait.pdf', 100, 'application/pdf'),
            'photo_full' => UploadedFile::fake()->image('pied.jpg')->size(6000),
        ]))->assertStatus(422)->assertJsonValidationErrors(['cover_letter', 'photo_portrait', 'photo_full']);

        $this->assertSame(0, JobApplication::count());
        Storage::disk('local')->assertDirectoryEmpty('candidatures');
    }

    public function test_application_is_not_reported_as_sent_when_the_email_fails(): void
    {
        Storage::fake('local');
        Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP down'));

        $this->postJson('/recrutement/candidature', $this->application())->assertStatus(503)->assertJson(['ok' => false]);

        $this->assertNull(JobApplication::sole()->notified_at);
    }

    public function test_documents_are_never_publicly_reachable(): void
    {
        $this->assertFalse(str_starts_with(Storage::disk('local')->path('candidatures'), public_path()));
        $this->get('/storage/app/private/candidatures/cv.pdf')->assertNotFound();
        $this->get('/storage/candidatures/cv.pdf')->assertNotFound();
    }

    public function test_forms_are_rate_limited(): void
    {
        Mail::fake();

        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/contact', $this->quote())->assertCreated();
        }
        $this->postJson('/contact', $this->quote())->assertStatus(429);
    }
}
