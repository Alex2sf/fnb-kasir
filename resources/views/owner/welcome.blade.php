<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - WarungGalih POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex flex-col justify-center items-center p-6 relative overflow-hidden">

    <!-- Decorative background elements -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden relative z-10 text-center">
        <!-- Banner Image / Illustration -->
        <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center relative overflow-hidden">
            <svg class="w-24 h-24 text-white/20 absolute -right-4 -bottom-4 transform rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center shadow-lg transform -rotate-6">
                <span class="text-4xl">🏪</span>
            </div>
        </div>

        <div class="p-8 sm:p-10">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-4">Halo, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-slate-500 mb-8 text-lg leading-relaxed">
                Selamat datang di <span class="font-bold text-indigo-600">WarungGalih POS</span>. <br>
                Langkah pertama untuk memulai perjalanan suksesmu adalah dengan menyiapkan detail tokomu.
            </p>

            <a href="{{ route('owner.onboarding') }}" class="inline-flex items-center justify-center gap-3 w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-1">
                <span>Setup Toko Sekarang</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>

            <div class="mt-8 flex items-center justify-center gap-2">
                <span class="text-sm text-slate-400">Butuh bantuan?</span>
                <a href="https://instagram.com/warunggalih" target="_blank" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Follow @warunggalih</a>
            </div>
        </div>
    </div>

    <!-- Logout option -->
    <div class="mt-8 relative z-10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-slate-500 hover:text-slate-800 font-medium transition-colors">
                Keluar / Logout
            </button>
        </form>
    </div>

</body>
</html>
