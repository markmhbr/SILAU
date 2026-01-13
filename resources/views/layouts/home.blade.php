<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>

    <link rel="icon"
        href="{{ $profil->logo ? asset('logo/' . $profil->logo) : 'https://via.placeholder.com/400x400.png?text=Pilih+Logo' }}"
        type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        // --- PRE-RENDER LOGIC (Cegah Kedip) ---
        (function() {
            const isMini = localStorage.getItem('sidebar-mini') === 'true';
            const isDark = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches);
            if (isMini && window.innerWidth >= 1024) document.documentElement.classList.add('sidebar-is-mini');
            if (isDark) document.documentElement.classList.add('dark');
        })();

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        primary: {
                            "50": "#eff6ff",
                            "100": "#dbeafe",
                            "200": "#bfdbfe",
                            "300": "#93c5fd",
                            "400": "#60a5fa",
                            "500": "#3b82f6",
                            "600": "#2563eb",
                            "700": "#1d4ed8",
                            "800": "#1e40af",
                            "900": "#1e3a8a"
                        }
                    }
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* --- MINI SIDEBAR LOGIC --- */
        @media (min-width: 1024px) {
            .sidebar-is-mini #sidebar {
                width: 80px !important;
            }

            .sidebar-is-mini #sidebar .sidebar-content-text {
                display: none !important;
            }

            .sidebar-is-mini #sidebar .search-container {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }

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

            .sidebar-is-mini #sidebar .menu-link {
                justify-content: center;
            }

            .sidebar-is-mini #sidebar .menu-link i {
                margin: 0 !important;
                width: 24px;
                font-size: 1.25rem;
            }

            .sidebar-is-mini #main-container {
                margin-left: 80px !important;
            }
        }

        .ready-transition #sidebar,
        .ready-transition #main-container {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors duration-300">

    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        @include('layouts.partials.backend.sidebar')

        <div id="main-container" class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
            {{-- Header --}}
            @include('layouts.partials.backend.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <div id="sidebar-overlay" onclick="toggleSidebar()"
        class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden backdrop-blur-sm"></div>

    {{-- Scripts --}}
    @include('layouts.partials.backend.scripts')
</body>

</html>
