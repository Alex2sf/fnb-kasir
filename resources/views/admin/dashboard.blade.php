@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-black text-slate-100 tracking-tight">Platform Overview</h1>
        <p class="text-slate-400 mt-1 text-sm">Monitoring seluruh aktivitas WarungGalih POS.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 hover:border-slate-700 transition-colors">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400">Total Owner</p>
                    <h3 class="text-3xl font-black text-slate-100 mt-1">{{ $totalOwners }}</h3>
                </div>
                <div class="p-2.5 bg-indigo-500/10 rounded-xl">
                    <i data-lucide="users" class="w-6 h-6 text-indigo-400"></i>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-3">Pemilik toko terdaftar</p>
        </div>

        <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 hover:border-slate-700 transition-colors">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400">Total Transaksi</p>
                    <h3 class="text-3xl font-black text-slate-100 mt-1">{{ $totalTransactions }}</h3>
                </div>
                <div class="p-2.5 bg-emerald-500/10 rounded-xl">
                    <i data-lucide="receipt" class="w-6 h-6 text-emerald-400"></i>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-3">Seluruh platform</p>
        </div>

        <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 hover:border-slate-700 transition-colors">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400">Global Omzet</p>
                    <h3 class="text-3xl font-black text-slate-100 mt-1">Rp {{ number_format($globalOmzet, 0, ',', '.') }}</h3>
                </div>
                <div class="p-2.5 bg-purple-500/10 rounded-xl">
                    <i data-lucide="banknote" class="w-6 h-6 text-purple-400"></i>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-3">Pendapatan semua toko</p>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-emerald-500/10 text-emerald-400 p-4 rounded-xl border border-emerald-500/20 text-sm font-medium mb-4 flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500/10 text-red-400 p-4 rounded-xl border border-red-500/20 text-sm font-medium mb-4 flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Stores List -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden mt-8">
        <div class="p-6 border-b border-slate-800">
            <h2 class="font-bold text-lg text-slate-100">Daftar Toko (Tenant)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-800/50 text-slate-400">
                        <th class="p-4 font-semibold">Toko & Pemilik</th>
                        <th class="p-4 font-semibold">Kontak</th>
                        <th class="p-4 font-semibold text-center">Total Transaksi</th>
                        <th class="p-4 font-semibold text-right">Omzet Toko</th>
                        <th class="p-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($stores as $store)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="p-4">
                                <p class="font-bold text-slate-200">{{ $store->name }}</p>
                                <p class="text-xs text-slate-500">{{ $store->user->name ?? '-' }}</p>
                            </td>
                            <td class="p-4">
                                <p class="text-slate-300">{{ $store->phone ?? '-' }}</p>
                                <p class="text-xs text-slate-500">{{ $store->user->email ?? '-' }}</p>
                            </td>
                            <td class="p-4 text-center text-slate-300">
                                {{ $store->transactions_count }}
                            </td>
                            <td class="p-4 text-right font-medium text-emerald-400">
                                Rp {{ number_format($store->transactions_sum_grand_total ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="p-4 text-center">
                                @if($store->user)
                                <form action="{{ route('admin.users.toggle-status', $store->user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm {{ $store->user->is_active ? 'bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500/30 border border-emerald-500/30' : 'bg-red-500/20 text-red-400 hover:bg-red-500/30 border border-red-500/30' }}" onclick="return confirm('Yakin ingin mengubah status akses login toko ini?')">
                                        @if($store->user->is_active)
                                            <i data-lucide="unlock" class="w-3.5 h-3.5 mr-1.5"></i> Aktif
                                        @else
                                            <i data-lucide="lock" class="w-3.5 h-3.5 mr-1.5"></i> Suspend
                                        @endif
                                    </button>
                                </form>
                                @else
                                    <span class="text-slate-500 text-xs">No User</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">Belum ada toko yang mendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
