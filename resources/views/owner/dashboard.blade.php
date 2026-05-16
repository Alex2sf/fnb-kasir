@extends('layouts.owner')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard Overview</h1>
            <p class="text-slate-500 mt-1 text-sm">Pantau performa bisnis <span class="font-semibold text-indigo-600">{{ $store->name }}</span> hari ini.</p>
        </div>
        <div>
            <a href="{{ route('owner.pos') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm shadow-indigo-200">
                <i data-lucide="monitor-play" class="w-5 h-5"></i>
                Buka Kasir POS
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 bg-indigo-50 w-24 h-24 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Penjualan</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
                </div>
                <div class="p-2.5 bg-indigo-50 rounded-xl">
                    <i data-lucide="banknote" class="w-6 h-6 text-indigo-600"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative">
                <span class="text-emerald-500 font-medium flex items-center"><i data-lucide="trending-up" class="w-4 h-4 mr-1"></i> +12.5%</span>
                <span class="text-slate-400 ml-2">dari kemarin</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 bg-blue-50 w-24 h-24 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalTransactions }}</h3>
                </div>
                <div class="p-2.5 bg-blue-50 rounded-xl">
                    <i data-lucide="receipt" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative">
                <span class="text-emerald-500 font-medium flex items-center"><i data-lucide="trending-up" class="w-4 h-4 mr-1"></i> +5.2%</span>
                <span class="text-slate-400 ml-2">dari kemarin</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 bg-orange-50 w-24 h-24 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Produk</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalProducts }}</h3>
                </div>
                <div class="p-2.5 bg-orange-50 rounded-xl">
                    <i data-lucide="package" class="w-6 h-6 text-orange-600"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative">
                <span class="text-slate-500 font-medium flex items-center">Aktif dijual</span>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 bg-emerald-50 w-24 h-24 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pelanggan Aktif</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">0</h3>
                </div>
                <div class="p-2.5 bg-emerald-50 rounded-xl">
                    <i data-lucide="users" class="w-6 h-6 text-emerald-600"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative">
                <span class="text-slate-400">Total member</span>
            </div>
        </div>
    </div>
    
    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-slate-800 text-lg">Grafik Pendapatan</h3>
                <select class="text-sm border-slate-200 rounded-lg text-slate-600 focus:ring-indigo-500 focus:border-indigo-500">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                </select>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-slate-800 text-lg">Transaksi Terbaru</h3>
                <button class="text-indigo-600 text-sm font-medium hover:text-indigo-700">Lihat Semua</button>
            </div>
            
            <div class="space-y-4 flex-1">
                @forelse($recentTransactions as $trx)
                    <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-xl transition-colors cursor-pointer border border-transparent hover:border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                {{ substr($trx->customer->name ?? 'G', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-800 text-sm">{{ $trx->receipt_number }}</p>
                                <p class="text-xs text-slate-500">{{ $trx->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="font-bold text-indigo-600 text-sm">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-full text-center py-8 text-slate-400">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                            <i data-lucide="receipt" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <p class="text-sm font-medium text-slate-600">Belum ada transaksi</p>
                        <p class="text-xs mt-1">Transaksi pertama Anda akan muncul di sini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Gradient for chart
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');   
        gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Pendapatan',
                    data: [1200000, 1900000, 1500000, 2200000, 1800000, 2800000, 3200000],
                    borderColor: '#4f46e5',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 13, family: 'Inter' },
                        bodyFont: { size: 14, family: 'Inter', weight: 'bold' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                        ticks: {
                            font: { family: 'Inter', size: 12 },
                            color: '#64748b',
                            callback: function(value) {
                                if (value >= 1000000) return (value / 1000000) + 'M';
                                if (value >= 1000) return (value / 1000) + 'k';
                                return value;
                            }
                        }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { family: 'Inter', size: 12 }, color: '#64748b' }
                    }
                }
            }
        });
    });
</script>
@endpush
