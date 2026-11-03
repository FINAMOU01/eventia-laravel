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

/** Notifies the recruitment team of a new application, with the CV attached. */
class JobApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

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
        return new Content(text: 'mail.job-application');
    }

    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('local', $this->application->cv_path)
                ->as($this->application->cv_original_name)
                ->withMime($this->application->cv_mime),
        ];
    }
}
