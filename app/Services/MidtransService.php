<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

/**
 * MidtransService
 *
 * Handles all interactions with the Midtrans payment gateway:
 * - Creating Snap payment tokens
 * - Processing payment notifications (webhooks)
 */
class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Create a Snap payment token for the given transaction.
     *
     * @return array{token: string, redirect_url: string}
     */
    public function createSnapToken(Transaction $transaction): array
    {
        $transaction->load(['customer', 'product']);

        $params = [
            'transaction_details' => [
                'order_id'     => $transaction->invoice_number,
                'gross_amount' => (int) $transaction->total_price,
            ],
            'customer_details' => [
                'first_name' => $transaction->customer->name,
                'email'      => $transaction->customer->email,
                'phone'      => $transaction->customer->phone ?? '',
            ],
            'item_details' => [
                [
                    'id'       => $transaction->product_id,
                    'price'    => (int) $transaction->unit_price,
                    'quantity' => $transaction->quantity,
                    'name'     => mb_substr($transaction->product->name, 0, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('checkout.finish', $transaction->invoice_number),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return [
            'token'        => $snapToken,
            'redirect_url' => $this->getSnapRedirectUrl($snapToken),
        ];
    }

    /**
     * Process a Midtrans notification webhook.
     *
     * @return array{order_id: string, transaction_status: string, fraud_status: string|null}
     */
    public function handleNotification(): array
    {
        $notification = new Notification();

        return [
            'order_id'           => $notification->order_id,
            'transaction_status' => $notification->transaction_status,
            'payment_type'       => $notification->payment_type,
            'fraud_status'       => $notification->fraud_status ?? null,
            'transaction_id'     => $notification->transaction_id ?? null,
            'raw'                => (array) $notification,
        ];
    }

    /**
     * Determine if a payment is considered successful based on Midtrans status.
     */
    public function isPaymentSuccess(string $transactionStatus, ?string $fraudStatus): bool
    {
        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'accept' || $fraudStatus === null;
        }

        return $transactionStatus === 'settlement';
    }

    /**
     * Determine if a payment is pending.
     */
    public function isPaymentPending(string $transactionStatus): bool
    {
        return $transactionStatus === 'pending';
    }

    /**
     * Determine if a payment has been denied, cancelled, or expired.
     */
    public function isPaymentFailed(string $transactionStatus): bool
    {
        return in_array($transactionStatus, ['deny', 'cancel', 'expire'], true);
    }

    /**
     * Get the Midtrans client key for frontend usage.
     */
    public function getClientKey(): string
    {
        return config('midtrans.client_key');
    }

    /**
     * Get Snap redirect URL from token.
     */
    private function getSnapRedirectUrl(string $token): string
    {
        $baseUrl = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v2/vtweb/'
            : 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';

        return $baseUrl . $token;
    }
}
