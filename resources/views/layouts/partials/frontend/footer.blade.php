<div
    class="md:hidden fixed bottom-0 left-0 right-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-t border-slate-200 dark:border-slate-800 px-6 py-3 z-50">
    <div class="flex justify-between items-center">
        <a href="{{ route('pelanggan.dashboard') }}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs('pelanggan.dashboard') ? 'text-brand' : 'text-slate-400' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>
        <a href="{{ route('pelanggan.pesanan') }}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs('pelanggan.pesanan*') ? 'text-brand' : 'text-slate-400' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <span class="text-[10px] font-bold">Pesanan</span>
        </a>

        <div class="-translate-y-6">
            <a href="{{ route('pelanggan.layanan.create') }}"
                class="w-14 h-14 bg-brand rounded-full flex items-center justify-center text-white shadow-xl shadow-brand/40 border-4 border-[#f8fafc] dark:border-[#020617]">
                <span class="text-2xl">➕</span>
            </a>
        </div>

        <a href="{{ route('pelanggan.layanan.index') }}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs('pelanggan.layanan.index*') ? 'text-brand' : 'text-slate-400' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path>
            </svg>
            <span class="text-[10px] font-bold">Layanan</span>
        </a>
        <a href="{{ route('pelanggan.profil.index') }}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs('pelanggan.profil.*') ? 'text-brand' : 'text-slate-400' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-[10px] font-bold">Profil</span>
        </a>

    </div>
</div>
