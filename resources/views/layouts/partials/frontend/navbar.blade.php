{{-- MENU PROFIL (SAMA UNTUK SEMUA) --}}
        @php
            $profileRoute = Auth::user()->role == 'pelanggan' ? 'pelanggan.profil.index' : 'karyawan.profil.index';
            $alamatRoute = Auth::user()->role == 'pelanggan' ? 'pelanggan.alamat' : 'karyawan.alamat';
        @endphp
<nav    
    class="sticky top-0 z-50 bg-white/70 dark:bg-slate-950/70 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 md:h-20">

            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 md:w-10 md:h-10 bg-brand rounded-lg md:rounded-xl flex items-center justify-center shadow-lg shadow-brand/30">
                    <img src="{{ $profil->logo ? asset('logo/' . $profil->logo) : 'https://via.placeholder.com/400x400.png?text=Pilih+Logo' }}"
                        class="w-9 h-9 rounded-lg object-cover shrink-0">
                </div>
                <span
                    class="text-xl md:text-2xl font-black tracking-tighter bg-gradient-to-r from-brand to-indigo-500 bg-clip-text text-transparent">
                    SILAU
                </span>
            </div>

            <div class="hidden md:flex items-center space-x-8">
                @if (Auth::user()->role == 'pelanggan')
                    {{-- Menu Pelanggan --}}
                    <a href="{{ route('pelanggan.dashboard') }}"
                        class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('pelanggan.dashboard') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">Dashboard</a>
                    <a href="{{ route('pelanggan.pesanan') }}"
                        class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('pelanggan.pesanan*') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">Pesanan
                        Saya</a>
                    <a href="{{ route('pelanggan.layanan.index') }}"
                        class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('pelanggan.layanan.index*') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">Layanan</a>
                @elseif(Auth::user()->role == 'karyawan')
                    @php $jabatan = Auth::user()->karyawan->jabatan->nama_jabatan ?? ''; @endphp

                    <a href="{{ route('karyawan.dashboard') }}"
                        class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('karyawan.dashboard') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">Dashboard</a>

                    @if (str_contains(strtolower($jabatan), 'kasir'))
                        {{-- Menu Khusus Kasir --}}
                        <a href=" {{ route('karyawan.kasir.index') }} "
                            class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('karyawan.transaksi*') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">Transaksi</a>
                        <a href="{{-- {{ route('karyawan.pelanggan.index') }} --}}"
                            class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('karyawan.pelanggan*') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">Data
                            Pelanggan</a>
                    @endif

                    @if (str_contains(strtolower($jabatan), 'driver'))
                        {{-- Menu Khusus Driver --}}
                        <a href="{{-- {{ route('karyawan.pickup.index') }} --}}"
                            class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('karyawan.pickup*') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">Penjemputan</a>
                        <a href="{{-- {{ route('karyawan.delivery.index') }} --}}"
                            class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('karyawan.delivery*') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">Pengantaran</a>
                    @endif
                @endif
            </div>

            <div class="flex items-center gap-2 md:gap-3">
                @if (Auth::user()->role == 'pelanggan')
                    <a href="{{ route('pelanggan.layanan.create') }}"
                        class="hidden lg:flex items-center gap-2 bg-brand hover:bg-brandDark text-white px-5 py-2.5 rounded-full font-bold shadow-lg shadow-brand/20 transition-all hover:scale-105 active:scale-95">
                        <span>➕</span> Pesan Sekarang
                    </a>
                @elseif(Auth::user()->role == 'karyawan' &&
                        str_contains(strtolower(Auth::user()->karyawan->jabatan->nama_jabatan ?? ''), 'kasir'))
                    <a href="{{ route('karyawan.kasir.create') }}"
                        class="hidden lg:flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-full font-bold shadow-lg shadow-emerald-500/20 transition-all hover:scale-105 active:scale-95">
                        <span>📝</span> Transaksi Baru
                    </a>
                @endif

                <div class="hidden md:block h-6 w-[1px] bg-slate-200 dark:bg-slate-800 mx-2"></div>

                <div class="flex gap-1">
                    <button
                        @click="if (!document.fullscreenElement) { document.documentElement.requestFullscreen(); isFull = true; } else { document.exitFullscreen(); isFull = false; }"
                        class="p-2 md:p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 transition">
                        <span x-show="!isFull">🔲</span>
                        <span x-show="isFull" x-cloak>🔳</span>
                    </button>

                    <button @click="darkMode = !darkMode"
                        class="p-2 md:p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 transition">
                        <span x-show="!darkMode">🌙</span>
                        <span x-show="darkMode" x-cloak>☀️</span>
                    </button>
                </div>

                <div class="relative" x-data="{ open: false }">
                    <button @click.stop="open = !open" type="button"
                        class="flex items-center gap-2 p-1 md:pl-3 bg-slate-100 dark:bg-slate-800 rounded-full border border-slate-200 dark:border-slate-700 hover:ring-2 ring-brand/20 transition focus:outline-none">
                        <span class="text-xs font-bold hidden md:block">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-brand to-purple-500 shadow-inner">
                        </div>
                    </button>

                    <div x-show="open" x-cloak @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 p-2 z-[60]">

                        <a href="{{ route($profileRoute) }}"
                            class="flex items-center gap-3 p-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-colors">
                            <span>👤</span> Profile Saya
                        </a>

                        <a href="{{ route($alamatRoute) }}"
                            class="flex items-center gap-3 p-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-colors font-bold text-slate-700 dark:text-slate-200">
                            <span>📍</span> Alamat Saya
                        </a>

                        <div class="border-t border-slate-100 dark:border-slate-800 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 p-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl text-red-500 font-medium transition-colors">
                                <span>🚪</span> Keluar
                            </button>
                        </form>
                    </div>
                </div>

                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-slate-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenu" x-cloak stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <div class="relative">
        <div x-show="mobileMenu" x-cloak @click.away="mobileMenu = false"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
            class="md:hidden absolute top-0 left-0 right-0 z-[100] bg-white/95 dark:bg-slate-950/95 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 p-4 shadow-2xl space-y-2">

            <div class="flex flex-col gap-2">
                @if (Auth::user()->role == 'pelanggan')
                    <a href="{{ route('pelanggan.dashboard') }}"
                        class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('pelanggan.dashboard') ? 'bg-brand text-white shadow-lg shadow-brand/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-900' }}">
                        <span class="text-xl">🏠</span>
                        <span class="font-bold">Dashboard</span>
                    </a>
                    <a href="{{ route('pelanggan.pesanan') }}"
                        class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('pelanggan.pesanan*') ? 'bg-brand text-white shadow-lg shadow-brand/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-900' }}">
                        <span class="text-xl">📦</span>
                        <span class="font-bold">Pesanan Saya</span>
                    </a>
                    <a href="{{ route('pelanggan.layanan.index') }}"
                        class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('pelanggan.layanan.index*') ? 'bg-brand text-white shadow-lg shadow-brand/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-900' }}">
                        <span class="text-xl">👔</span>
                        <span class="font-bold">Layanan</span>
                    </a>
                    <a href="{{ route('pelanggan.alamat') }}"
                        class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('pelanggan.alamat*') ? 'bg-brand text-white shadow-lg shadow-brand/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-900' }}">
                        <span class="text-xl">📍</span>
                        <span class="font-bold">Alamat Saya</span>
                    </a>
                @elseif(Auth::user()->role == 'karyawan')
                    @php $jabatan = Auth::user()->karyawan->jabatan->nama_jabatan ?? ''; @endphp
                    <a href="{{ route('karyawan.dashboard') }}"
                        class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('karyawan.dashboard') ? 'bg-brand text-white' : '' }}">
                        <span class="text-xl">📊</span> <span class="font-bold">Dashboard Karyawan</span>
                    </a>

                    @if (str_contains(strtolower($jabatan), 'kasir'))
                        <a href="{{-- {{ route('karyawan.transaksi.index') }} --}}"
                            class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('karyawan.transaksi*') ? 'bg-brand text-white' : '' }}">
                            <span class="text-xl">💰</span> <span class="font-bold">Kasir / Transaksi</span>
                        </a>
                    @endif

                    @if (str_contains(strtolower($jabatan), 'driver'))
                        <a href="{{-- {{ route('karyawan.pickup.index') }} --}}"
                            class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('karyawan.pickup*') ? 'bg-brand text-white' : '' }}">
                            <span class="text-xl">🚚</span> <span class="font-bold">Tugas Kurir</span>
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
