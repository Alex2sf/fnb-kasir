{{-- Onboarding Tour Component for FNB-Kasir --}}
@props(['tourId' => 'default', 'steps' => [], 'autoStart' => false, 'appName' => 'FNB POS', 'userName' => 'Boss'])

<script>
    window.__tourSteps_{{ str_replace('-', '_', $tourId) }} = {!! json_encode($steps, JSON_UNESCAPED_UNICODE) !!};

function onboardingTour(tourId, steps, autoStart) {
    return {
        tourId, steps, isActive: false, showWelcome: false, showTooltip: false,
        showCelebration: false, currentStep: -1, spotlightStyle: '', tooltipStyle: '', tooltipPosition: 'bottom',
        get totalSteps() { return this.steps.length },
        get isLastStep() { return this.currentStep === this.steps.length - 1 },
        get progressPercent() { return ((this.currentStep + 1) / this.steps.length) * 100 },
        get currentStepData() { return this.steps[this.currentStep] || { title:'', description:'', icon:'', iconBg:'linear-gradient(135deg,#4f46e5,#6366f1)' } },
        init() { if (!localStorage.getItem('tour_completed_' + this.tourId) && autoStart) { this.$nextTick(() => setTimeout(() => { this.showWelcome = true }, 800)) } },
        startTour() { this.showWelcome = false; this.isActive = true; this.currentStep = 0; document.body.style.overflow = 'hidden'; this.$nextTick(() => this.positionElements()) },
        restartTour() { this.showWelcome = true },
        dismissWelcome() { this.showWelcome = false; localStorage.setItem('tour_completed_' + this.tourId, 'true') },
        nextStep() { if (this.isLastStep) { this.completeTour(); return } this.showTooltip = false; setTimeout(() => { this.currentStep++; this.$nextTick(() => this.positionElements()) }, 250) },
        prevStep() { if (this.currentStep <= 0) return; this.showTooltip = false; setTimeout(() => { this.currentStep--; this.$nextTick(() => this.positionElements()) }, 250) },
        goToStep(idx) { this.showTooltip = false; setTimeout(() => { this.currentStep = idx; this.$nextTick(() => this.positionElements()) }, 250) },
        skipTour() { this.cleanup(); localStorage.setItem('tour_completed_' + this.tourId, 'true') },
        completeTour() { this.cleanup(); localStorage.setItem('tour_completed_' + this.tourId, 'true'); this.showCelebration = true },
        closeCelebration() { this.showCelebration = false },
        cleanup() { this.isActive = false; this.showTooltip = false; this.currentStep = -1; document.body.style.overflow = ''; document.querySelectorAll('.tour-target-highlight').forEach(el => el.classList.remove('tour-target-highlight')) },
        positionElements() {
            const step = this.steps[this.currentStep]; if (!step) return;
            const target = document.querySelector(step.target);
            if (!target) { this.spotlightStyle='position:fixed;top:50%;left:50%;width:300px;height:200px;transform:translate(-50%,-50%)'; this.tooltipStyle='position:fixed;top:50%;left:50%;transform:translate(-50%,20px)'; this.tooltipPosition='bottom'; this.showTooltip=true; return }
            target.scrollIntoView({ behavior:'smooth', block:'center', inline:'center' });
            setTimeout(() => {
                const rect = target.getBoundingClientRect(), pad = 12;
                this.spotlightStyle = `position:fixed;top:${rect.top-pad}px;left:${rect.left-pad}px;width:${rect.width+pad*2}px;height:${rect.height+pad*2}px`;
                const tw=380, th=260, m=16, vh=window.innerHeight, vw=window.innerWidth;
                let top, left, pos = step.position || 'auto';
                if (pos==='auto') { pos = vh-rect.bottom>=th+m?'bottom':rect.top>=th+m?'top':vw-rect.right>=tw+m?'right':'bottom' }
                switch(pos) { case'bottom':top=rect.bottom+m;left=rect.left+rect.width/2-tw/2;break;case'top':top=rect.top-th-m;left=rect.left+rect.width/2-tw/2;break;case'right':top=rect.top+rect.height/2-th/2;left=rect.right+m;break;case'left':top=rect.top+rect.height/2-th/2;left=rect.left-tw-m;break }
                left=Math.max(m,Math.min(left,vw-tw-m)); top=Math.max(m,Math.min(top,vh-th-m));
                this.tooltipPosition=pos; this.tooltipStyle=`position:fixed;top:${top}px;left:${left}px;width:${tw}px`; this.showTooltip=true;
                document.querySelectorAll('.tour-target-highlight').forEach(el=>el.classList.remove('tour-target-highlight')); target.classList.add('tour-target-highlight');
            }, 400);
        },
        confettiStyle(i) {
            const c=['#4f46e5','#6366f1','#818cf8','#10b981','#f59e0b','#ef4444','#ec4899','#3b82f6'][i%8];
            return `position:absolute;left:${Math.random()*100}%;top:-10px;width:${6+Math.random()*8}px;height:${6+Math.random()*8}px;background:${c};border-radius:${Math.random()>.5?'50%':'2px'};animation:confettiFall ${2+Math.random()*3}s ${Math.random()*3}s ease-in forwards;transform:rotate(${Math.random()*360}deg)`;
        }
    }
}
</script>

