<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    /**
     * Create a new message instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->view('emails.verify-otp')
                    ->with('otp', $this->otp);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'OTP Verifikasi Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-otp',
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
