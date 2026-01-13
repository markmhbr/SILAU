<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 transform -translate-x-full lg:translate-x-0">
    <div class="flex flex-col h-full">
        <div
            class="flex items-center gap-3 px-6 py-5 border-b border-slate-100 dark:border-slate-700 overflow-hidden shrink-0">
            <img src="{{ $profil->logo ? asset('logo/' . $profil->logo) : 'https://via.placeholder.com/400x400.png?text=Pilih+Logo' }}"
                class="w-9 h-9 rounded-lg object-cover shrink-0">
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
                <div id="searchResults"
                    class="absolute left-0 right-0 mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl z-[60] hidden max-h-60 overflow-y-auto">
                </div>
            </div>

            @php
                $menus = [
                    [
                        'role' => 'admin',
                        'label' => 'Dashboard',
                        'route' => 'admin.dashboard',
                        'icon' => 'fas fa-tachometer-alt',
                        'cat' => 'Dashboard',
                    ],
                    [
                        'role' => 'admin',
                        'label' => 'Profil Perusahaan',
                        'route' => 'admin.profil-perusahaan.index',
                        'icon' => 'fas fa-building',
                        'cat' => 'Profil Perusahaan',
                    ],
                    [
                        'role' => 'admin',
                        'label' => 'Jabatan',
                        'route' => 'admin.jabatan.index',
                        'icon' => 'fas fa-users-cog',
                        'cat' => 'Manajemen Data',
                    ],
                    [
                        'role' => 'admin',
                        'label' => 'Karyawan',
                        'route' => 'admin.karyawan.index',
                        'icon' => 'fas fa-user-tie',
                        'cat' => 'Manajemen Data',
                    ],
                    [
                        'role' => 'admin',
                        'label' => 'Pelanggan',
                        'route' => 'admin.pelanggan.index',
                        'icon' => 'fas fa-users',
                        'cat' => 'Manajemen Data',
                    ],
                    [
                        'role' => 'admin',
                        'label' => 'Layanan',
                        'route' => 'admin.layanan.index',
                        'icon' => 'fas fa-concierge-bell',
                        'cat' => 'Manajemen Data',
                    ],
                    [
                        'role' => 'admin',
                        'label' => 'Diskon',
                        'route' => 'admin.diskon.index',
                        'icon' => 'fas fa-tags',
                        'cat' => 'Manajemen Data',
                    ],
                    [
                        'role' => 'admin',
                        'label' => 'Transaksi',
                        'route' => 'admin.transaksi.index',
                        'icon' => 'fas fa-exchange-alt',
                        'cat' => 'Transaksi & Laporan',
                    ],
                    [
                        'role' => 'admin',
                        'label' => 'Laporan',
                        'route' => 'admin.laporan.index',
                        'icon' => 'fas fa-book',
                        'cat' => 'Transaksi & Laporan',
                    ],
                ];
            @endphp

            @php $currentCat = ''; @endphp
            @foreach ($menus as $menu)
                @if (Auth::user()->role == $menu['role'])
                    @if ($currentCat != $menu['cat'])
                        <div class="text-[11px] font-bold text-slate-400 uppercase px-3 py-2 mt-4 sidebar-content-text">
                            {{ $menu['cat'] }}</div>
                        @php $currentCat = $menu['cat']; @endphp
                    @endif
                    <a href="{{ route($menu['route']) }}"
                        class="menu-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs($menu['route']) ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                        <i class="{{ $menu['icon'] }} w-5 text-center"></i>
                        <span class="sidebar-content-text">{{ $menu['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </nav>

        <div class="p-4 border-t border-slate-200 dark:border-slate-700">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-lg transition">
                    <i class="fas fa-power-off w-5 text-center"></i> <span class="sidebar-content-text">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
