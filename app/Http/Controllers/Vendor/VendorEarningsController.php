<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\CommissionService;
use App\Services\PayoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VendorEarningsController extends Controller
{
    public function __construct(private CommissionService $commissionService, private PayoutService $payoutService) {}

    public function index(): View
    {
        $vendor = auth()->user()->vendor;
        $summary = $this->commissionService->getEarningsSummary($vendor);
        $paymentHistory = $this->payoutService->getPaymentHistory($vendor);
        $earningsByProduct = $this->commissionService->earningsByProduct($vendor);
        $minPayout = PayoutService::MIN_PAYOUT;

        return view('vendor.earnings.index', compact('vendor', 'summary', 'paymentHistory', 'earningsByProduct', 'minPayout'));
    }

    public function requestPayout(): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        try {
            $this->payoutService->requestPayout($vendor);
            return back()->with('success', 'Permintaan pencairan berhasil dikirim!');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
