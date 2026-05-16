<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $customers = Customer::withCount('transactions')->where('store_id', $store->id)->latest()->paginate(10);
        return view('owner.customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'phone' => 'nullable|string|max:20', 'email' => 'nullable|email|max:255']);
        Customer::create([
            'store_id' => auth()->user()->store->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);
        return redirect()->back()->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function update(Request $request, Customer $customer)
    {
        if($customer->store_id !== auth()->user()->store->id) abort(403);
        $request->validate(['name' => 'required|string|max:255', 'phone' => 'nullable|string|max:20', 'email' => 'nullable|email|max:255']);
        $customer->update($request->only('name', 'phone', 'email'));
        return redirect()->back()->with('success', 'Data pelanggan berhasil diubah!');
    }

    public function destroy(Customer $customer)
    {
        if($customer->store_id !== auth()->user()->store->id) abort(403);
        $customer->delete();
        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus!');
    }
}
