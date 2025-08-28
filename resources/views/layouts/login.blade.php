<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILAU Login</title>
    <!-- Gunakan Tailwind CSS untuk styling responsif -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Inter dari Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#97D7E9] flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-7xl flex flex-col md:flex-row items-center justify-center space-y-8 md:space-y-0 md:space-x-12">
        <!-- Panel kiri untuk gambar -->
        <div class="flex-1 flex flex-col items-center justify-center text-center p-4 relative">
            <!-- Ruang kosong untuk logo dan ilustrasi -->
            <!-- Silakan masukkan kode gambar atau logo Anda di sini -->
            <!-- Contoh: -->
            <!-- <div class="absolute top-4 left-4 md:top-8 md:left-8"> -->
            <!--    <img src="URL_LOGO_ANDA.png" alt="Logo SILAU" class="w-12 h-12"> -->
            <!--    <h1 class="text-3xl font-bold text-[#3D4D6A]">SILAU</h1> -->
            <!-- </div> -->
            <!-- <img src="URL_GAMBAR_MESIN_CUCI_ANDA.png" alt="Ilustrasi Mesin Cuci" class="w-full h-auto max-w-md"> -->
        </div>

        <!-- Panel kanan dengan formulir login -->
        <div class="flex-1 w-full max-w-sm flex flex-col items-center p-4 space-y-6 md:space-y-8 bg-white/70 backdrop-blur-sm rounded-3xl shadow-2xl p-8 md:p-12 lg:p-16">
            <form id="loginForm" class="w-full space-y-4 md:space-y-6">
                <!-- Input Email -->
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" class="w-full px-5 py-3 border-2 border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#58A59C] focus:border-transparent transition-all duration-300" required>
                </div>
                <!-- Input Password -->
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" class="w-full px-5 py-3 border-2 border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#58A59C] focus:border-transparent transition-all duration-300" required>
                </div>
                <!-- Tautan "buat akun?" -->
                <div class="flex justify-start">
                    <a href="#" class="text-sm text-[#3D4D6A] font-semibold hover:underline">buat akun?</a>
                </div>
                <!-- Tombol Login -->
                <div class="flex justify-end pt-4">
                    <button type="submit" class="w-40 px-6 py-3 text-white font-bold rounded-full bg-[#58A59C] hover:bg-[#4a8a80] transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-[#58A59C] focus:ring-offset-2">
                        login
                    </button>
                </div>
            </form>
            
            <!-- Area pesan, awalnya tersembunyi -->
            <div id="messageBox" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl p-6 text-center z-50">
                <p id="messageText" class="text-lg font-medium text-gray-800"></p>
                <button onclick="document.getElementById('messageBox').classList.add('hidden')" class="mt-4 px-4 py-2 bg-[#58A59C] text-white rounded-md hover:bg-[#4a8a80]">Tutup</button>
            </div>
        </div>

        <!-- Ikon pengguna dan tambah di luar card -->
        <div class="absolute top-4 right-4 md:top-8 md:right-8 flex items-center space-x-2">
            <!-- Ikon akun -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#3D4D6A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <!-- Ikon tambah -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#3D4D6A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form untuk submit secara default
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Logika sederhana untuk demonstrasi
            if (email && password) {
                showMessage('Login berhasil!');
                // Tambahkan logika autentikasi atau redirect Anda di sini
            } else {
                showMessage('Harap isi email dan password.');
            }
        });
        
        function showMessage(text) {
            const messageBox = document.getElementById('messageBox');
            const messageText = document.getElementById('messageText');
            messageText.textContent = text;
            messageBox.classList.remove('hidden');
        }
    </script>
</body>
</html>
