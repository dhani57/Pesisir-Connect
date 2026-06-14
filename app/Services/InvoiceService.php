<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\View;

/**
 * InvoiceService
 *
 * Generates PDF invoices for transactions using the built-in
 * DomPDF integration (via barryvdh/laravel-dompdf).
 */
class InvoiceService
{
    /**
     * Generate an invoice PDF for the given transaction.
     *
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generate(Transaction $transaction)
    {
        $transaction->load(['customer', 'product.category', 'vendor.user']);

        $data = [
            'transaction' => $transaction,
            'invoiceDate' => $transaction->paid_at ?? $transaction->created_at,
            'platformName' => 'PesisirConnect',
            'platformUrl' => url('/'),
        ];

        /** @var \Barryvdh\DomPDF\PDF $pdf */
        $pdf = app('dompdf.wrapper');

        $pdf->loadView('invoices.template', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }

    /**
     * Generate and return a download response.
     */
    public function download(Transaction $transaction): \Symfony\Component\HttpFoundation\Response
    {
        $filename = 'Invoice-' . $transaction->invoice_number . '.pdf';

        return $this->generate($transaction)->download($filename);
    }

    /**
     * Generate and return raw PDF string (for email attachment).
     */
    public function toRaw(Transaction $transaction): string
    {
        return $this->generate($transaction)->output();
    }
}
