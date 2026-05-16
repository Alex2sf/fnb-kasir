<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::where('store_id', auth()->user()->store->id)->latest()->get();
        return view('owner.discounts.index', compact('discounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0'
        ]);

        Discount::create([
            'store_id' => auth()->user()->store->id,
            'name' => $request->name,
            'type' => $request->type,
            'value' => $request->value,
            'is_active' => $request->has('is_active')
        ]);

        return back()->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function update(Request $request, Discount $discount)
    {
        if ($discount->store_id != auth()->user()->store->id) abort(403);
        
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0'
        ]);

        $discount->update([
            'name' => $request->name,
            'type' => $request->type,
            'value' => $request->value,
            'is_active' => $request->has('is_active')
        ]);
        return back()->with('success', 'Data diskon berhasil diperbarui.');
    }

    public function destroy(Discount $discount)
    {
        if ($discount->store_id != auth()->user()->store->id) abort(403);
        $discount->delete();
        return redirect()->route('owner.discounts.index')->with('success', 'Diskon berhasil dihapus.');
    }
}
