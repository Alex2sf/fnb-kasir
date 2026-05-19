<!DOCTYPE html>
<html lang="id" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - WarungGalih POS</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .glass-panel { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-slate-800 overflow-hidden" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="flex-shrink-0 w-64 bg-white border-r border-slate-200 transition-all duration-300 z-30" :class="{'hidden md:flex flex-col': !sidebarOpen, 'flex flex-col absolute inset-y-0 left-0 shadow-2xl': sidebarOpen}">
            <div class="h-16 flex items-center px-6 border-b border-slate-100 overflow-hidden">
                <div class="flex items-center gap-2 text-indigo-600">
                    <span class="font-bold text-lg tracking-tight truncate">{{ auth()->user()->store->name ?? 'WarungGalih POS' }}</span>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden ml-auto text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 hide-scrollbar">
                <a href="https://instagram.com/warunggalih.id" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-pink-500 hover:bg-pink-50 hover:text-pink-600 transition-colors font-medium mb-4 shadow-sm border border-pink-100">
                    <i data-lucide="instagram" class="w-5 h-5"></i>
                    @warunggalih.id
                </a>

                <a id="menu-dashboard" href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('owner.dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('owner.dashboard') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                    Dashboard
                </a>
                
                <div class="pt-5 pb-2 px-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Kasir</div>
                
                <a id="menu-pos" href="{{ route('owner.pos') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('owner.pos') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium' }}">
                    <i data-lucide="monitor-smartphone" class="w-5 h-5 {{ request()->routeIs('owner.pos') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                    Point of Sale
                </a>
                <a id="menu-transaksi" href="{{ route('owner.transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('owner.transactions.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium' }}">
                    <i data-lucide="receipt" class="w-5 h-5 {{ request()->routeIs('owner.transactions.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                    Riwayat Transaksi
                </a>

                <div class="pt-5 pb-2 px-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Manajemen Toko</div>
                
                <a id="menu-meja" href="{{ route('owner.tables.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('owner.tables.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium' }}">
                    <i data-lucide="grid-2x2" class="w-5 h-5 {{ request()->routeIs('owner.tables.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                    Manajemen Meja
                </a>

                <a id="menu-diskon" href="{{ route('owner.discounts.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('owner.discounts.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium' }}">
                    <i data-lucide="percent" class="w-5 h-5 {{ request()->routeIs('owner.discounts.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                    Diskon & Promo
                </a>

                <a id="menu-pengeluaran" href="{{ route('owner.expenses.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('owner.expenses.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium' }}">
                    <i data-lucide="wallet" class="w-5 h-5 {{ request()->routeIs('owner.expenses.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                    Pengeluaran
                </a>

                <div class="pt-5 pb-2 px-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Manajemen Menu</div>
                
                <a id="menu-produk" href="{{ route('owner.products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('owner.products.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium' }}">
                    <i data-lucide="coffee" class="w-5 h-5 {{ request()->routeIs('owner.products.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                    Daftar Menu
                </a>
                <a id="menu-kategori" href="{{ route('owner.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('owner.categories.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium' }}">
                    <i data-lucide="tags" class="w-5 h-5 {{ request()->routeIs('owner.categories.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                    Kategori
                </a>
                <a href="{{ route('owner.customers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('owner.customers.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium' }}">
                    <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('owner.customers.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                    Pelanggan
                </a>

                <div class="pt-5 pb-2 px-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Pusat Bantuan</div>
                
                <a id="menu-edukasi" href="{{ route('owner.articles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('owner.articles.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium' }}">
                    <i data-lucide="book-open" class="w-5 h-5 {{ request()->routeIs('owner.articles.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                    Pusat Edukasi
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-red-500 hover:bg-red-50 transition-colors text-left font-medium">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 bg-slate-50">
            <!-- Topbar -->
            <header class="h-16 bg-white/70 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-20">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="md:hidden text-slate-500 hover:text-slate-700">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <div class="hidden sm:flex items-center gap-2 bg-white rounded-full border border-slate-200 px-4 py-2 focus-within:ring-2 focus-within:ring-indigo-100 focus-within:border-indigo-300 transition-all shadow-sm">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                        <input type="text" placeholder="Cari transaksi, produk..." class="bg-transparent border-none focus:ring-0 text-sm w-64 text-slate-700 placeholder-slate-400 p-0">
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Tour Button -->
                    <button onclick="startDashboardTour()" class="relative p-2 text-indigo-500 hover:text-indigo-700 transition-colors rounded-full hover:bg-indigo-50" title="Mulai Panduan Tour">
                        <i data-lucide="info" class="w-5 h-5"></i>
                    </button>
                    
                    <button class="relative p-2 text-slate-400 hover:text-slate-600 transition-colors rounded-full hover:bg-slate-100">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    
                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200 cursor-pointer">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-slate-700 leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 font-medium">{{ auth()->user()->store->name ?? 'Setup Toko' }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold shadow-md">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-auto p-4 sm:p-6 lg:p-8">
                @yield('content')
            </div>
        </main>
        
        <!-- Backdrop Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-20 md:hidden" style="display: none;"></div>
    </div>

    <script>
        lucide.createIcons();

        function startDashboardTour() {
            if (typeof window.driver !== 'undefined') {
                const driverObj = window.driver.js.driver({
                    showProgress: true,
                    steps: [
                        { popover: { title: 'Selamat Datang!', description: 'Mari kita jelajahi fitur-fitur yang ada di sistem kasir Anda.', align: 'center' }},
                        { element: '#menu-dashboard', popover: { title: 'Dashboard', description: 'Lihat ringkasan performa penjualan dan statistik toko Anda di sini.', side: "right", align: 'start' }},
                        { element: '#menu-pos', popover: { title: 'Kasir / POS', description: 'Gunakan menu ini untuk melayani pembeli dan mencatat pesanan.', side: "right", align: 'start' }},
                        { element: '#menu-transaksi', popover: { title: 'Riwayat Transaksi', description: 'Semua riwayat penjualan akan tercatat otomatis di menu ini.', side: "right", align: 'start' }},
                        { element: '#menu-produk', popover: { title: 'Kelola Produk', description: 'Kelola daftar barang dagangan, stok, dan harga jual di sini.', side: "right", align: 'start' }},
                        { element: '#menu-kategori', popover: { title: 'Kategori Produk', description: 'Kelompokkan barang dagangan agar lebih rapi saat di kasir.', side: "right", align: 'start' }}
                    ],
                    nextBtnText: 'Lanjut',
                    prevBtnText: 'Kembali',
                    doneBtnText: 'Selesai',
                });
                driverObj.drive();
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
