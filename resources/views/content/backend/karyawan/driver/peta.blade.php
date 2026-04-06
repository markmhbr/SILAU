@extends('layouts.plain')

@section('title', 'Navigasi Driver')

@section('content')
<div class="relative w-full h-full flex flex-col">
    
    {{-- BAR ATAS --}}
    <div class="absolute top-0 left-0 right-0 z-50 p-4 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('karyawan.driver.penjemputan') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Menuju Lokasi</p>
                <p class="text-sm font-bold text-slate-800 dark:text-white truncate max-w-[150px]">
                    {{ $transaksi->pelanggan?->user?->name ?? 'Pelanggan' }}
                </p>
            </div>
        </div>

        <div id="status-pelacakan" class="flex items-center gap-2 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/20 rounded-full border border-emerald-100 dark:border-emerald-800">
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
            <span class="text-[9px] font-black text-emerald-700 dark:text-emerald-300 uppercase tracking-widest">Pelacakan Aktif</span>
        </div>
    </div>

    {{-- IFRAME MAPS --}}
    <div class="flex-grow w-full h-full">
        @php
            $destLat = $transaksi->pelanggan->latitude;
            $destLng = $transaksi->pelanggan->longitude;
            
            $outlet = \App\Models\ProfilPerusahaan::first();
            if ($transaksi->status == 'diambil driver' && $outlet && $outlet->latitude) {
                $destLat = $outlet->latitude;
                $destLng = $outlet->longitude;
            }
        @endphp
        <iframe
            id="nav-iframe"
            class="w-full h-full border-none"
            src="https://www.google.com/maps?q={{ $destLat }},{{ $destLng }}&hl=id&z=16&output=embed"
            allow="geolocation">
        </iframe>
    </div>

    {{-- OVERLAY INFO --}}
    <div class="absolute bottom-6 left-6 right-6 z-50 p-6 bg-white dark:bg-slate-900 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.2)] border border-slate-200 dark:border-slate-800 space-y-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 text-orange-600 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat Tujuan</p>
                <p class="text-xs font-medium text-slate-600 dark:text-slate-300 leading-relaxed">
                    {{ $transaksi->pelanggan?->alamat_lengkap ?? 'Alamat belum diatur' }}
                </p>
            </div>
        </div>

        <div class="flex gap-3">
            <button onclick="updateRoute()" class="flex-grow bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 7m0 10V7" />
                </svg>
                Tampilkan Rute Jalan
            </button>
            <a href="https://www.google.com/maps?daddr={{ $destLat }},{{ $destLng }}" target="_blank" class="w-14 h-14 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl flex items-center justify-center text-slate-400 hover:text-orange-500 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </div>
</div>

<script>
    let currentLat = null;
    let currentLng = null;
    let lastServerUpdate = 0;
    const destLat = "{{ $destLat }}";
    const destLng = "{{ $destLng }}";
    
    // Fungsi untuk mengubah peta jadi mode rute
    function updateRoute() {
        if (currentLat && currentLng) {
            const iframe = document.getElementById('nav-iframe');
            // Menggunakan mode directions (saddr = start, daddr = destination)
            iframe.src = `https://maps.google.com/maps?saddr=${currentLat},${currentLng}&daddr=${destLat},${destLng}&hl=id&z=16&output=embed`;
        } else {
            alert("Sedang mengambil lokasi Anda, mohon tunggu sebentar...");
        }
    }

    if ("geolocation" in navigator) {
        navigator.geolocation.watchPosition((position) => {
            currentLat = position.coords.latitude;
            currentLng = position.coords.longitude;

            // Update ke server setiap 8 detik
            const now = Date.now();
            if (now - lastServerUpdate > 8000) {
                lastServerUpdate = now;
                fetch("{{ route('karyawan.driver.update-lokasi', $transaksi->id) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        latitude: currentLat,
                        longitude: currentLng
                    })
                }).catch(err => console.error("Tracking error:", err));
            }
        }, (err) => {
            console.error("GPS Error:", err);
        }, {
            enableHighAccuracy: true,
            maximumAge: 10000,
            timeout: 5000
        });
    }
</script>
@endsection
