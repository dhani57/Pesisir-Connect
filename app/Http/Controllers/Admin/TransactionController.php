<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display a listing of all global transactions.
     */
    public function index(): View
    {
        $perPage = request('per_page', 10);
        $perPage = $perPage === 'all' ? 1000000 : (int) $perPage;

        // Eager loading customer and product.vendor to avoid N+1 issues
        $transactions = Transaction::with(['customer', 'product.vendor'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('admin.transactions.index', compact('transactions'));
    }
}
