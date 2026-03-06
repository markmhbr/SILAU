<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Semua ID CARD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=JetBrains+Mono&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #cbd5e1;
            margin: 0;
            padding: 20px;
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

            .page-break {
                page-break-after: always;
            }

            .card-wrapper {
                box-shadow: none !important;
                border: 2px solid #0f172a !important;
            }
        }

        .card-bg {
            background: linear-gradient(165deg, #064e3b 0%, #022c22 100%);
            position: relative;
            overflow: hidden;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        svg {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }

        .a4-container {
            width: 210mm;
            min-height: 297mm;
            background: white;
            margin: 0 auto;
            padding: 10mm;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        @media print {
            .a4-container {
                width: auto;
                min-height: auto;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print mb-8 flex justify-center gap-4">
        <button onclick="window.print()"
            class="px-8 py-3 bg-slate-900 text-white rounded-2xl font-bold shadow-xl hover:bg-black transition-all">
            <span class="text-xl">🖨️</span> CETAK SEMUA KARTU
        </button>
        <button onclick="window.close()"
            class="px-8 py-3 bg-white text-slate-700 border border-slate-300 rounded-2xl font-bold hover:bg-slate-50 transition-all">
            TUTUP
        </button>
    </div>

    @foreach (array_chunk($cardsData, 9) as $chunk)
        <div class="a4-container {{ !$loop->last ? 'page-break' : '' }} mb-10 text-center">

            <div class="grid grid-cols-3 gap-y-6 gap-x-2 place-items-center h-full content-start">
                @foreach ($chunk as $data)
                    @php
                        $karyawan = $data['karyawan'];
                        $qrCode = $data['qrCode'];
                    @endphp
                    <!-- Scaled Down Card (w-54mm h-86mm is CR80, let's use slightly bigger 60x95 for perfect 3x3 fit on A4) -->
                    <div
                        class="card-wrapper relative w-[60mm] h-[93mm] bg-white rounded-2xl overflow-hidden p-1.5 border-4 border-slate-900 shadow-md">
                        <div class="card-bg w-full h-full rounded-xl flex flex-col relative">

                            {{-- Decoration Elements --}}
                            <div class="absolute top-0 right-0 w-16 h-16 bg-emerald-500/10 rounded-full blur-xl"></div>
                            <div class="absolute bottom-0 left-0 w-16 h-16 bg-emerald-500/10 rounded-full blur-xl">
                            </div>

                            {{-- Body --}}
                            <div class="flex flex-col items-center flex-grow pt-4 px-2 relative z-10 w-full">
                                {{-- Header / Logo --}}
                                <div class="text-center mb-3">
                                    <div class="inline-block px-2 py-0.5 glass rounded-full mb-1">
                                        <span
                                            class="text-[6px] font-black text-emerald-400 tracking-[0.2em] uppercase">Identity</span>
                                    </div>
                                    <h1 class="text-xs font-black text-white tracking-tighter uppercase leading-none">
                                        Laundry <span class="text-emerald-500">LPJ</span></h1>
                                </div>

                                {{-- Photo Frame --}}
                                <div class="relative mb-3 pt-1 w-full flex justify-center">
                                    <div
                                        class="w-16 h-16 rounded-2xl border-2 border-white/10 shadow-lg overflow-hidden bg-slate-800 relative z-10 mx-auto">
                                        <img src="{{ $karyawan->foto_url }}" class="w-full h-full object-cover">
                                    </div>
                                    {{-- Status Badge --}}
                                    <div
                                        class="absolute -bottom-1 right-2 bg-emerald-500 text-white text-[6px] font-black px-1.5 py-0.5 rounded-md shadow-lg uppercase tracking-wider border border-slate-950 z-20">
                                        Staf
                                    </div>
                                </div>

                                {{-- Name & Jabatan --}}
                                <div class="text-center space-y-0.5 w-full">
                                    <h2
                                        class="text-xs font-extrabold text-white leading-tight uppercase tracking-tight truncate w-full px-1">
                                        {{ $karyawan->user->name }}
                                    </h2>
                                    <div class="w-6 h-0.5 bg-emerald-500 mx-auto rounded-full my-1"></div>
                                    <p
                                        class="text-[7px] font-semibold text-emerald-400 uppercase tracking-widest truncate w-full">
                                        {{ $karyawan->jabatan->nama_jabatan }}
                                    </p>
                                </div>

                                {{-- QR Section --}}
                                <div class="w-full mt-auto mb-2">
                                    <div
                                        class="glass flex flex-col items-center p-2 rounded-xl gap-1.5 border border-white/5 mx-1">
                                        <div
                                            class="bg-white p-1 rounded-lg shadow-md w-20 h-20 flex items-center justify-center overflow-hidden">
                                            {!! $qrCode !!}
                                        </div>
                                        <div class="text-center w-full">
                                            <p
                                                class="mono text-[8.5px] mt-0.5 font-black text-white tracking-widest truncate">
                                                {{ $karyawan->barcode }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Bottom Accent --}}
                            <div
                                class="h-4 w-full bg-slate-950 flex items-center justify-center border-t border-white/5">
                                <p class="text-[4px] text-slate-500 font-bold tracking-[0.2em] uppercase">Laundry
                                    Management</p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</body>

</html>
