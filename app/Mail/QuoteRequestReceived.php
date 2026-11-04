<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use App\Support\Content;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content as MailContent;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** Notifies the EVENTIA team of a new quote request; replying answers the visitor directly. */
class QuoteRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public QuoteRequest $quote) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address($this->quote->email, $this->quote->name)],
            subject: 'Demande de devis — '.$this->poleName().' — '.$this->quote->name,
        );
    }

    public function content(): MailContent
    {
        return new MailContent(text: 'mail.quote-request', with: ['pole' => $this->poleName()]);
    }

    private function poleName(): string
    {
        return Content::pole($this->quote->pole, 'fr')['name'];
    }
}
