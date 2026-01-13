<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: false, isFull: false, mobileMenu: false }" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleanFlow Premium Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: '#0ea5e9',
                        brandDark: '#0284c7',
                    }
                }
            }
        }
    </script>
    <style>
        /* Pastikan x-cloak ada di CSS */
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        /* --- ANIMASI GLOBAL UNTUK HALAMAN --- */
        @keyframes pageIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-page {
            animation: pageIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Efek halus saat transisi dark mode */
        .transition-all-custom {
            transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease;
        }
    </style>
</head>

<body
    class="bg-[#f8fafc] dark:bg-[#020617] text-slate-900 dark:text-slate-100 transition-colors duration-500 pb-20 md:pb-0">

    <nav
        class="sticky top-0 z-50 bg-white/70 dark:bg-slate-950/70 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 md:h-20">

                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 bg-brand rounded-lg md:rounded-xl flex items-center justify-center shadow-lg shadow-brand/30">
                        <span class="text-white text-lg md:text-xl">✨</span>
                    </div>
                    <span
                        class="text-xl md:text-2xl font-black tracking-tighter bg-gradient-to-r from-brand to-indigo-500 bg-clip-text text-transparent">
                        CLEANFLOW.
                    </span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('pelanggan.dashboard') }}"
                        class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('pelanggan.dashboard') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('pelanggan.pesanan') }}"
                        class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('pelanggan.pesanan*') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">
                        Pesanan Saya
                    </a>
                    <a href="{{ route('pelanggan.layanan.index') }}"
                        class="text-sm transition-all pb-1 px-1 {{ request()->routeIs('pelanggan.layanan.index*') ? 'font-black border-b-2 border-brand text-brand' : 'font-medium text-slate-500 dark:text-slate-400 hover:text-brand' }}">
                        Layanan
                    </a>
                </div>

                <div class="flex items-center gap-2 md:gap-3">
                    <a href="{{ route('pelanggan.layanan.create') }}"
                        class="hidden lg:flex items-center gap-2 bg-brand hover:bg-brandDark text-white px-5 py-2.5 rounded-full font-bold shadow-lg shadow-brand/20 transition-all hover:scale-105 active:scale-95">
                        <span>➕</span> Pesan Sekarang
                    </a>

                    <div class="hidden md:block h-6 w-[1px] bg-slate-200 dark:bg-slate-800 mx-2"></div>

                    <div class="flex gap-1">
                        <button @click="darkMode = !darkMode"
                            class="p-2 md:p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 transition">
                            <span x-show="!darkMode">🌙</span>
                            <span x-show="darkMode" x-cloak>☀️</span>
                        </button>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click.stop="open = !open" type="button"
                            class="flex items-center gap-2 p-1 md:pl-3 bg-slate-100 dark:bg-slate-800 rounded-full border border-slate-200 dark:border-slate-700 hover:ring-2 ring-brand/20 transition focus:outline-none">
                            <span
                                class="text-xs font-bold hidden md:block">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-brand to-purple-500 shadow-inner">
                            </div>
                        </button>

                        <div x-show="open" x-cloak @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 p-2 z-[60]">

                            <a href="{{ route('pelanggan.profil.index') }}"
                                class="flex items-center gap-3 p-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-colors">
                                <span>👤</span> Profile Saya
                            </a>

                            <a href="{{ route('pelanggan.alamat') }}"
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

        </nav>

<div class="relative">
    <div x-show="mobileMenu" 
        x-cloak
        @click.away="mobileMenu = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden absolute top-0 left-0 right-0 z-[100] bg-white/95 dark:bg-slate-950/95 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 p-4 shadow-2xl space-y-2">
        
        <div class="flex flex-col gap-2">
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
        </div>
    </div>
</div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10 animate-page">
        @yield('pelanggan')
    </main>

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

</body>

</html>
