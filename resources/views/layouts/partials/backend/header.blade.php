<header
    class="h-16 flex items-center justify-between px-4 lg:px-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-700 sticky top-0 z-40">
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()"
            class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-500">
            <i class="fas fa-bars"></i>
        </button>
        <div class="hidden md:block">
            <h2 class="text-sm font-medium text-slate-500">Welcome, <span
                    class="text-slate-900 dark:text-white font-bold">{{ Auth::user()->name }}</span></h2>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="toggleFullScreen()"
            class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300">
            <i id="fullscreen-icon" class="fas fa-expand text-lg"></i>
        </button>
        <button onclick="toggleDarkMode()"
            class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300">
            <i id="theme-icon" class="fas fa-moon text-lg"></i>
        </button>
    </div>
</header>
