<!DOCTYPE html>
<html lang="id" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - WarungGalih POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; }
    </style>
</head>
<body class="text-slate-200 overflow-hidden">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="flex-shrink-0 w-64 bg-slate-900 border-r border-slate-800 flex flex-col">
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <div class="flex items-center gap-2 text-indigo-400">
                    <i data-lucide="shield" class="w-6 h-6"></i>
                    <span class="font-bold text-xl tracking-tight">WarungGalih<span class="font-light text-slate-400">Admin</span></span>
                </div>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-indigo-500/10 text-indigo-400 font-semibold">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center gap-3 mb-3 px-2">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-200 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500">Super Admin</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-3 py-2 w-full rounded-lg text-red-400 hover:bg-red-500/10 transition-colors text-left text-sm font-medium">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 bg-slate-950">
            <header class="h-16 bg-slate-900/80 backdrop-blur-md border-b border-slate-800 flex items-center justify-between px-6">
                <h2 class="font-bold text-lg text-slate-100">@yield('title', 'Dashboard')</h2>
            </header>

            <div class="flex-1 overflow-auto p-6 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
    <x-help-follow />
</body>
</html>
