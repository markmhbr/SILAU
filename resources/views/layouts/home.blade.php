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
        // --- PRE-RENDER LOGIC (Cegah Kedip) ---
        (function() {
            const isMini = localStorage.getItem('sidebar-mini') === 'true';
            const isDark = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isMini && window.innerWidth >= 1024) document.documentElement.classList.add('sidebar-is-mini');
            if (isDark) document.documentElement.classList.add('dark');
        })();

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
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        /* --- MINI SIDEBAR LOGIC --- */
        @media (min-width: 1024px) {
            .sidebar-is-mini #sidebar { width: 80px !important; }
            .sidebar-is-mini #sidebar .sidebar-content-text { display: none !important; }
            
            /* Tetap tampilkan Search Container tapi buat jadi minimalis */
            .sidebar-is-mini #sidebar .search-container { 
                padding-left: 0.5rem !important; 
                padding-right: 0.5rem !important; 
            }
            /* Sembunyikan Input Text saat mini, tampilkan hanya Icon Search */
            .sidebar-is-mini #sidebar #menuSearch { 
                padding-left: 2.25rem !important;
                cursor: pointer;
            }

            .sidebar-is-mini #sidebar .px-6, 
            .sidebar-is-mini #sidebar .px-4, 
            .sidebar-is-mini #sidebar .px-3 { 
                padding-left: 0.75rem !important; 
                padding-right: 0.75rem !important; 
            }
            .sidebar-is-mini #sidebar .menu-link { justify-content: center; }
            .sidebar-is-mini #sidebar .menu-link i { margin: 0 !important; width: 24px; font-size: 1.25rem; }
            .sidebar-is-mini #main-container { margin-left: 80px !important; }
        }

        .ready-transition #sidebar, 
        .ready-transition #main-container { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }
    </style>
</head>

