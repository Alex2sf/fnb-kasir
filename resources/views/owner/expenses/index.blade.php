@extends('layouts.owner')
@section('title', 'Laporan Pengeluaran')

@section('content')
<div x-data="{ showModal: false, editMode: false, expenseId: '', title: '', amount: '', date: '{{ date('Y-m-d') }}', notes: '' }">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan Pengeluaran</h1>
            <p class="text-slate-500 text-sm mt-1">Catat dan pantau biaya operasional bisnis Anda.</p>
        </div>
        <button @click="showModal = true; editMode = false; title = ''; amount = ''; date = '{{ date('Y-m-d') }}'; notes = ''" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-medium flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Catat Pengeluaran
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 flex items-center gap-3 border border-emerald-100">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center">
                <i data-lucide="trending-down" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500">Total Pengeluaran Bulan Ini</p>
                <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($expenses->where('date', '>=', date('Y-m-01'))->sum('amount'), 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Keterangan</th>
                    <th class="px-6 py-4">Nominal</th>
                    <th class="px-6 py-4">Catatan</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($expenses as $expense)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-700">{{ \Carbon\Carbon::parse($expense->date)->translatedFormat('d M Y') }}</td>
                    <td class="px-6 py-4 font-bold text-slate-800">{{ $expense->title }}</td>
                    <td class="px-6 py-4 font-black text-rose-600">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $expense->notes ?? '-' }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <button @click="showModal = true; editMode = true; expenseId = {{ $expense->id }}; title = '{{ $expense->title }}'; amount = '{{ rtrim(rtrim($expense->amount, '0'), '.') }}'; date = '{{ $expense->date->format('Y-m-d') }}'; notes = '{{ $expense->notes }}'" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </button>
                            <form action="{{ route('owner.expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Hapus catatan pengeluaran ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        <i data-lucide="wallet" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
                        <p class="font-medium">Belum ada catatan pengeluaran.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/50 backdrop-blur-sm" @click="showModal = false"></div>

            <div x-show="showModal" x-transition class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-md border border-slate-200">
                <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-bold text-slate-800" x-text="editMode ? 'Edit Pengeluaran' : 'Catat Pengeluaran'"></h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 transition-colors"><i data-lucide="x" class="w-5 h-5"></i></button>
                </div>

                <form :action="editMode ? '{{ url('owner/expenses') }}/' + expenseId : '{{ route('owner.expenses.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan / Judul</label>
                            <input type="text" name="title" x-model="title" required class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="Contoh: Beli Gas, Bayar Listrik">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nominal Pengeluaran</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                                <input type="number" name="amount" x-model="amount" required class="w-full pl-11 pr-4 py-2.5 bg-white border border-slate-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="0">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal</label>
                            <input type="date" name="date" x-model="date" required class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" x-model="notes" rows="3" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="Detail tambahan jika diperlukan..."></textarea>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="showModal = false" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 rounded-md transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors shadow-sm" x-text="editMode ? 'Simpan Perubahan' : 'Catat Pengeluaran'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
