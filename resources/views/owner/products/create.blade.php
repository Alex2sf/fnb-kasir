@extends('layouts.owner')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('owner.products.index') }}" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-colors shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Produk Baru</h1>
            <p class="text-slate-500 mt-1 text-sm">Isi detail lengkap produk menu Anda.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl border border-red-100">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('owner.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        @csrf
        <div class="p-6 sm:p-8 space-y-8">
            <!-- Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4 md:col-span-2">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Informasi Dasar</h3>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm p-2.5 border" placeholder="Contoh: Es Kopi Susu Aren">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" required class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm p-2.5 border bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm p-2.5 border" placeholder="25000">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">SKU (Kode Item)</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm p-2.5 border" placeholder="KOP-001">
                </div>
            </div>

            <!-- Inventory & Media -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                <div class="space-y-4 md:col-span-2">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Inventaris & Gambar</h3>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Produk</label>
                    <div class="mt-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Tersedia untuk dijual</p>
                                <p class="text-xs text-slate-500">Hapus centang jika produk sedang habis/nonaktif.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gambar Produk (Opsional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-colors bg-slate-50 relative group">
                        <div class="space-y-1 text-center">
                            <i data-lucide="image" class="mx-auto h-12 w-12 text-slate-300 group-hover:text-indigo-400 transition-colors"></i>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload file</span>
                                    <input id="file-upload" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-slate-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                        <img id="image-preview" class="absolute inset-0 w-full h-full object-cover rounded-xl hidden">
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('owner.products.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-200 rounded-xl transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-200 transition-colors flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Produk
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('image-preview');
            output.src = reader.result;
            output.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
