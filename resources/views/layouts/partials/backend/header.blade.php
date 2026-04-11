<header
    class="h-20 flex items-center justify-between px-6 lg:px-10 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl border-b border-white/20 dark:border-slate-700/50 sticky top-0 z-40 transition-all shadow-[0_4px_30px_rgba(0,0,0,0.03)]">
    <div class="flex items-center gap-5">
        <button onclick="toggleSidebar()"
            class="p-2.5 rounded-xl bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-500 shadow-sm border border-slate-100 dark:border-slate-700 transition-all hover:scale-105 active:scale-95">
            <i class="fas fa-bars"></i>
        </button>
        <div class="hidden md:block">
            <h2 class="text-sm font-medium text-slate-500 tracking-wide">Welcome back, <span
                    class="text-slate-900 dark:text-white font-black">{{ Auth::user()->name }}</span> 👋</h2>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="toggleFullScreen()"
            class="p-3 rounded-xl bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 shadow-sm border border-slate-100 dark:border-slate-700 transition-all hover:scale-105 active:scale-95 group">
            <i id="fullscreen-icon" class="fas fa-expand text-lg group-hover:text-indigo-500 transition-colors"></i>
        </button>
        <button onclick="toggleDarkMode()"
            class="p-3 rounded-xl bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 shadow-sm border border-slate-100 dark:border-slate-700 transition-all hover:scale-105 active:scale-95 group">
            <i id="theme-icon" class="fas fa-moon text-lg group-hover:text-amber-500 transition-colors"></i>
        </button>

        <!-- Profile Dropdown in Header -->
        <div class="ml-2 pl-4 border-l border-slate-200 dark:border-slate-700 hidden sm:block">
            <div class="relative" x-data="{ open: false }">
                <button @click.stop="open = !open" type="button"
                    class="flex items-center gap-2 p-1 bg-white dark:bg-slate-800 rounded-full border border-slate-200 dark:border-slate-700 hover:ring-2 ring-indigo-500/20 transition focus:outline-none focus:ring-2 focus:ring-indigo-500/20 shadow-sm">
                    @php
                        $user = Auth::user();
                        $fotoUrl = null;
                        if ($user->role == 'pelanggan' && $user->pelanggan) {
                            $fotoUrl = $user->pelanggan->foto_url;
                        } elseif ($user->karyawan) {
                            $fotoUrl = $user->karyawan->foto_url;
                        }
                    @endphp
                    <div
                        class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center overflow-hidden border border-slate-200 dark:border-slate-700">
                        @if ($fotoUrl)
                            <img src="{{ $fotoUrl }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span
                                class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                    </div>
                </button>

                <div x-show="open" x-cloak @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 p-2 z-[60]">

                    {{-- Admin Profil - Optional Placeholder if needed --}}
                    {{-- <a href="#"
                        class="flex items-center gap-3 p-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-colors">
                        <span>👤</span> Profile Saya
                    </a> --}}

                    {{-- Menu Keamanan Akun --}}
                    @php
                        $akunParams = ['role' => Auth::user()->role];
                    @endphp
                    <a href="{{ route('akun', $akunParams) }}"
                        class="flex items-center gap-3 p-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-colors {{ request()->routeIs('akun') ? 'bg-slate-50 dark:bg-slate-800 font-bold text-indigo-500' : 'font-medium text-slate-700 dark:text-slate-200' }}">
                        <span>🔐</span> Ubah Password
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
        </div>
    </div>
</header>
