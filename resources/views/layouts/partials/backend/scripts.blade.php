<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('partials.dataTables')
    @include('partials._sweetalert')

    <script>
        const html = document.documentElement;

        // Nyalakan transisi setelah load
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => html.classList.add('ready-transition'), 100);
        });

        // --- FULLSCREEN LOGIC ---
        function toggleFullScreen() {
            const icon = document.getElementById('fullscreen-icon');
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                icon.classList.replace('fa-expand', 'fa-compress');
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                    icon.classList.replace('fa-compress', 'fa-expand');
                }
            }
        }

        // Listener jika user menekan tombol 'Esc' untuk keluar fullscreen
        document.addEventListener('fullscreenchange', () => {
            const icon = document.getElementById('fullscreen-icon');
            if (!document.fullscreenElement) {
                icon.classList.replace('fa-compress', 'fa-expand');
            }
        });

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
                    resultItem.className =
                        "flex items-center gap-3 px-4 py-3 hover:bg-slate-100 dark:hover:bg-slate-700 border-b border-slate-100 dark:border-slate-700 last:border-0";
                    resultItem.innerHTML =
                        `<i class="${icon} text-primary-500 w-5 text-center"></i><span class="text-xs font-semibold dark:text-white">${link.querySelector('.sidebar-content-text').textContent}</span>`;
                    resultsDiv.appendChild(resultItem);
                }
            });

            if (found) resultsDiv.classList.remove('hidden');
            else {
                resultsDiv.innerHTML = `<div class="p-4 text-xs text-slate-500 text-center">Tidak ditemukan</div>`;
                resultsDiv.classList.remove('hidden');
            }
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-container')) document.getElementById('searchResults').classList.add(
                'hidden');
        });

        function toggleDarkMode() {
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
            document.getElementById('theme-icon').className = isDark ? 'fas fa-sun text-lg' : 'fas fa-moon text-lg';
        }

        if (html.classList.contains('dark')) document.getElementById('theme-icon').className = 'fas fa-sun text-lg';
    </script>