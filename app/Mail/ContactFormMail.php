<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fromName;
    public $fromEmail;
    public $to;
    public $subject;
    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct($fromName, $fromEmail, $to, $subject, $mailData)
    {
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
        $this->to = $to;
        $this->subject = $subject;
        $this->mailData = $mailData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,  // Use the subject passed from the controller
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form',  // Ensure you have this view file in place
            with: [
                'mailData' => $this->mailData  // Passing the HTML content to the view
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
