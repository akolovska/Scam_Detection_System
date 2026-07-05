<?php

namespace App\Mail;

use App\Models\ScamReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HighRiskReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ScamReport $report) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 High Risk Scam Report',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.high-risk-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
