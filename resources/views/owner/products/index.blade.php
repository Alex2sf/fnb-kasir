@extends('layouts.owner')

@section('title', 'Manajemen Produk')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Produk</h1>
            <p class="text-slate-500 mt-1 text-sm">Kelola semua daftar produk menu yang Anda jual.</p>
        </div>
        <div>
            <a href="{{ route('owner.products.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl font-medium transition-colors shadow-sm shadow-indigo-200 text-sm">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Tambah Produk
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl flex items-center gap-3 border border-emerald-100">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Product Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50">
            <div class="relative flex-1 sm:max-w-xs">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input type="text" placeholder="Cari nama atau SKU..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-sm">
            </div>
            <button class="p-2 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors bg-white">
                <i data-lucide="filter" class="w-4 h-4"></i>
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500">
                        <th class="p-4 font-semibold">Produk</th>
                        <th class="p-4 font-semibold">Kategori</th>
                        <th class="p-4 font-semibold">Harga</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i data-lucide="image" class="w-5 h-5"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $product->name }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">SKU: {{ $product->sku ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-slate-600 font-medium">
                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                            </td>
                            <td class="p-4 font-bold text-indigo-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="p-4">
                                @if($product->is_available)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Tersedia</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Habis</span>
                                @endif
                            </td>
                            <td class="p-4 text-right flex items-center justify-end gap-2">
                                <a href="{{ route('owner.products.edit', $product) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('owner.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="package-open" class="w-8 h-8 text-slate-300"></i>
                                </div>
                                <p class="font-medium">Belum ada produk</p>
                                <p class="text-sm mt-1">Mulai tambahkan menu pertama Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
