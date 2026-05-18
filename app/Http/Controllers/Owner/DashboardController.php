<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $store = $user->store;

        if (!$store) {
            return view('owner.welcome');
        }

        $totalProducts = Product::where('store_id', $store->id)->count();
        $totalTransactions = Transaction::where('store_id', $store->id)->count();
        $totalOmzet = Transaction::where('store_id', $store->id)->sum('grand_total');
        $totalExpenses = \App\Models\Expense::where('store_id', $store->id)->sum('amount');
        $netProfit = $totalOmzet - $totalExpenses;
        
        // Stats Hari Ini
        $todayOmzet = Transaction::where('store_id', $store->id)->whereDate('created_at', today())->sum('grand_total');
        $todayExpenses = \App\Models\Expense::where('store_id', $store->id)->whereDate('date', today())->sum('amount');
        
        $recentTransactions = Transaction::where('store_id', $store->id)
            ->latest()
            ->take(5)
            ->get();

        $topProducts = TransactionItem::whereHas('transaction', function($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            ->select('product_id', 'product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('owner.dashboard', compact(
            'store', 
            'totalProducts', 
            'totalTransactions', 
            'totalOmzet', 
            'totalExpenses', 
            'netProfit', 
            'todayOmzet', 
            'todayExpenses', 
            'recentTransactions', 
            'topProducts'
        ));
    }
}
