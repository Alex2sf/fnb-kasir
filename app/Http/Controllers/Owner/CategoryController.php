<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $categories = Category::withCount('products')->where('store_id', $store->id)->latest()->paginate(10);
        return view('owner.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create([
            'store_id' => auth()->user()->store->id,
            'name' => $request->name
        ]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        if($category->store_id !== auth()->user()->store->id) abort(403);
        $request->validate(['name' => 'required|string|max:255']);
        $category->update(['name' => $request->name]);
        return redirect()->back()->with('success', 'Kategori berhasil diubah!');
    }

    public function destroy(Category $category)
    {
        if($category->store_id !== auth()->user()->store->id) abort(403);
        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
