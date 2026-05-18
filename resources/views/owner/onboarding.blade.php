<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Toko - WarungGalih POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-20px)} }
        @keyframes slideUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeIn { from{opacity:0} to{opacity:1} }
        .step-card { animation: slideUp 0.5s ease forwards; }
        .blob1 { animation: float 8s ease-in-out infinite; }
        .blob2 { animation: float 10s ease-in-out infinite reverse; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 relative overflow-hidden">

    {{-- Background blobs --}}
    <div class="blob1 absolute top-[-100px] right-[-100px] w-[500px] h-[500px] rounded-full opacity-20 blur-3xl bg-purple-500 pointer-events-none"></div>
    <div class="blob2 absolute bottom-[-100px] left-[-100px] w-[400px] h-[400px] rounded-full opacity-15 blur-3xl bg-blue-500 pointer-events-none"></div>

    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center p-6">

        {{-- Header brand --}}
        <div class="text-center mb-8" style="animation: fadeIn 0.6s ease;">
            <p class="text-indigo-300 text-sm font-semibold tracking-widest uppercase mb-2">WarungGalih POS</p>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">
                Selamat Datang! 👋
            </h1>
            <p class="text-indigo-200 mt-3 text-lg">Yuk, setup toko kamu dalam <span class="text-yellow-300 font-bold">60 detik</span></p>
        </div>

        {{-- Step indicators --}}
        <div class="flex items-center gap-3 mb-8" id="step-indicators">
            <div class="step-dot flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-indigo-500 text-white text-sm font-bold flex items-center justify-center shadow-lg shadow-indigo-500/40" id="dot-1">1</div>
                <span class="text-indigo-200 text-sm font-medium hidden sm:block">Info Toko</span>
            </div>
            <div class="w-8 h-px bg-indigo-500/40"></div>
            <div class="step-dot flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-white/10 text-white/40 text-sm font-bold flex items-center justify-center" id="dot-2">2</div>
                <span class="text-white/40 text-sm font-medium hidden sm:block">Logo & Kontak</span>
            </div>
            <div class="w-8 h-px bg-white/10"></div>
            <div class="step-dot flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-white/10 text-white/40 text-sm font-bold flex items-center justify-center" id="dot-3">3</div>
                <span class="text-white/40 text-sm font-medium hidden sm:block">Siap!</span>
            </div>
        </div>

        {{-- Card container --}}
        <div class="w-full max-w-lg">

            <form method="POST" action="{{ route('owner.onboarding.store') }}" enctype="multipart/form-data" id="onboarding-form">
                @csrf

                {{-- ===== STEP 1: Nama Toko ===== --}}
                <div class="step-card bg-white/10 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl" id="step-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Apa nama toko kamu?</h2>
                            <p class="text-indigo-300 text-sm">Nama ini akan muncul di struk dan dashboard.</p>
                        </div>
                    </div>

                    @if($errors->any())
                    <div class="mb-4 p-4 rounded-xl bg-red-500/20 border border-red-400/30 text-red-300 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-indigo-200 mb-2">Nama Toko / Warung <span class="text-red-400">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   placeholder="Contoh: Warung Mak Siti, Kopi Santai..."
                                   class="w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/40 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 transition-all text-sm font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-indigo-200 mb-2">Jenis Bisnis</label>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach([['☕','Kafe'],['🍜','Resto'],['🥤','Minuman'],['🍕','Fast Food'],['🍰','Bakery'],['🛒','Lainnya']] as $type)
                                <label class="cursor-pointer">
                                    <input type="radio" name="business_type" value="{{ $type[1] }}" class="sr-only peer">
                                    <div class="py-2.5 px-2 rounded-xl border border-white/10 bg-white/5 text-center text-xs font-medium text-white/60 peer-checked:border-indigo-400 peer-checked:bg-indigo-500/20 peer-checked:text-white transition-all hover:bg-white/10">
                                        <span class="text-lg block mb-1">{{ $type[0] }}</span>
                                        {{ $type[1] }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="goToStep(2)"
                            class="mt-6 w-full py-3.5 rounded-xl font-bold text-white text-sm tracking-wide transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-indigo-500/30"
                            style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        Lanjutkan →
                    </button>
                </div>

                {{-- ===== STEP 2: Logo & Kontak ===== --}}
                <div class="step-card bg-white/10 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl hidden" id="step-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-purple-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Logo & Kontak</h2>
                            <p class="text-purple-300 text-sm">Opsional tapi bikin tokomu makin profesional!</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Logo upload --}}
                        <div>
                            <label class="block text-sm font-semibold text-indigo-200 mb-2">Logo Toko</label>
                            <label for="logo-upload" class="cursor-pointer flex flex-col items-center gap-3 p-6 rounded-xl border-2 border-dashed border-white/20 hover:border-indigo-400/50 hover:bg-white/5 transition-all" id="logo-dropzone">
                                <div id="logo-preview-wrapper" class="hidden">
                                    <img id="logo-preview" src="" alt="Preview" class="w-20 h-20 rounded-xl object-cover shadow-lg">
                                </div>
                                <div id="logo-placeholder" class="flex flex-col items-center gap-2">
                                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    </div>
                                    <span class="text-white/50 text-xs">Klik untuk upload logo (PNG/JPG)</span>
                                </div>
                                <input type="file" id="logo-upload" name="logo" accept="image/*" class="sr-only"
                                       onchange="previewLogo(this)">
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-indigo-200 mb-2">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   placeholder="08xxxxxxxxxx"
                                   class="w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/40 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 transition-all text-sm font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-indigo-200 mb-2">Alamat Toko</label>
                            <textarea name="address" rows="2"
                                      placeholder="Jl. Merdeka No. 1, Jakarta..."
                                      class="w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/40 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 transition-all text-sm font-medium resize-none">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="button" onclick="goToStep(1)"
                                class="flex-1 py-3.5 rounded-xl font-semibold text-white/60 text-sm bg-white/5 border border-white/10 hover:bg-white/10 transition-all">
                            ← Kembali
                        </button>
                        <button type="button" onclick="goToStep(3)"
                                class="flex-1 py-3.5 rounded-xl font-bold text-white text-sm tracking-wide transition-all duration-300 hover:-translate-y-0.5"
                                style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                            Lanjutkan →
                        </button>
                    </div>
                </div>

                {{-- ===== STEP 3: Konfirmasi ===== --}}
                <div class="step-card bg-white/10 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl hidden text-center" id="step-3">
                    <div class="text-6xl mb-4">🎉</div>
                    <h2 class="text-2xl font-extrabold text-white mb-2">Toko kamu siap!</h2>
                    <p class="text-indigo-200 text-sm mb-6">Yuk mulai tambahkan menu dan langsung kasir-an!</p>

                    <div class="bg-white/5 rounded-2xl p-4 mb-6 text-left space-y-3 border border-white/10">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-white/80 text-sm">Setelah ini, tambahkan <span class="text-yellow-300 font-semibold">menu/produk</span> lewat menu "Daftar Menu"</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-white/80 text-sm">Buka <span class="text-yellow-300 font-semibold">Point of Sale</span> untuk mulai transaksi kasir</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-white/80 text-sm">Pantau omzet & laporan di <span class="text-yellow-300 font-semibold">Dashboard</span></p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="goToStep(2)"
                                class="flex-1 py-3.5 rounded-xl font-semibold text-white/60 text-sm bg-white/5 border border-white/10 hover:bg-white/10 transition-all">
                            ← Kembali
                        </button>
                        <button type="submit"
                                class="flex-1 py-3.5 rounded-xl font-bold text-white text-sm tracking-wide transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-green-500/30"
                                style="background: linear-gradient(135deg, #10b981, #059669);">
                            🚀 Mulai Sekarang!
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <p class="mt-6 text-white/30 text-xs">Dibuat dengan ❤️ untuk UMKM Indonesia</p>
    </div>

    <script>
        function goToStep(step) {
            document.querySelectorAll('[id^="step-"]').forEach(el => el.classList.add('hidden'));
            document.getElementById('step-' + step).classList.remove('hidden');

            // Update dots
            for (let i = 1; i <= 3; i++) {
                const dot = document.getElementById('dot-' + i);
                if (i < step) {
                    dot.className = 'w-8 h-8 rounded-full bg-green-500 text-white text-sm font-bold flex items-center justify-center shadow-lg shadow-green-500/40';
                    dot.innerHTML = '✓';
                } else if (i === step) {
                    dot.className = 'w-8 h-8 rounded-full bg-indigo-500 text-white text-sm font-bold flex items-center justify-center shadow-lg shadow-indigo-500/40';
                    dot.innerHTML = i;
                } else {
                    dot.className = 'w-8 h-8 rounded-full bg-white/10 text-white/40 text-sm font-bold flex items-center justify-center';
                    dot.innerHTML = i;
                }
            }

            // Validate step 1 name before going forward
            if (step === 2) {
                const name = document.querySelector('[name="name"]').value.trim();
                if (!name) {
                    document.querySelector('[name="name"]').focus();
                    document.querySelector('[name="name"]').style.borderColor = '#f87171';
                    goToStep(1);
                    return;
                }
            }
        }

        function previewLogo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('logo-preview').src = e.target.result;
                    document.getElementById('logo-preview-wrapper').classList.remove('hidden');
                    document.getElementById('logo-placeholder').classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
