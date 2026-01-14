<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-t border-slate-200 dark:border-slate-800 px-6 py-3 z-50">
    <div class="flex justify-between items-center">
        
        {{-- MENU BERANDA / DASHBOARD --}}
        @php
            $dashboardRoute = Auth::user()->role == 'pelanggan' ? 'pelanggan.dashboard' : 'karyawan.dashboard';
        @endphp
        <a href="{{ route($dashboardRoute) }}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs($dashboardRoute) ? 'text-brand' : 'text-slate-400' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>

        {{-- MENU TENGAH (DINAMIS BERDASARKAN JABATAN) --}}
        @if(Auth::user()->role == 'pelanggan')
            {{-- Bagian Pelanggan --}}
            <a href="{{ route('pelanggan.pesanan') }}"
                class="flex flex-col items-center gap-1 {{ request()->routeIs('pelanggan.pesanan*') ? 'text-brand' : 'text-slate-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <span class="text-[10px] font-bold">Layanan</span>
            </a>

        @elseif(Auth::user()->role == 'karyawan')
            @php $jabatan = strtolower(Auth::user()->karyawan->jabatan->nama_jabatan ?? ''); @endphp

            @if(str_contains($jabatan, 'kasir'))
                {{-- Tampilan Mobile untuk Kasir --}}
                <a href="{{-- {{ route('karyawan.transaksi.index') }} --}}"
                    class="flex flex-col items-center gap-1 {{ request()->routeIs('karyawan.transaksi.index') ? 'text-emerald-500' : 'text-slate-400' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="text-[10px] font-bold">Transaksi</span>
                </a>

                <div class="-translate-y-6">
                    <a href="{{-- {{ route('karyawan.transaksi.create') }} --}}"
                        class="w-14 h-14 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-xl shadow-emerald-500/40 border-4 border-[#f8fafc] dark:border-[#020617]">
                        <span class="text-2xl">📝</span>
                    </a>
                </div>

                <a href="{{-- {{ route('karyawan.pelanggan.index') }} --}}"
                    class="flex flex-col items-center gap-1 {{ request()->routeIs('karyawan.pelanggan.*') ? 'text-emerald-500' : 'text-slate-400' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-[10px] font-bold">Pelanggan</span>
                </a>

            @elseif(str_contains($jabatan, 'driver'))
                {{-- Tampilan Mobile untuk Driver --}}
                <a href="{{-- {{ route('karyawan.pickup.index') }} --}}"
                    class="flex flex-col items-center gap-1 {{ request()->routeIs('karyawan.pickup*') ? 'text-orange-500' : 'text-slate-400' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                    <span class="text-[10px] font-bold">Jemput</span>
                </a>

                <div class="-translate-y-6">
                    <button class="w-14 h-14 bg-orange-500 rounded-full flex items-center justify-center text-white shadow-xl shadow-orange-500/40 border-4 border-[#f8fafc] dark:border-[#020617]">
                        <span class="text-2xl">🚚</span>
                    </button>
                </div>

                <a href="{{-- {{ route('karyawan.delivery.index') }} --}}"
                    class="flex flex-col items-center gap-1 {{ request()->routeIs('karyawan.delivery*') ? 'text-orange-500' : 'text-slate-400' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    <span class="text-[10px] font-bold">Antar</span>
                </a>
            @endif
        @endif

        {{-- MENU PROFIL (SAMA UNTUK SEMUA) --}}
        @php
            $profileRoute = Auth::user()->role == 'pelanggan' ? 'pelanggan.profil.index' : 'karyawan.profil.index';
        @endphp
        <a href="{{-- {{ route($profileRoute) }} --}}"
            class="flex flex-col items-center gap-1 {{ request()->routeIs($profileRoute) ? 'text-brand' : 'text-slate-400' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-[10px] font-bold">Profil</span>
        </a>

    </div>
</div>