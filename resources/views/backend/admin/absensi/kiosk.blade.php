@extends('layouts.home')
@section('title', 'Kiosk Absensi Scanner')

@section('content')
    <div class="min-h-[calc(100vh-100px)] flex flex-col items-center py-6 px-4">
        <div class="max-w-md w-full text-center mb-6">
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight mb-2">Kiosk Absensi</h1>
            <p class="text-slate-500 text-sm">Scan QR Code ID Card Karyawan ke kamera di bawah ini.</p>
        </div>

        <!-- Real-time Clock -->
        <div class="text-center mb-6 animate-pulse-slow">
            <div id="real-time-clock"
                class="text-5xl font-black text-indigo-600 dark:text-indigo-400 tracking-widest tabular-nums leading-none">
                00:00:00</div>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-[0.2em] mt-3">
                <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
            </p>
        </div>

        <div class="w-full max-w-sm relative">
            <!-- Notifikasi AJAX -->
            <div id="ajax-alert"
                class="hidden absolute -top-16 left-0 right-0 z-50 text-center py-3 px-4 rounded-xl shadow-lg border font-bold text-sm transform transition-all translate-y-2 opacity-0">
                <!-- Pesan akan dimuat di sini via JS -->
            </div>

            <!-- Scanner Container -->
            <div
                class="rounded-[3rem] overflow-hidden shadow-2xl shadow-indigo-500/20 border-[10px] border-white dark:border-slate-800 bg-slate-900 w-full aspect-square flex flex-col items-center justify-center relative mb-8 group transition-all duration-500 hover:border-indigo-500/30">
                <div id="qr-reader" class="w-full h-full object-cover"></div>

                <!-- Custom Initial UI before camera loads -->
                <div id="qr-reader-placeholder"
                    class="text-slate-400 flex flex-col items-center justify-center p-8 absolute inset-0 z-10 bg-slate-900 transition-opacity duration-300">
                    <i class="fas fa-camera text-6xl mb-4 opacity-50 text-indigo-400 animate-bounce"></i>
                    <p class="text-sm font-semibold tracking-wide">Menghubungkan Kamera...</p>
                    <p class="text-xs text-slate-500 mt-2 text-center">Pastikan izin kamera sudah diberikan</p>
                </div>

                <!-- Scanning Overlay Frame -->
                <div id="scan-frame"
                    class="hidden absolute inset-8 border-4 border-indigo-500/50 rounded-3xl z-20 pointer-events-none">
                </div>

                <!-- Scanning Line Animation -->
                <div id="scan-line"
                    class="hidden absolute top-0 left-0 w-full h-1 bg-indigo-500 shadow-[0_0_20px_#6366f1] z-30 opacity-90 pointer-events-none animate-scan">
                </div>
            </div>

            <div class="flex justify-center gap-4 w-full px-4 mb-8">
                <button id="startScanBtn" type="button"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl text-sm font-bold transition-all shadow-xl shadow-indigo-600/30 flex items-center justify-center gap-2 active:scale-95 group">
                    <i class="fas fa-play group-hover:scale-125 transition-transform"></i> Mulai Scan
                </button>
                <button id="stopScanBtn" type="button"
                    class="hidden w-full bg-rose-600 hover:bg-rose-700 text-white py-4 rounded-2xl text-sm font-bold transition-all shadow-xl shadow-rose-600/30 flex items-center justify-center gap-2 active:scale-95 group">
                    <i class="fas fa-stop group-hover:scale-125 transition-transform"></i> Berhenti Scan
                </button>
            </div>

            <!-- Attendance Stats Cards -->
            <div class="grid grid-cols-2 gap-4 w-full px-2 mb-10">
                <div
                    class="bg-white dark:bg-slate-800 p-5 rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700 flex flex-col items-center justify-center text-center transition-transform hover:scale-105">
                    <div
                        class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-500/10 flex items-center justify-center mb-2">
                        <i class="fas fa-check text-emerald-500 text-xs"></i>
                    </div>
                    <span class="text-3xl font-black text-slate-800 dark:text-white mb-1 tabular-nums"
                        id="count-sudah-absen">{{ count($sudahAbsen) }}</span>
                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">Sudah Absen</span>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 p-5 rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700 flex flex-col items-center justify-center text-center transition-transform hover:scale-105">
                    <div
                        class="w-10 h-10 rounded-full bg-rose-100 dark:bg-rose-500/10 flex items-center justify-center mb-2">
                        <i class="fas fa-clock text-rose-500 text-xs"></i>
                    </div>
                    <span class="text-3xl font-black text-slate-800 dark:text-white mb-1 tabular-nums"
                        id="count-belum-absen">{{ count($belumAbsen) }}</span>
                    <span class="text-[9px] font-black text-rose-500 uppercase tracking-widest">Belum Absen</span>
                </div>
            </div>
        </div>

        <!-- Attendance Cards -->
        <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 gap-8 pb-20">


            <!-- Sudah Absen -->
            <div
                class="bg-emerald-50/30 dark:bg-emerald-500/5 p-6 rounded-[2.5rem] border border-emerald-100/50 dark:border-emerald-500/10">
                <h3
                    class="text-xs font-black text-emerald-500 mb-6 flex items-center gap-2 uppercase tracking-[0.2em] px-2">
                    <i class="fas fa-user-check text-lg"></i> Sudah Absen Hari Ini
                </h3>
                <div id="container-sudah-absen" class="space-y-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($sudahAbsen as $a)
                        <div id="karyawan-{{ $a->karyawan_id }}"
                            class="flex items-center gap-3 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-emerald-100 dark:border-slate-700 transition-all duration-300 hover:shadow-md">
                            <div
                                class="w-11 h-11 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-black flex items-center justify-center shrink-0 border-2 border-white dark:border-emerald-800 shadow-sm">
                                {{ substr($a->karyawan->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <p class="font-bold text-sm text-slate-800 dark:text-emerald-50 leading-tight">
                                        {{ $a->karyawan->user->name }}</p>
                                </div>
                                <p class="text-[10px] text-emerald-600 dark:text-emerald-400 font-bold mt-1 inline-flex items-center gap-2"
                                    id="absen-waktu-{{ $a->karyawan_id }}">
                                    <span
                                        class="bg-emerald-100 dark:bg-emerald-500/20 px-2 py-0.5 rounded-md flex items-center gap-1">
                                        <i class="fas fa-sign-in-alt opacity-70"></i>
                                        {{ \Carbon\Carbon::parse($a->waktu_masuk)->format('H:i') }}
                                    </span>
                                    @if ($a->waktu_keluar)
                                        <span
                                            class="bg-rose-100 dark:bg-rose-500/20 px-2 py-0.5 rounded-md text-rose-600 dark:text-rose-400 flex items-center gap-1">
                                            <i class="fas fa-sign-out-alt opacity-70"></i>
                                            {{ \Carbon\Carbon::parse($a->waktu_keluar)->format('H:i') }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <div id="sudah-absen-empty" class="text-center py-10 opacity-50">
                            <i class="fas fa-fingerprint text-4xl text-slate-300 mb-3"></i>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Belum ada karyawan absen
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
            <!-- Belum Absen -->
            <div
                class="bg-slate-50/50 dark:bg-slate-800/20 p-6 rounded-[2.5rem] border border-slate-100 dark:border-slate-800">
                <h3 class="text-xs font-black text-rose-500 mb-6 flex items-center gap-2 uppercase tracking-[0.2em] px-2"><i
                        class="fas fa-user-clock text-lg"></i> Daftar Belum Absen</h3>
                <div id="container-belum-absen" class="space-y-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($belumAbsen as $k)
                        <div id="karyawan-{{ $k->id }}"
                            class="flex items-center gap-3 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 transition-all duration-300 hover:shadow-md">
                            <div
                                class="w-11 h-11 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 font-black flex items-center justify-center shrink-0 border-2 border-white dark:border-slate-600 shadow-sm">
                                {{ substr($k->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-sm text-slate-800 dark:text-white leading-tight">
                                    {{ $k->user->name }}</p>
                                <p class="text-[10px] font-medium text-slate-400 mt-0.5">
                                    {{ $k->jabatan->nama_jabatan ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <div id="belum-absen-empty" class="text-center py-10 opacity-50">
                            <i class="fas fa-check-double text-4xl text-emerald-500 mb-3"></i>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Semua karyawan telah absen
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode"></script>
        <style>
            @keyframes scanLineAnimation {
                0% {
                    top: 0;
                    opacity: 0;
                }

                10% {
                    opacity: 1;
                }

                50% {
                    top: 100%;
                    opacity: 1;
                }

                90% {
                    opacity: 1;
                }

                100% {
                    top: 0;
                    opacity: 0;
                }
            }

            .animate-scan {
                animation: scanLineAnimation 2.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            }

            .animate-pulse-slow {
                animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.8;
                }
            }

            #qr-reader video {
                object-fit: cover !important;
                width: 100% !important;
                height: 100% !important;
                min-height: 250px;
                border-radius: 2.5rem;
            }

            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 10px;
            }

            .dark .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: #334155;
            }

            #real-time-clock {
                text-shadow: 0 0 15px rgba(99, 102, 241, 0.2);
            }
        </style>
        <script>
            let html5QrCode = null;
            let isScanning = false;
            let isProcessing = false;

            function updateClock() {
                const now = new Date();
                const h = String(now.getHours()).padStart(2, '0');
                const m = String(now.getMinutes()).padStart(2, '0');
                const s = String(now.getSeconds()).padStart(2, '0');
                document.getElementById('real-time-clock').textContent = `${h}:${m}:${s}`;
            }
            setInterval(updateClock, 1000);
            updateClock();

            function showAlert(type, message) {
                const alertBox = document.getElementById('ajax-alert');
                alertBox.className = `absolute -top-16 left-0 right-0 z-50 text-center py-3 px-4 rounded-xl shadow-lg border font-bold text-sm transform transition-all duration-300 translate-y-0 opacity-100 ${
            type === 'success' 
            ? 'bg-emerald-50 text-emerald-600 border-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-400 dark:border-emerald-800'
            : 'bg-rose-50 text-rose-600 border-rose-200 dark:bg-rose-900/40 dark:text-rose-400 dark:border-rose-800'
        }`;

                const icon = type === 'success' ? '<i class="fas fa-check-circle mr-1"></i>' :
                    '<i class="fas fa-exclamation-circle mr-1"></i>';
                alertBox.innerHTML = `${icon} ${message}`;

                // Auto hide after 3.5s
                setTimeout(() => {
                    alertBox.classList.remove('translate-y-0', 'opacity-100');
                    alertBox.classList.add('translate-y-2', 'opacity-0');
                    setTimeout(() => {
                        alertBox.classList.add('hidden');
                    }, 300);
                }, 3500);
            }

            async function onScanSuccess(decodedText) {
                if (isProcessing) return;
                isProcessing = true;

                // Visual feedback
                document.getElementById('scan-line').style.backgroundColor = '#22c55e'; // green
                document.getElementById('scan-line').style.boxShadow = '0 0 20px #22c55e';
                const audio = new Audio('https://www.soundjay.com/buttons/sounds/beep-07a.mp3');
                audio.play().catch(e => console.log('Audio autoplay blocked'));

                // Pause scanning momentarily
                if (html5QrCode && html5QrCode.getState() === Html5QrcodeScannerState.SCANNING) {
                    html5QrCode.pause();
                }

                try {
                    const formData = new FormData();
                    formData.append('barcode', decodedText);
                    formData.append('_token', '{{ csrf_token() }}');

                    const response = await fetch('{{ route('admin.absensi.scan') }}', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        showAlert('success', result.message);

                        // DOM Manipulation for dynamic cards
                        const id = result.data.karyawan_id;
                        let card = document.getElementById(`karyawan-${id}`);

                        if (result.data.tipe === 'Masuk' && card) {
                            // Update style
                            card.className =
                                "flex items-center gap-3 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-emerald-100 dark:border-slate-700 transition-all duration-500 transform scale-105 ring-2 ring-emerald-400";
                            setTimeout(() => card.classList.remove('scale-105', 'ring-2', 'ring-emerald-400'), 500);

                            // Update avatar style
                            card.children[0].className =
                                "w-11 h-11 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-black flex items-center justify-center shrink-0 border-2 border-white dark:border-emerald-800 shadow-sm";

                            // Update text container
                            card.children[1].innerHTML = `
                                <div class="flex justify-between items-start">
                                    <p class="font-bold text-sm text-slate-800 dark:text-emerald-50 leading-tight">${result.data.nama}</p>
                                </div>
                                <p class="text-[10px] text-emerald-600 dark:text-emerald-400 font-bold mt-1 inline-flex items-center gap-2" id="absen-waktu-${id}">
                                    <span class="bg-emerald-100 dark:bg-emerald-500/20 px-2 py-0.5 rounded-md flex items-center gap-1">
                                        <i class="fas fa-sign-in-alt opacity-70"></i> ${result.data.waktu}
                                    </span>
                                </p>
                            `;

                            // Remove empty text if exists
                            let emptySudah = document.getElementById('sudah-absen-empty');
                            if (emptySudah) emptySudah.remove();

                            // Move to correct container
                            document.getElementById('container-sudah-absen').prepend(card);

                            // Update Stats
                            let sudahCount = document.getElementById('count-sudah-absen');
                            let belumCount = document.getElementById('count-belum-absen');
                            sudahCount.textContent = parseInt(sudahCount.textContent) + 1;
                            belumCount.textContent = Math.max(0, parseInt(belumCount.textContent) - 1);

                        } else if (result.data.tipe === 'Keluar' && card) {
                            // Highlight card briefly to indicate update
                            card.classList.add('scale-105', 'ring-2', 'ring-rose-400');
                            setTimeout(() => card.classList.remove('scale-105', 'ring-2', 'ring-rose-400'), 500);

                            // Find the time container and append checkout time
                            let waktuContainer = document.getElementById(`absen-waktu-${id}`);
                            if (waktuContainer && !waktuContainer.innerHTML.includes('fa-sign-out-alt')) {
                                waktuContainer.innerHTML +=
                                    `<span class="bg-rose-100 dark:bg-rose-500/20 px-2 py-0.5 rounded-md text-rose-600 dark:text-rose-400 flex items-center gap-1">
                                        <i class="fas fa-sign-out-alt opacity-70"></i> ${result.data.waktu}
                                    </span>`;
                            }
                        }

                    } else {
                        showAlert('error', result.message || 'Gagal memproses absensi.');
                    }
                } catch (error) {
                    console.error('AJAX Error:', error);
                    showAlert('error', 'Terjadi kesalahan jaringan.');
                } finally {
                    // Resume scanning after 2 seconds
                    setTimeout(() => {
                        document.getElementById('scan-line').style.backgroundColor = '#6366f1'; // back to indigo
                        document.getElementById('scan-line').style.boxShadow = '0 0 20px #6366f1';
                        if (html5QrCode && html5QrCode.getState() === Html5QrcodeScannerState.PAUSED) {
                            html5QrCode.resume();
                        }
                        isProcessing = false;
                    }, 2000);
                }
            }

            async function startScanner() {
                if (!html5QrCode) {
                    html5QrCode = new Html5Qrcode("qr-reader");
                }

                document.getElementById('startScanBtn').classList.add('hidden');
                document.getElementById('stopScanBtn').classList.remove('hidden');
                document.getElementById('qr-reader-placeholder').innerHTML =
                    '<i class="fas fa-circle-notch fa-spin text-5xl mb-4 text-indigo-500"></i><p class="font-bold tracking-widest text-xs uppercase opacity-70">Memulai Kamera...</p>';

                try {
                    await html5QrCode.start({
                            facingMode: "environment"
                        }, {
                            fps: 15,
                            qrbox: {
                                width: 250,
                                height: 250
                            },
                            aspectRatio: 1.0
                        },
                        onScanSuccess, (errorMessage) => {}
                    );
                    isScanning = true;
                    document.getElementById('qr-reader-placeholder').style.display = 'none';
                    document.getElementById('scan-line').classList.remove('hidden');
                    document.getElementById('scan-frame').classList.remove('hidden');
                } catch (err) {
                    document.getElementById('qr-reader-placeholder').innerHTML =
                        `<div class="text-rose-500 flex flex-col items-center"><i class="fas fa-camera-slash text-4xl mb-3"></i><p class="text-[10px] font-black uppercase tracking-widest">Kamera Gagal Dimuat</p></div>`;
                    document.getElementById('startScanBtn').classList.remove('hidden');
                    document.getElementById('stopScanBtn').classList.add('hidden');
                }
            }

            async function stopScanner() {
                if (html5QrCode && isScanning) {
                    try {
                        await html5QrCode.stop();
                        isScanning = false;
                        html5QrCode.clear();

                        document.getElementById('qr-reader-placeholder').style.display = 'flex';
                        document.getElementById('qr-reader-placeholder').innerHTML =
                            `<i class="fas fa-camera text-6xl mb-4 opacity-50 text-indigo-400 animate-bounce"></i><p class="text-sm font-semibold tracking-wide">Kamera Kiosk Siap</p><p class="text-xs text-slate-500 mt-2 text-center">Tekan tombol di bawah untuk memulai pemindaian</p>`;

                        document.getElementById('scan-line').classList.add('hidden');
                        document.getElementById('scan-frame').classList.add('hidden');
                        document.getElementById('startScanBtn').classList.remove('hidden');
                        document.getElementById('stopScanBtn').classList.add('hidden');
                    } catch (err) {
                        console.error("Failed to stop scanner", err);
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('startScanBtn').addEventListener('click', startScanner);
                document.getElementById('stopScanBtn').addEventListener('click', stopScanner);

                // Auto start scanner after a short delay
                setTimeout(startScanner, 1000);
            });
        </script>
    @endpush
@endsection
