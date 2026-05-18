<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alur Penggunaan - WarungGalih POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        
        .timeline-container { position: relative; }
        .timeline-container::before {
            content: ''; position: absolute; top: 0; bottom: 0; left: 24px; width: 4px;
            background: linear-gradient(to bottom, #6366f1, #a855f7, #ec4899);
            border-radius: 4px;
        }
        
        @keyframes fadeSlide {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .step-item { animation: fadeSlide 0.6s ease forwards; opacity: 0; }
        .step-1 { animation-delay: 0.1s; }
        .step-2 { animation-delay: 0.3s; }
        .step-3 { animation-delay: 0.5s; }
        .step-4 { animation-delay: 0.7s; }
    </style>
</head>
<body class="min-h-screen text-slate-800">

    <div class="max-w-3xl mx-auto px-6 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-4">
                Panduan & Alur Sistem
            </h1>
            <p class="text-slate-500 text-lg">Ikuti 4 langkah mudah ini untuk mulai menggunakan WarungGalih POS.</p>
        </div>

        <div class="timeline-container pl-12 pr-4 space-y-10">
            
            <!-- Step 1 -->
            <div class="step-item step-1 relative">
                <div class="absolute -left-[54px] top-1 w-12 h-12 bg-white rounded-full border-4 border-indigo-500 flex items-center justify-center shadow-lg shadow-indigo-200 z-10">
                    <span class="text-indigo-600 font-bold text-lg">1</span>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">Register & Setup Toko</h2>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        Langkah pertama adalah membuat akun dan mengisi informasi dasar tokomu (Nama Toko, Logo, dll). Sistem akan otomatis membuatkan dashboard khusus untuk usahamu.
                    </p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="step-item step-2 relative">
                <div class="absolute -left-[54px] top-1 w-12 h-12 bg-white rounded-full border-4 border-purple-500 flex items-center justify-center shadow-lg shadow-purple-200 z-10">
                    <span class="text-purple-600 font-bold text-lg">2</span>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 bg-purple-100 rounded-lg text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">Membuat Kategori Menu</h2>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        Sebelum menambahkan makanan/minuman, kelompokkan dulu jenis jualanmu. Masuk ke menu <strong>Manajemen Menu > Kategori</strong>, lalu buat kategori seperti: <em>Makanan Berat, Snack, Minuman Dingin</em>, dll.
                    </p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="step-item step-3 relative">
                <div class="absolute -left-[54px] top-1 w-12 h-12 bg-white rounded-full border-4 border-pink-500 flex items-center justify-center shadow-lg shadow-pink-200 z-10">
                    <span class="text-pink-600 font-bold text-lg">3</span>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 bg-pink-100 rounded-lg text-pink-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">Mengisi Menu Makanan</h2>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        Setelah kategori siap, masuk ke menu <strong>Daftar Menu</strong>. Tambahkan produk/menu andalan tokomu lengkap dengan gambar, harga jual, dan stok awal. Jangan lupa hubungkan dengan Kategori yang sudah dibuat di langkah 2!
                    </p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="step-item step-4 relative">
                <div class="absolute -left-[54px] top-1 w-12 h-12 bg-white rounded-full border-4 border-emerald-500 flex items-center justify-center shadow-lg shadow-emerald-200 z-10">
                    <span class="text-emerald-600 font-bold text-lg">4</span>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">Mulai Transaksi (POS)</h2>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        Semuanya sudah siap! Buka menu <strong>Point of Sale (POS)</strong>. Pilih menu yang dipesan pelanggan, hitung totalnya, terima pembayaran, dan cetak struknya. Semua penjualan akan otomatis masuk ke laporan Dashboard.
                    </p>
                </div>
            </div>
            
        </div>

        <div class="mt-12 text-center">
            <a href="javascript:history.back()" class="inline-flex items-center justify-center px-8 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-50 hover:shadow-md transition-all">
                ← Kembali
            </a>
        </div>
    </div>
</body>
</html>