<body class="bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors duration-300">

    <div class="flex h-screen overflow-hidden">
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 transform -translate-x-full lg:translate-x-0">
            <div class="flex flex-col h-full">
                <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100 dark:border-slate-700 overflow-hidden shrink-0">
                    <img src="{{ $profil->logo ? asset('logo/' . $profil->logo) : 'https://via.placeholder.com/400x400.png?text=Pilih+Logo' }}" class="w-9 h-9 rounded-lg object-cover shrink-0">
                    <div class="leading-tight sidebar-content-text">
                        <h1 class="font-bold text-lg tracking-tight text-primary-600 dark:text-primary-400">SILAU</h1>
                        <p class="text-[10px] font-medium uppercase tracking-wider text-slate-400">Laundry System</p>
                    </div>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto relative">
                    <div class="px-3 mb-6 relative search-container">
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-slate-400 text-xs"></i>
                            </span>
                            <input type="text" id="menuSearch" onclick="expandIfMini()" autocomplete="off" 
                                class="block w-full py-2 pl-10 pr-3 text-xs border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:text-white" 
                                placeholder="Cari menu...">
                        </div>
                        <div id="searchResults" class="absolute left-0 right-0 mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl z-[60] hidden max-h-60 overflow-y-auto"></div>
                    </div>

                    @php
                        $menus = [
                            ['role' => 'admin', 'label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'fas fa-tachometer-alt', 'cat' => 'Dashboard'],
                            ['role' => 'admin', 'label' => 'Profil Perusahaan', 'route' => 'admin.profil-perusahaan.index', 'icon' => 'fas fa-building', 'cat' => 'Profil Perusahaan'],
                            ['role' => 'admin', 'label' => 'Pelanggan', 'route' => 'admin.pelanggan.index', 'icon' => 'fas fa-users', 'cat' => 'Manajemen Data'],
                            ['role' => 'admin', 'label' => 'Layanan', 'route' => 'admin.layanan.index', 'icon' => 'fas fa-concierge-bell', 'cat' => 'Manajemen Data'],
                            ['role' => 'admin', 'label' => 'Diskon', 'route' => 'admin.diskon.index', 'icon' => 'fas fa-tags', 'cat' => 'Manajemen Data'],
                            ['role' => 'admin', 'label' => 'Transaksi', 'route' => 'admin.transaksi.index', 'icon' => 'fas fa-exchange-alt', 'cat' => 'Transaksi & Laporan'],
                            ['role' => 'admin', 'label' => 'Laporan', 'route' => 'admin.laporan.index', 'icon' => 'fas fa-book', 'cat' => 'Transaksi & Laporan'],
                        ];
                    @endphp

                    @php $currentCat = ''; @endphp
                    @foreach($menus as $menu)
                        @if(Auth::user()->role == $menu['role'])
                            @if($currentCat != $menu['cat'])
                                <div class="text-[11px] font-bold text-slate-400 uppercase px-3 py-2 mt-4 sidebar-content-text">{{ $menu['cat'] }}</div>
                                @php $currentCat = $menu['cat']; @endphp
                            @endif
                            <a href="{{ route($menu['route']) }}" class="menu-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs($menu['route']) ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                                <i class="{{ $menu['icon'] }} w-5 text-center"></i> 
                                <span class="sidebar-content-text">{{ $menu['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </nav>

                <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-lg transition">
                            <i class="fas fa-power-off w-5 text-center"></i> <span class="sidebar-content-text">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div id="main-container" class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
            <header class="h-16 flex items-center justify-between px-4 lg:px-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-700 sticky top-0 z-40">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-500">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="hidden md:block">
                        <h2 class="text-sm font-medium text-slate-500">Welcome, <span class="text-slate-900 dark:text-white font-bold">{{ Auth::user()->name }}</span></h2>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="toggleDarkMode()" class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300">
                        <i id="theme-icon" class="fas fa-moon text-lg"></i>
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden backdrop-blur-sm"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const html = document.documentElement;

        // Nyalakan transisi setelah load
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => html.classList.add('ready-transition'), 100);
        });

        // Jika user klik search saat mini, buka sidebar otomatis
        function expandIfMini() {
            if (html.classList.contains('sidebar-is-mini')) {
                toggleSidebar();
                document.getElementById('menuSearch').focus();
            }
        }

        function toggleSidebar() {
            if (window.innerWidth >= 1024) {
                html.classList.toggle('sidebar-is-mini');
                localStorage.setItem('sidebar-mini', html.classList.contains('sidebar-is-mini'));
            } else {
                document.getElementById('sidebar').classList.toggle('-translate-x-full');
                document.getElementById('sidebar-overlay').classList.toggle('hidden');
            }
        }

        // --- SEARCH LOGIC (DIPERBAIKI) ---
        document.getElementById('menuSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const resultsDiv = document.getElementById('searchResults');
            const menuLinks = document.querySelectorAll('.menu-link');
            
            resultsDiv.innerHTML = '';
            if (searchTerm.length < 1) {
                resultsDiv.classList.add('hidden');
                return;
            }

            let found = false;
            menuLinks.forEach(link => {
                const text = link.querySelector('.sidebar-content-text').textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    found = true;
                    const icon = link.querySelector('i').className;
                    const resultItem = document.createElement('a');
                    resultItem.href = link.href;
                    resultItem.className = "flex items-center gap-3 px-4 py-3 hover:bg-slate-100 dark:hover:bg-slate-700 border-b border-slate-100 dark:border-slate-700 last:border-0";
                    resultItem.innerHTML = `<i class="${icon} text-primary-500 w-5 text-center"></i><span class="text-xs font-semibold dark:text-white">${link.querySelector('.sidebar-content-text').textContent}</span>`;
                    resultsDiv.appendChild(resultItem);
                }
            });

            if (found) resultsDiv.classList.remove('hidden');
            else {
                resultsDiv.innerHTML = `<div class="p-4 text-xs text-slate-500 text-center">Tidak ditemukan</div>`;
                resultsDiv.classList.remove('hidden');
            }
        });

        // Klik luar tutup hasil search
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-container')) document.getElementById('searchResults').classList.add('hidden');
        });

        function toggleDarkMode() {
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
            document.getElementById('theme-icon').className = isDark ? 'fas fa-sun text-lg' : 'fas fa-moon text-lg';
        }
        
        if (html.classList.contains('dark')) document.getElementById('theme-icon').className = 'fas fa-sun text-lg';
    </script>
</body>
</html>