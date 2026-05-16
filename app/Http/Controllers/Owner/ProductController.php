<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $products = Product::with('category')->where('store_id', $store->id)->latest()->paginate(10);
        return view('owner.products.index', compact('products'));
    }

    public function create()
    {
        $store = auth()->user()->store;
        $categories = Category::where('store_id', $store->id)->get();
        return view('owner.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $store = auth()->user()->store;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048'
        ]);

        $validated['store_id'] = $store->id;
        $validated['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('owner.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        if($product->store_id !== auth()->user()->store->id) abort(403);
        $store = auth()->user()->store;
        $categories = Category::where('store_id', $store->id)->get();
        return view('owner.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if($product->store_id !== auth()->user()->store->id) abort(403);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        $validated['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('owner.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if($product->store_id !== auth()->user()->store->id) abort(403);
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return redirect()->route('owner.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
