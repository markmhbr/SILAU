<!DOCTYPE html>
<html x-data="{
    darkMode: localStorage.getItem('theme') === 'dark',
    mobileMenu: false,
    isFull: false
}" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleanFlow Premium Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body
    class="bg-[#f8fafc] dark:bg-[#020617] text-slate-900 dark:text-slate-100 transition-colors duration-500 pb-20 md:pb-0">

    @include('layouts.partials.frontend.navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10 animate-page">
        @yield('content')
    </main>

    @include('layouts.partials.frontend.footer')

</body>

</html>
