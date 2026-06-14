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
        $search = request('search');

        // Eager loading customer and product.vendor to avoid N+1 issues
        $transactions = Transaction::with(['customer', 'product.vendor'])
            ->when($search, function ($query, $search) {
                $query->where('invoice_number', 'like', "%{$search}%")
                      ->orWhereHas('customer', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('product', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('admin.transactions.index', compact('transactions'));
    }
}
