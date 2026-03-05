<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID CARD - {{ strtoupper($karyawan->user->name) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=JetBrains+Mono&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
        }

        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none;
            }

            .card-wrapper {
                box-shadow: none;
                border: none;
                padding: 0;
                margin: 0;
            }
        }

        .card-bg {
            background: linear-gradient(165deg, #064e3b 0%, #022c22 100%);
            position: relative;
            overflow: hidden;
        }

        .card-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .hologram {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 50%, rgba(255, 255, 255, 0) 100%);
        }

        svg {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }
    </style>
</head>

<body class="bg-slate-200 flex flex-col items-center justify-center min-h-screen p-8">

    <div class="no-print mb-8 flex gap-4">
        <button onclick="window.print()"
            class="group flex items-center gap-3 px-8 py-3 bg-slate-900 border border-slate-700 text-white rounded-2xl font-bold shadow-2xl hover:bg-black transition-all hover:scale-105 active:scale-95">
            <span class="text-xl">🖨️</span>
            <span>CETAK KARTU ID</span>
        </button>
        <a href="{{ route('admin.karyawan.index') }}"
            class="flex items-center gap-3 px-8 py-3 bg-white border border-slate-300 text-slate-700 rounded-2xl font-bold hover:bg-slate-50 transition-all">
            <span>KEMBALI</span>
        </a>
    </div>

    <!-- ID CARD CONTAINER (CR-80 Sized Portrait) -->
    <div
        class="card-wrapper relative w-[380px] h-[580px] bg-white rounded-[3rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.3)] overflow-hidden p-3 border-8 border-slate-900">

        <div class="card-bg w-full h-full rounded-[2.2rem] flex flex-col relative">

            {{-- Decoration Elements --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>

            {{-- Body --}}
            <div class="flex flex-col items-center flex-grow pt-10 px-6 relative z-10">

                {{-- Header / Logo --}}
                <div class="text-center mb-8">
                    <div class="inline-block px-4 py-1.5 glass rounded-full mb-2">
                        <span class="text-[10px] font-black text-emerald-400 tracking-[0.4em] uppercase">Official
                            Identity</span>
                    </div>
                    <h1 class="text-2xl font-black text-white tracking-tighter uppercase">Laundry <span
                            class="text-emerald-500">LPJ</span></h1>
                </div>

                {{-- Photo Frame --}}
                <div class="relative mb-8 pt-4">
                    {{-- Decorative Rings --}}
                    <div class="absolute inset-0 -m-3 border border-emerald-500/20 rounded-[3rem] animate-pulse"></div>
                    <div class="absolute inset-0 -m-6 border border-emerald-500/10 rounded-[4rem]"></div>

                    <div
                        class="w-40 h-40 rounded-[2.5rem] border-4 border-white/10 shadow-2xl overflow-hidden bg-slate-800 relative z-10">
                        <img src="{{ $karyawan->foto_url }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 hologram"></div>
                    </div>

                    {{-- Status Badge --}}
                    <div
                        class="absolute -bottom-2 -right-2 bg-emerald-500 text-white text-[9px] font-black px-4 py-1.5 rounded-xl shadow-lg uppercase tracking-widest border-2 border-slate-950 z-20">
                        Active Staf
                    </div>
                </div>

                {{-- Name & Jabatan --}}
                <div class="text-center space-y-1 mb-10 w-full">
                    <h2 class="text-2xl font-extrabold text-white leading-tight uppercase tracking-tight">
                        {{ $karyawan->user->name }}</h2>
                    <div class="w-12 h-1 bg-emerald-500 mx-auto rounded-full my-3"></div>
                    <p class="text-sm font-semibold text-emerald-400 uppercase tracking-[0.2em]">
                        {{ $karyawan->jabatan->nama_jabatan }}</p>
                </div>

                {{-- QR Section --}}
                <div class="w-full mt-auto mb-6">
                    <div class="glass flex flex-col items-center p-5 rounded-[2rem] gap-3 border border-white/5">
                        <div
                            class="bg-white p-3 rounded-2xl shadow-xl w-32 h-32 flex items-center justify-center overflow-hidden">
                            {!! $qrCode !!}
                        </div>
                        <div class="text-center w-full">
                            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-1">Employee
                                ID</p>
                            <p class="mono text-[12px] font-bold text-white tracking-widest truncate">
                                {{ $karyawan->barcode }}</p>
                            <p class="text-[9px] text-slate-400 mt-2 leading-tight italic px-1">
                                Scan untuk absensi harian via dashboard admin.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Bottom Accent --}}
            <div class="h-12 w-full bg-slate-950 flex items-center justify-center px-8 border-t border-white/5">
                <p class="text-[8px] text-slate-500 font-bold tracking-[0.3em] uppercase">Professional Laundry
                    Management System</p>
            </div>

        </div>
    </div>

    {{-- Print Hint --}}
    <div class="no-print mt-10 p-6 bg-blue-50 border border-blue-100 rounded-3xl max-w-md text-center shadow-lg">
        <p class="text-xs text-blue-700 font-bold leading-relaxed">
            <span class="text-xl">💡</span><br>
            Tips Cetak: Gunakan kertas Foto atau Art Paper GSM tinggi untuk hasil terbaik. <br>
            Pastikan opsi "Latar Belakang Grafis" aktif di pengaturan cetak browser.
        </p>
    </div>

</body>

</html>
