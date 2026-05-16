@extends('layouts.owner')
@section('title', 'Diskon & Promo')

@section('content')
<div x-data="{ showModal: false, editMode: false, discountId: '', name: '', type: 'percentage', value: '', is_active: true }">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Diskon & Promo</h1>
            <p class="text-slate-500 text-sm mt-1">Buat potongan harga khusus untuk pelanggan.</p>
        </div>
        <button @click="showModal = true; editMode = false; name = ''; type = 'percentage'; value = ''; is_active = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-medium flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Diskon
        </button>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });
        </script>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Nama Promo</th>
                    <th class="px-6 py-4">Tipe</th>
                    <th class="px-6 py-4">Potongan</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($discounts as $discount)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-800">{{ $discount->name }}</td>
                    <td class="px-6 py-4">
                        @if($discount->type == 'percentage')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-semibold">
                                <i data-lucide="percent" class="w-3.5 h-3.5"></i> Persentase
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-purple-50 text-purple-700 text-xs font-semibold">
                                <i data-lucide="coins" class="w-3.5 h-3.5"></i> Nominal (Rp)
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-800">
                        {{ $discount->type == 'percentage' ? rtrim(rtrim($discount->value, '0'), '.') . '%' : 'Rp ' . number_format($discount->value, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($discount->is_active)
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">Aktif</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <button @click="showModal = true; editMode = true; discountId = {{ $discount->id }}; name = '{{ $discount->name }}'; type = '{{ $discount->type }}'; value = '{{ rtrim(rtrim($discount->value, '0'), '.') }}'; is_active = {{ $discount->is_active ? 'true' : 'false' }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </button>
                            <form id="delete-form-{{ $discount->id }}" action="{{ route('owner.discounts.destroy', $discount) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $discount->id }}, '{{ $discount->name }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        <i data-lucide="percent" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
                        <p class="font-medium text-slate-600">Belum ada promo atau diskon yang ditambahkan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/50 backdrop-blur-sm" @click="showModal = false"></div>

            <div x-show="showModal" x-transition class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-slate-800" x-text="editMode ? 'Edit Diskon' : 'Tambah Diskon'"></h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-5 h-5"></i></button>
                </div>

                <form :action="editMode ? '{{ url('owner/discounts') }}/' + discountId : '{{ route('owner.discounts.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="space-y-4 text-left">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Promo</label>
                            <input type="text" name="name" x-model="name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500" placeholder="Contoh: Promo Ramadhan">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tipe Potongan</label>
                            <select name="type" x-model="type" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500">
                                <option value="percentage">Persentase (%)</option>
                                <option value="fixed">Nominal Rupiah (Rp)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Besaran Potongan</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold" x-text="type == 'percentage' ? '%' : 'Rp'"></span>
                                <input type="number" name="value" x-model="value" step="0.01" required class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500" placeholder="0">
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1.5" x-text="type == 'percentage' ? 'Isi angka persen, misal 10 untuk Diskon 10%' : 'Isi nominal harga, misal 5000 untuk Potongan Rp5.000'"></p>
                        </div>
                        <div class="flex items-center gap-3 pt-2">
                            <input type="checkbox" id="is_active" name="is_active" x-model="is_active" value="1" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                            <label for="is_active" class="text-sm font-semibold text-slate-700 cursor-pointer">Aktifkan promo ini sekarang</label>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-4 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                        <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl" x-text="editMode ? 'Simpan' : 'Tambah'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Diskon?',
        text: `Anda yakin ingin menghapus promo "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5', // Warna tombol sesuai tema Indigo
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'rounded-xl',
            cancelButton: 'rounded-xl'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
@endpush
