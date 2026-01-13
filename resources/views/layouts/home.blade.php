<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    
    <link rel="icon" href="{{ $profil->logo ? asset('logo/' . $profil->logo) : 'https://via.placeholder.com/400x400.png?text=Pilih+Logo' }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { "50": "#eff6ff", "100": "#dbeafe", "200": "#bfdbfe", "300": "#93c5fd", "400": "#60a5fa", "500": "#3b82f6", "600": "#2563eb", "700": "#1d4ed8", "800": "#1e40af", "900": "#1e3a8a" }
                    }
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
    </style>
</head>

<body class="bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors duration-300">

    <div class="flex h-screen overflow-hidden">
        
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 transition-transform duration-300 transform -translate-x-full lg:translate-x-0">
            <div class="flex flex-col h-full">
                <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100 dark:border-slate-700">
                    <img src="{{ $profil->logo ? asset('logo/' . $profil->logo) : 'https://via.placeholder.com/400x400.png?text=Pilih+Logo' }}" class="w-9 h-9 rounded-lg object-cover">
                    <div class="leading-tight">
                        <h1 class="font-bold text-lg tracking-tight text-primary-600 dark:text-primary-400">SILAU</h1>
                        <p class="text-[10px] font-medium uppercase tracking-wider text-slate-400">Laundry System</p>
                    </div>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    @if (Auth::user()->role == 'admin')
                        <div class="text-[11px] font-bold text-slate-400 uppercase px-3 py-2">Dashboard</div>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            <i class="fas fa-tachometer-alt w-5"></i> Dashboard
                        </a>

                        <div class="text-[11px] font-bold text-slate-400 uppercase px-3 py-2 mt-4">Profil Perusahaan</div>
                        <a href="{{ route('admin.profil-perusahaan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->is('admin/profil-perusahaan*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            <i class="fas fa-building w-5"></i> Profil Perusahaan
                        </a>

                        <div class="text-[11px] font-bold text-slate-400 uppercase px-3 py-2 mt-4">Manajemen Data</div>
                        <a href="{{ route('admin.pelanggan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->is('admin/pelanggan*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            <i class="fas fa-users w-5"></i> Pelanggan
                        </a>
                        <a href="{{ route('admin.layanan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->is('admin/layanan*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            <i class="fas fa-concierge-bell w-5"></i> Layanan
                        </a>
                        <a href="{{ route('admin.diskon.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->is('admin/diskon*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            <i class="fas fa-tags w-5"></i> Diskon
                        </a>

                        <div class="text-[11px] font-bold text-slate-400 uppercase px-3 py-2 mt-4">Transaksi & Laporan</div>
                        <a href="{{ route('admin.transaksi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->is('admin/transaksi*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            <i class="fas fa-exchange-alt w-5"></i> Transaksi
                        </a>
                        <a href="{{ route('admin.laporan.index')}}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->is('admin/laporan*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            <i class="fas fa-book w-5"></i> Laporan
                        </a>
                    @else
                        <div class="text-[11px] font-bold text-slate-400 uppercase px-3 py-2 mt-2">Menu Pelanggan</div>
                        <a href="{{ route('pelanggan.profil.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('pelanggan.profil.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            <i class="fas fa-address-card w-5"></i> Profil Saya
                        </a>
                        <a href="{{ route('pelanggan.layanan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->is('pelanggan/layanan*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            <i class="fas fa-concierge-bell w-5"></i> Daftar Layanan
                        </a>
                    @endif
                </nav>

                <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-lg transition">
                            <i class="fas fa-power-off"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="h-16 flex items-center justify-between px-4 lg:px-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-700 sticky top-0 z-40">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-500">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="hidden md:block">
                        <h2 class="text-sm font-medium text-slate-500">Welcome back, <span class="text-slate-900 dark:text-white font-bold">{{ Auth::user()->name }}</span></h2>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-3 px-4 border-r border-slate-200 dark:border-slate-700 mr-2">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-500 uppercase tracking-tighter mt-1">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold shadow-md border-2 border-white dark:border-slate-700">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>

                    <button onclick="toggleFullscreen()" class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 transition-all group" title="Fullscreen">
                        <i class="fas fa-expand-arrows-alt text-lg group-hover:scale-110 transition-transform"></i>
                    </button>

                    <button onclick="toggleDarkMode()" class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 transition-all group" title="Toggle Theme">
                        <i id="theme-icon" class="fas fa-moon text-lg group-hover:rotate-12 transition-transform"></i>
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden backdrop-blur-sm"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // --- Fullscreen Logic ---
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        // --- Dark Mode Logic ---
        const html = document.documentElement;
        const themeIcon = document.getElementById('theme-icon');

        function toggleDarkMode() {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
                themeIcon.className = 'fas fa-moon text-lg';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
                themeIcon.className = 'fas fa-sun text-lg';
            }
        }

        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            themeIcon.className = 'fas fa-sun text-lg';
        }

        // --- Sidebar Logic ---
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }
    </script>
    
    @include('partials.dataTables')
    @include('partials._sweetalert')
</body>
</html>