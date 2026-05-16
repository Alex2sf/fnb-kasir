@extends('layouts.owner')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Riwayat Transaksi</h1>
            <p class="text-slate-500 mt-1 text-sm">Semua riwayat transaksi penjualan yang berhasil.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('owner.transactions.export') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl font-medium transition-colors shadow-sm text-sm">
                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                Export Excel (CSV)
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50">
            <div class="relative flex-1 sm:max-w-xs">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input type="text" placeholder="Cari No. Resi..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-sm">
            </div>
            <button class="p-2 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors bg-white">
                <i data-lucide="calendar" class="w-4 h-4"></i>
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500">
                        <th class="p-4 font-semibold">No. Resi & Waktu</th>
                        <th class="p-4 font-semibold">Pelanggan</th>
                        <th class="p-4 font-semibold">Total Tagihan</th>
                        <th class="p-4 font-semibold">Pembayaran</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4">
                                <p class="font-bold text-indigo-600">{{ $trx->receipt_number }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $trx->created_at->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="p-4">
                                @if($trx->customer)
                                    <span class="font-medium text-slate-800">{{ $trx->customer->name }}</span>
                                @else
                                    <span class="text-slate-400 italic">Umum</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <p class="font-bold text-slate-800">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</p>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold uppercase 
                                    {{ $trx->payment_method == 'cash' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $trx->payment_method }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('owner.transactions.show', $trx) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-indigo-600 rounded-lg transition-colors font-medium text-xs">
                                    <i data-lucide="file-text" class="w-3 h-3"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="receipt" class="w-8 h-8 text-slate-300"></i>
                                </div>
                                <p class="font-medium">Belum ada transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
