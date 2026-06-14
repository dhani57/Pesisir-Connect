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
 * Sent to the customer after a successful checkout (transaction created).
 */
class OrderCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Transaction $transaction)
    {
        $this->transaction->load(['product', 'customer', 'vendor.user']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesanan Berhasil Dibuat — #' . $this->transaction->invoice_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-created',
        );
    }
}
