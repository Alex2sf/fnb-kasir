<div class="fixed bottom-6 right-6 z-50 flex items-center gap-3" style="animation: slideInUp 0.6s ease-out forwards;">
    
    <!-- Panduan Alur -->
    <a href="{{ route('guide') }}" 
       class="group flex items-center gap-2 px-4 py-3 bg-white text-slate-800 rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-slate-200">
        <div class="bg-indigo-100 p-1.5 rounded-full group-hover:bg-indigo-200 transition-colors duration-300">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex flex-col items-start leading-none">
            <span class="text-[10px] text-slate-500 font-medium tracking-wider uppercase mb-0.5">Panduan</span>
            <span class="text-sm font-bold tracking-wide">Alur Setup</span>
        </div>
    </a>

    <!-- Follow Instagram -->
    <a href="https://instagram.com/warunggalih.id" target="_blank" 
       class="group flex items-center gap-2 px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full shadow-lg hover:shadow-2xl hover:shadow-indigo-500/30 transform hover:-translate-y-1 transition-all duration-300 border border-white/20 backdrop-blur-sm">
        
        <div class="bg-white/20 p-1.5 rounded-full group-hover:scale-110 transition-transform duration-300">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </div>
        
        <div class="flex flex-col items-start leading-none">
            <span class="text-[10px] text-indigo-100 font-medium tracking-wider uppercase mb-0.5">Butuh Bantuan?</span>
            <span class="text-sm font-bold tracking-wide">Follow <span class="text-yellow-300">@warunggalih.id</span></span>
        </div>
    </a>
</div>

<style>
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
