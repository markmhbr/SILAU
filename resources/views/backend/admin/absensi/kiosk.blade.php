@extends('layouts.home')
@section('title', 'Kiosk Absensi Scanner')

@section('content')
    <div class="h-[calc(100vh-100px)] flex flex-col items-center justify-center p-4">
        <div class="max-w-md w-full text-center mb-8">
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight mb-2">Kiosk Absensi</h1>
            <p class="text-slate-500 text-sm">Scan QR Code ID Card Karyawan ke kamera di bawah ini.</p>
        </div>

        <div class="w-full max-w-sm relative">
            <!-- Notifikasi AJAX -->
            <div id="ajax-alert"
                class="hidden absolute -top-16 left-0 right-0 z-50 text-center py-3 px-4 rounded-xl shadow-lg border font-bold text-sm transform transition-all translate-y-2 opacity-0">
                <!-- Pesan akan dimuat di sini via JS -->
            </div>

            <!-- Scanner Container -->
            <div
                class="rounded-[2.5rem] overflow-hidden shadow-2xl shadow-indigo-500/10 border-[8px] border-white dark:border-slate-800 bg-slate-900 w-full aspect-square flex flex-col items-center justify-center relative mb-8">
                <div id="qr-reader" class="w-full h-full object-cover"></div>

                <!-- Custom Initial UI before camera loads -->
                <div id="qr-reader-placeholder"
                    class="text-slate-400 flex flex-col items-center justify-center p-8 absolute inset-0 z-10 bg-slate-900 transition-opacity duration-300">
                    <i class="fas fa-camera text-6xl mb-4 opacity-50 text-indigo-400"></i>
                    <p class="text-sm font-semibold tracking-wide">Kamera Kiosk Siap</p>
                    <p class="text-xs text-slate-500 mt-2 text-center">Tekan tombol di bawah untuk memulai pemindaian
                        otomatis</p>
                </div>

                <!-- Scanning Overlay Frame -->
                <div id="scan-frame"
                    class="hidden absolute inset-8 border-4 border-indigo-500/50 rounded-2xl z-20 pointer-events-none">
                </div>

                <!-- Scanning Line Animation -->
                <div id="scan-line"
                    class="hidden absolute top-0 left-0 w-full h-1 bg-indigo-500 shadow-[0_0_20px_#6366f1] z-30 opacity-90 pointer-events-none animate-scan">
                </div>
            </div>

            <div class="flex justify-center gap-4 w-full px-4">
                <button id="startScanBtn" type="button"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl text-sm font-bold transition-all shadow-xl shadow-indigo-600/30 flex items-center justify-center gap-2 active:scale-95">
                    <i class="fas fa-play"></i> Mulai Scan Kamera
                </button>
                <button id="stopScanBtn" type="button"
                    class="hidden w-full bg-rose-600 hover:bg-rose-700 text-white py-4 rounded-2xl text-sm font-bold transition-all shadow-xl shadow-rose-600/30 flex items-center justify-center gap-2 active:scale-95">
                    <i class="fas fa-stop"></i> Berhenti Scan
                </button>
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
                animation: scanLineAnimation 2s linear infinite;
            }

            #qr-reader video {
                object-fit: cover !important;
                width: 100% !important;
                height: 100% !important;
                min-height: 300px;
                border-radius: 2rem;
            }
        </style>
        <script>
            let html5QrCode = null;
            let isScanning = false;
            let isProcessing = false;

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
                    '<i class="fas fa-spinner fa-spin text-5xl mb-4 text-indigo-500"></i><p>Menyiapkan Kamera...</p>';

                try {
                    await html5QrCode.start({
                            facingMode: "environment"
                        }, {
                            fps: 10,
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
                        `<p class="text-rose-500 font-bold"><i class="fas fa-exclamation-triangle block mb-2 text-2xl"></i>Kamera tidak ditemukan/ditolak</p>`;
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
                            `<i class="fas fa-camera text-6xl mb-4 opacity-50 text-indigo-400"></i><p class="text-sm font-semibold tracking-wide">Kamera Kiosk Siap</p><p class="text-xs text-slate-500 mt-2 text-center">Tekan tombol di bawah untuk memulai pemindaian</p>`;

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
            });
        </script>
    @endpush
@endsection
