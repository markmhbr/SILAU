<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title') - Laundry App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            width: 100vw;
            height: 100vh;
        }
    </style>
</head>
<body class="bg-white dark:bg-slate-900 transition-colors">
    @yield('content')
</body>
</html>
