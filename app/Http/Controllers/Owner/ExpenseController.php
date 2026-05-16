<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('store_id', auth()->user()->store->id)->latest('date')->latest('id')->get();
        return view('owner.expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        Expense::create([
            'store_id' => auth()->user()->store->id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'notes' => $request->notes
        ]);

        return back()->with('success', 'Data pengeluaran berhasil dicatat.');
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->store_id != auth()->user()->store->id) abort(403);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $expense->update($request->only('title', 'amount', 'date', 'notes'));
        return back()->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->store_id !== auth()->user()->store->id) abort(403);
        $expense->delete();
        return back()->with('success', 'Catatan pengeluaran berhasil dihapus.');
    }
}
