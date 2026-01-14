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

    @include('layouts.partials.frontend.navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10 animate-page">
        @yield('content')
    </main>

    @include('layouts.partials.frontend.footer')

    @include('layouts.partials.frontend.scripts')
</body>

</html>
