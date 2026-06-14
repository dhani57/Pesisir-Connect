<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the customer when payment is confirmed (Midtrans callback success).
 */
class PaymentReceivedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Transaction $transaction)
    {
        $this->transaction->load(['product', 'customer', 'vendor.user']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembayaran Berhasil — #' . $this->transaction->invoice_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-received',
        );
    }
}
