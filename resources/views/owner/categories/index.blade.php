@extends('layouts.owner')

@section('title', 'Kategori Produk')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Kategori Produk</h1>
            <p class="text-slate-500 mt-1 text-sm">Kelola pengelompokan produk menu Anda.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl flex items-center gap-3 border border-emerald-100">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- List Category -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800">Daftar Kategori</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500">
                            <th class="p-4 font-semibold">Nama Kategori</th>
                            <th class="p-4 font-semibold">Jumlah Produk</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4 font-medium text-slate-800">{{ $category->name }}</td>
                                <td class="p-4 text-slate-600">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $category->products_count }} item
                                    </span>
                                </td>
                                <td class="p-4 text-right flex items-center justify-end gap-2">
                                    <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}')" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <form action="{{ route('owner.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Produk di dalamnya mungkin terpengaruh.')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-slate-400">Belum ada kategori yang ditambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($categories->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

        <!-- Add Category Form -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 h-fit sticky top-6">
            <h3 class="font-bold text-slate-800 mb-4" id="formTitle">Tambah Kategori</h3>
            <form id="categoryForm" action="{{ route('owner.categories.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                        <input type="text" name="name" id="categoryName" required class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm p-2.5 border" placeholder="Contoh: Minuman Dingin">
                    </div>
                    <div class="pt-2 flex gap-2">
                        <button type="button" id="btnCancel" onclick="resetForm()" class="hidden px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-colors text-sm font-medium">Batal</button>
                        <button type="submit" id="btnSubmit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl transition-colors text-sm font-medium shadow-sm shadow-indigo-200">
                            Simpan Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editCategory(id, name) {
        const form = document.getElementById('categoryForm');
        form.action = `/owner/categories/${id}`;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('categoryName').value = name;
        document.getElementById('formTitle').innerText = 'Edit Kategori';
        document.getElementById('btnSubmit').innerText = 'Update';
        document.getElementById('btnCancel').classList.remove('hidden');
    }

    function resetForm() {
        const form = document.getElementById('categoryForm');
        form.action = `{{ route('owner.categories.store') }}`;
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('categoryName').value = '';
        document.getElementById('formTitle').innerText = 'Tambah Kategori';
        document.getElementById('btnSubmit').innerText = 'Simpan Kategori';
        document.getElementById('btnCancel').classList.add('hidden');
    }
</script>
@endpush
