<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ServiceRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contact $contact) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [$this->contact->email],
            subject: 'New service request: '.ucfirst($this->contact->service),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.service-request-received',
        );
    }

    /**
     * Attach photos separately so recipients can save them from their mail app.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return collect($this->contact->photos ?? [])
            ->values()
            ->map(function (string $path, int $index) {
                $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'jpg';

                return Attachment::fromStorageDisk('local', $path)
                    ->as(sprintf('service-request-photo-%d.%s', $index + 1, $extension))
                    ->withMime(Storage::disk('local')->mimeType($path));
            })
            ->all();
    }
}
