<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** Notifies the recruitment team of a new application, with the four documents attached. */
class JobApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public const LABELS = [
        'cv' => 'CV',
        'cover_letter' => 'Lettre de motivation',
        'photo_portrait' => 'Photo portrait récente',
        'photo_full' => 'Photo récente en pied',
    ];

    public function __construct(public JobApplication $application) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address($this->application->email, $this->application->name)],
            subject: 'Candidature — '.$this->application->mission_type.' — '.$this->application->name,
        );
    }

    public function content(): Content
    {
        return new Content(text: 'mail.job-application', with: ['labels' => self::LABELS]);
    }

    public function attachments(): array
    {
        return collect(JobApplication::DOCUMENTS)
            ->map(function (string $key) {
                $document = $this->application->documents[$key];
                // Prefix with the document type so the four files are easy to tell apart in the mailbox.
                $name = self::LABELS[$key].' - '.$document['name'];

                return Attachment::fromStorageDisk('local', $document['path'])->as($name)->withMime($document['mime']);
            })
            ->all();
    }
}
