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

        <!-- Profile Avatar Placeholder in Header -->
        <div class="ml-2 pl-4 border-l border-slate-200 dark:border-slate-700 hidden sm:block">
            <div
                class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 border-2 border-white dark:border-slate-800 shadow-sm flex items-center justify-center overflow-hidden">
                <span
                    class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
        </div>
    </div>
</header>
