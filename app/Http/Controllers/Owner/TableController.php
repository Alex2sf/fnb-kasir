<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::where('store_id', auth()->user()->store->id)->latest()->get();
        return view('owner.tables.index', compact('tables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'status' => 'required|in:available,occupied'
        ]);

        Table::create([
            'store_id' => auth()->user()->store->id,
            'name' => $request->name,
            'status' => $request->status
        ]);

        return back()->with('success', 'Meja berhasil ditambahkan.');
    }

    public function update(Request $request, Table $table)
    {
        if ($table->store_id !== auth()->user()->store->id) abort(403);
        
        $request->validate([
            'name' => 'required|string|max:50',
            'status' => 'required|in:available,occupied'
        ]);

        $table->update($request->only('name', 'status'));
        return back()->with('success', 'Data meja berhasil diperbarui.');
    }

    public function destroy(Table $table)
    {
        if ($table->store_id !== auth()->user()->store->id) abort(403);
        $table->delete();
        return back()->with('success', 'Meja berhasil dihapus.');
    }
}
