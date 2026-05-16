@extends('layouts.owner')

@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('owner.transactions.index') }}" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-colors shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Detail Struk</h1>
        </div>
        <div class="ml-auto">
            <button onclick="window.print()" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-xl font-medium transition-colors shadow-sm text-sm">
                <i data-lucide="printer" class="w-4 h-4"></i>
                Cetak Struk
            </button>
        </div>
    </div>

    <!-- Receipt Format -->
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 print:shadow-none print:border-none print:w-[80mm] print:mx-auto print:p-0">
        <div class="text-center mb-6">
            <h2 class="text-xl font-black text-slate-800">{{ auth()->user()->store->name }}</h2>
            <p class="text-slate-500 text-sm mt-1">{{ auth()->user()->store->address }}</p>
            <div class="border-b-2 border-dashed border-slate-200 mt-4"></div>
        </div>

        <div class="flex justify-between text-sm text-slate-600 mb-2">
            <span>No. Resi</span>
            <span class="font-semibold text-slate-800">{{ $transaction->receipt_number }}</span>
        </div>
        <div class="flex justify-between text-sm text-slate-600 mb-2">
            <span>Waktu</span>
            <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex justify-between text-sm text-slate-600 mb-2">
            <span>Kasir</span>
            <span>{{ $transaction->user->name }}</span>
        </div>
        <div class="flex justify-between text-sm text-slate-600 mb-6">
            <span>Pelanggan</span>
            <span>{{ $transaction->customer ? $transaction->customer->name : 'Umum' }}</span>
        </div>

        <div class="border-b border-dashed border-slate-200 mb-4"></div>

        <div class="space-y-4 mb-4">
            @foreach($transaction->items as $item)
            <div>
                <div class="flex justify-between font-medium text-slate-800">
                    <span>{{ $item->product_name }}</span>
                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                @if($item->toppings && is_array($item->toppings) && count($item->toppings) > 0)
                <div class="text-[11px] font-bold text-slate-400 mt-0.5">
                    + {{ implode(', ', array_column($item->toppings, 'name')) }}
                </div>
                @endif
                <div class="text-sm text-slate-500 mt-0.5">
                    {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>

        <div class="border-b border-dashed border-slate-200 mb-4"></div>

        <div class="space-y-2 mb-4">
            <div class="flex justify-between text-sm text-slate-600">
                <span>Subtotal</span>
                <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm text-slate-600">
                <span>Pajak (11%)</span>
                <span>Rp {{ number_format($transaction->tax_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-black text-lg text-slate-800 pt-2">
                <span>Total</span>
                <span>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="border-b border-dashed border-slate-200 mb-4"></div>

        <div class="space-y-2 mb-8">
            <div class="flex justify-between text-sm text-slate-600">
                <span>Bayar ({{ strtoupper($transaction->payment_method) }})</span>
                <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm font-bold text-slate-800">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="text-center text-sm text-slate-500">
            <p>Terima kasih atas kunjungan Anda!</p>
        </div>
    </div>
</div>
@endsection
