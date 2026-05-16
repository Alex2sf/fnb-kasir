<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Store;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOwners = User::whereHas('role', function($q) {
            $q->where('name', 'owner');
        })->count();

        $totalTransactions = Transaction::count();
        $globalOmzet = Transaction::sum('grand_total');

        $stores = Store::with(['user'])
            ->withCount('transactions')
            ->withSum('transactions', 'grand_total')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('totalOwners', 'totalTransactions', 'globalOmzet', 'stores'));
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah status akun Anda sendiri.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusMsg = $user->is_active ? 'diaktifkan' : 'di-suspend';
        return back()->with('success', "Akun pengguna berhasil {$statusMsg}.");
    }
}
