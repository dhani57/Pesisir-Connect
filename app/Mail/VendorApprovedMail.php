<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to a vendor when their account is approved by admin.
 */
class VendorApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public User $vendor)
    {
        $this->vendor->load('vendor');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Akun Vendor Anda Telah Disetujui — PesisirConnect',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.vendor-approved',
        );
    }
}
