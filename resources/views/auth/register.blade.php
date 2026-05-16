<!DOCTYPE html>
<html lang="id" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - WarungGalih POS</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- Left Panel: Branding -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-300 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-indigo-300 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 flex flex-col justify-between p-12 text-white w-full">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center p-2 shadow-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <span class="text-2xl font-black tracking-tight">WarungGalih<span class="font-light opacity-80">POS</span></span>
                </div>
            </div>

            <div class="space-y-6">
                <h1 class="text-4xl font-black leading-tight">Mulai perjalanan <br>bisnis kuliner <br>Anda hari ini.</h1>
                <p class="text-lg text-indigo-200 max-w-md leading-relaxed">Daftar gratis dan nikmati sistem kasir profesional yang akan membantu Anda mengelola toko dengan lebih efisien.</p>
                
                <div class="space-y-4 pt-4">
                    <div class="flex items-center gap-3 text-indigo-100">
                        <div class="w-6 h-6 bg-emerald-400/20 rounded-full flex items-center justify-center flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-300"></i>
                        </div>
                        <span class="text-sm font-medium">Dashboard penjualan real-time</span>
                    </div>
                    <div class="flex items-center gap-3 text-indigo-100">
                        <div class="w-6 h-6 bg-emerald-400/20 rounded-full flex items-center justify-center flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-300"></i>
                        </div>
                        <span class="text-sm font-medium">Sistem kasir POS modern & cepat</span>
                    </div>
                    <div class="flex items-center gap-3 text-indigo-100">
                        <div class="w-6 h-6 bg-emerald-400/20 rounded-full flex items-center justify-center flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-300"></i>
                        </div>
                        <span class="text-sm font-medium">Manajemen produk, pelanggan & laporan</span>
                    </div>
                </div>
            </div>

            <div class="text-indigo-300 text-sm">
                &copy; {{ date('Y') }} WarungGalih POS. All rights reserved.
            </div>
        </div>
    </div>

    <!-- Right Panel: Register Form -->
    <div class="flex-1 flex items-center justify-center p-6 sm:p-8 bg-slate-50">
        <div class="w-full max-w-md space-y-6">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-4">
                <div class="flex items-center justify-center gap-2 mb-2">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center p-2 shadow-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <span class="text-2xl font-black text-slate-800 tracking-tight">WarungGalih<span class="font-light text-indigo-600">POS</span></span>
                </div>
            </div>

            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Buat Akun Baru 🚀</h2>
                <p class="text-slate-500 mt-2">Daftarkan usaha kuliner Anda dan mulai berjualan.</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl border border-red-100 text-sm">
                    <ul class="list-disc list-inside font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Store Name -->
                <div>
                    <label for="store_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Toko / Warung</label>
                    <div class="relative">
                        <i data-lucide="store" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                        <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}" required 
                               class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all text-sm shadow-sm" 
                               placeholder="Contoh: Kedai Kopi Galih">
                    </div>
                </div>

                <!-- Owner Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Pemilik</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all text-sm shadow-sm" 
                               placeholder="Nama lengkap Anda">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                                   class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all text-sm shadow-sm" 
                                   placeholder="nama@email.com">
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">No. WhatsApp</label>
                        <div class="relative">
                            <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required 
                                   class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all text-sm shadow-sm" 
                                   placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input id="password" type="password" name="password" required 
                                   class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all text-sm shadow-sm" 
                                   placeholder="Min. 8 karakter">
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Ulangi Password</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input id="password_confirmation" type="password" name="password_confirmation" required 
                                   class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all text-sm shadow-sm" 
                                   placeholder="Ketik ulang password">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-lg shadow-indigo-200 flex items-center justify-center gap-2 text-sm mt-2">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                    Daftar Sekarang
                </button>
            </form>

            <div class="text-center pt-1">
                <p class="text-sm text-slate-500">Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-bold">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
