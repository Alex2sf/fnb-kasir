<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $store = $user->store;

        if (!$store) {
            return redirect()->route('owner.dashboard')->with('error', 'Toko belum dikonfigurasi.');
        }

        $categories = Category::where('store_id', $store->id)->get();
        $products = Product::where('store_id', $store->id)->where('is_available', true)->get();
        $customers = \App\Models\Customer::where('store_id', $store->id)->get();
        $tables = \App\Models\Table::where('store_id', $store->id)->where('status', 'available')->orderBy('number')->get();
        $discounts = \App\Models\Discount::where('store_id', $store->id)->where('is_active', true)->get();

        return view('owner.pos', compact('store', 'categories', 'products', 'customers', 'tables', 'discounts'));
    }
}
