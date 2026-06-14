<?php

namespace App\Mail;

use App\Models\VendorPayout;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to a vendor when their payout request has been processed.
 */
class PayoutProcessedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public VendorPayout $payout)
    {
        $this->payout->load('vendor.user');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembayaran Payout Berhasil Diproses — PesisirConnect',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payout-processed',
        );
    }
}