<style>
.tour-backdrop{position:fixed;inset:0;z-index:9990;background:rgba(2,6,23,.78);backdrop-filter:blur(2px);transition:all .4s}
.tour-spotlight{position:fixed;z-index:9991;border-radius:1rem;box-shadow:0 0 0 9999px rgba(2,6,23,.78),0 0 30px rgba(79,70,229,.4),inset 0 0 20px rgba(79,70,229,.1);border:2px solid rgba(79,70,229,.5);transition:all .5s cubic-bezier(.16,1,.3,1);animation:tpulse 2s ease-in-out infinite;pointer-events:none}
@keyframes tpulse{0%,100%{border-color:rgba(79,70,229,.5);box-shadow:0 0 0 9999px rgba(2,6,23,.78),0 0 30px rgba(79,70,229,.3)}50%{border-color:rgba(79,70,229,.9);box-shadow:0 0 0 9999px rgba(2,6,23,.78),0 0 50px rgba(79,70,229,.6)}}
.tour-target-highlight{position:relative;z-index:9992!important;pointer-events:none}
.tour-tooltip{position:fixed;z-index:9995;background:rgba(255,255,255,.97);backdrop-filter:blur(20px);border:1px solid rgba(79,70,229,.12);border-radius:1.25rem;padding:1.25rem;box-shadow:0 25px 60px rgba(0,0,0,.18),0 0 40px rgba(79,70,229,.08);max-width:400px;min-width:320px}
.tour-tooltip::before{content:'';position:absolute;width:14px;height:14px;background:inherit;border:inherit;border-right:0;border-bottom:0;border-radius:3px}
.tour-tooltip-bottom::before{top:-8px;left:50%;transform:translateX(-50%) rotate(45deg)}
.tour-tooltip-top::before{bottom:-8px;left:50%;transform:translateX(-50%) rotate(225deg)}
.tour-tooltip-left::before{right:-8px;top:50%;transform:translateY(-50%) rotate(135deg)}
.tour-tooltip-right::before{left:-8px;top:50%;transform:translateY(-50%) rotate(-45deg)}
.tour-welcome-overlay{position:fixed;inset:0;z-index:9999;background:rgba(2,6,23,.82);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;padding:1.5rem}
.tour-welcome-card{background:#fff;border-radius:2rem;padding:2.5rem;max-width:480px;width:100%;text-align:center;box-shadow:0 40px 100px rgba(0,0,0,.3),0 0 60px rgba(79,70,229,.1);border:1px solid rgba(79,70,229,.1);position:relative;overflow:hidden}
.tour-welcome-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#4f46e5,#6366f1,#818cf8,#a78bfa)}
.tour-celebration-overlay{position:fixed;inset:0;z-index:9999;background:rgba(2,6,23,.85);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;overflow:hidden}
.tour-celebration-card{text-align:center;z-index:10;background:#fff;border-radius:2rem;padding:2.5rem 3rem;box-shadow:0 40px 100px rgba(0,0,0,.3);border:1px solid rgba(79,70,229,.15);max-width:420px;width:calc(100% - 2rem)}
.tour-confetti-container{position:absolute;inset:0;pointer-events:none;overflow:hidden}
@keyframes confettiFall{0%{transform:translateY(-10px) rotate(0);opacity:1}100%{transform:translateY(100vh) rotate(720deg);opacity:0}}
@keyframes tbounce{0%,100%{transform:translateY(0)}50%{transform:translateY(-15px)}}
.tour-help-btn{position:fixed;bottom:1.5rem;right:1.5rem;z-index:9900;width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 25px rgba(79,70,229,.4);transition:all .3s;animation:thpulse 3s ease-in-out infinite}
.tour-help-btn:hover{transform:scale(1.1);box-shadow:0 12px 35px rgba(79,70,229,.5)}
@keyframes thpulse{0%,100%{box-shadow:0 8px 25px rgba(79,70,229,.4)}50%{box-shadow:0 8px 25px rgba(79,70,229,.4),0 0 0 8px rgba(79,70,229,.1)}}
@media(max-width:640px){.tour-tooltip{min-width:unset!important;max-width:calc(100vw - 2rem)!important;left:1rem!important;right:1rem!important;width:auto!important}.tour-welcome-card{padding:1.75rem}}
</style>

<div x-data="onboardingTour('{{ $tourId }}', window.__tourSteps_{{ str_replace('-', '_', $tourId) }}, {{ $autoStart ? 'true' : 'false' }})"
     x-init="init()" x-cloak id="onboarding-tour-{{ $tourId }}">

    <template x-if="isActive">
        <div class="tour-backdrop" x-show="isActive">
            <div class="tour-spotlight" :style="spotlightStyle" x-show="currentStep >= 0"></div>
        </div>
    </template>

    <template x-if="isActive && currentStep >= 0">
        <div class="tour-tooltip" :style="tooltipStyle" :class="'tour-tooltip-' + tooltipPosition"
             x-show="showTooltip" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center gap-3 mb-3">
                <div class="flex-1 h-1 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500" style="background:linear-gradient(90deg,#4f46e5,#6366f1)" :style="'width:'+progressPercent+'%'"></div>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap" x-text="'Step '+(currentStep+1)+' / '+totalSteps"></span>
            </div>
            <div class="flex gap-3 mb-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg shrink-0 shadow-sm" :style="'background:'+currentStepData.iconBg">
                    <span x-html="currentStepData.icon"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-extrabold text-slate-800 mb-0.5" x-text="currentStepData.title"></h4>
                    <p class="text-xs text-slate-500 leading-relaxed" x-text="currentStepData.description"></p>
                </div>
            </div>
            <div class="flex items-center justify-between mb-2">
                <button @click="skipTour()" class="text-[11px] text-slate-400 hover:text-red-500 transition px-2 py-1 rounded" type="button">Lewati</button>
                <div class="flex gap-2">
                    <button @click="prevStep()" x-show="currentStep > 0" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg transition" type="button">← Kembali</button>
                    <button @click="nextStep()" class="inline-flex items-center gap-1 text-xs font-bold text-white px-4 py-1.5 rounded-lg transition shadow-md hover:-translate-y-0.5" style="background:linear-gradient(135deg,#4f46e5,#6366f1);box-shadow:0 4px 15px rgba(79,70,229,.35)" type="button">
                        <span x-text="isLastStep ? '🎉 Selesai!' : 'Lanjut →'"></span>
                    </button>
                </div>
            </div>
            <div class="flex justify-center gap-1">
                <template x-for="(step, idx) in steps" :key="idx">
                    <button @click="goToStep(idx)" class="h-1.5 rounded-full transition-all duration-300 border-0 p-0 cursor-pointer"
                            :class="idx === currentStep ? 'w-5' : 'w-1.5'"
                            :style="idx === currentStep ? 'background:linear-gradient(90deg,#4f46e5,#6366f1)' : (idx < currentStep ? 'background:#10b981' : 'background:#e2e8f0')"
                            type="button"></button>
                </template>
            </div>
        </div>
    </template>

    <template x-if="showWelcome">
        <div class="tour-welcome-overlay" x-show="showWelcome"
             x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="tour-welcome-card" x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 scale-90 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                <div class="flex justify-center mb-5">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-4xl" style="background:linear-gradient(135deg,rgba(79,70,229,.1),rgba(99,102,241,.1));border:2px solid rgba(79,70,229,.15)">🍽️</div>
                </div>
                <h2 class="text-xl font-extrabold text-slate-800 mb-2">
                    Selamat Datang di <span style="background:linear-gradient(135deg,#4f46e5,#6366f1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">{{ $appName }}</span>! 🎉
                </h2>
                <p class="text-sm text-slate-500 leading-relaxed mb-5">
                    Hai <strong>{{ $userName }}</strong>! Yuk kenalan sama semua fitur yang bikin pengelolaan kasir dan restoran kamu makin efisien!
                </p>
                <div class="grid grid-cols-2 gap-2 mb-5">
                    @foreach([['📊','Dashboard Bisnis'],['🖥️','Kasir POS'],['📦','Manajemen Menu'],['💰','Laporan Keuangan']] as [$icon, $label])
                    <div class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-600" style="background:rgba(79,70,229,.05);border:1px solid rgba(79,70,229,.1)">
                        <span class="text-base">{{ $icon }}</span><span>{{ $label }}</span>
                    </div>
                    @endforeach
                </div>
                <button @click="startTour()" class="w-full inline-flex items-center justify-center gap-2 py-3 text-sm font-bold text-white rounded-xl transition hover:-translate-y-0.5" style="background:linear-gradient(135deg,#4f46e5,#6366f1);box-shadow:0 8px 25px rgba(79,70,229,.4)" type="button">
                    ▶ Mulai Tour Interaktif
                </button>
                <button @click="dismissWelcome()" class="mt-2 text-xs text-slate-400 hover:text-slate-600 transition" type="button">Nanti Aja 👋</button>
                <p class="text-[10px] text-slate-400 mt-3">💡 Tour bisa diakses kapan aja lewat tombol <strong>"?"</strong> di pojok bawah</p>
            </div>
        </div>
    </template>

    <button x-show="!isActive && !showWelcome" @click="restartTour()" class="tour-help-btn" title="Mulai Tour" type="button">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </button>

    <template x-if="showCelebration">
        <div class="tour-celebration-overlay" x-show="showCelebration" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="tour-confetti-container"><template x-for="i in 50" :key="i"><div :style="confettiStyle(i)"></div></template></div>
            <div class="tour-celebration-card" x-transition:enter="transition ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100">
                <div class="text-6xl mb-3" style="animation:tbounce 1s ease infinite">🏆</div>
                <h2 class="text-2xl font-extrabold mb-2" style="background:linear-gradient(135deg,#4f46e5,#6366f1,#818cf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Tour Selesai!</h2>
                <p class="text-sm text-slate-500 leading-relaxed mb-5">Mantap! Kamu sudah siap kelola kasir FNB.<br>Semoga laris manis! 🚀</p>
                <button @click="closeCelebration()" class="w-full py-3 text-sm font-bold text-white rounded-xl" style="background:linear-gradient(135deg,#4f46e5,#6366f1);box-shadow:0 8px 25px rgba(79,70,229,.4)" type="button">Mulai Kerja! 💪</button>
            </div>
        </div>
    </template>
</div>
