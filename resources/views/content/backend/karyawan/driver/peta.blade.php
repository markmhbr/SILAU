@extends('layouts.backend')

@section('title', 'Peta Navigasi')

@section('content')
<div class="fixed inset-0 z-[50] bg-white dark:bg-slate-900 flex flex-col">
    
    {{-- TOP BAR --}}
    <div class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-3">
            <a href="{{ route('karyawan.driver.penjemputan') }}" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Navigasi Rute</p>
                <p class="text-sm font-bold text-slate-800 dark:text-white truncate max-w-[200px]">
                    {{ $transaksi->pelanggan?->user?->name ?? 'Pelanggan' }}
                </p>
            </div>
        </div>

        <div id="tracking-indicator" class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 rounded-full border border-blue-100 dark:border-blue-800">
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
            <span class="text-[10px] font-black text-blue-700 dark:text-blue-300 uppercase tracking-widest">Tracking Aktif</span>
        </div>
    </div>

    {{-- FULL MAP --}}
    <div class="flex-grow relative">
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
            id="main-nav-map"
            class="w-full h-full border-none"
            src="https://www.google.com/maps?q={{ $destLat }},{{ $destLng }}&hl=id&z=17&output=embed"
            allow="geolocation">
        </iframe>
        
        {{-- OVERLAY INFO --}}
        <div class="absolute bottom-6 left-6 right-6 p-6 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-[2rem] shadow-2xl border border-white/20 flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center font-black">
                    📍
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Tujuan</p>
                    <p class="text-xs font-bold text-slate-800 dark:text-white line-clamp-1">
                        {{ $transaksi->pelanggan?->alamat_lengkap ?? 'Alamat' }}
                    </p>
                </div>
            </div>
            <a href="https://www.google.com/maps?q={{ $destLat }},{{ $destLng }}" target="_blank" class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center shadow-lg active:scale-95 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </div>
</div>

<script>
    (function() {
        let lastUpdate = 0;
        const minInterval = 8000;

        if ("geolocation" in navigator) {
            navigator.geolocation.watchPosition((position) => {
                const now = Date.now();
                if (now - lastUpdate > minInterval) {
                    lastUpdate = now;
                    
                    fetch("{{ route('karyawan.driver.update-lokasi', $transaksi->id) }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        })
                    }).catch(err => console.error("Tracking Error:", err));
                }
            }, (error) => {
                console.error("Geolocation Error:", error);
            }, {
                enableHighAccuracy: true,
                maximumAge: 10000,
                timeout: 5000
            });
        }
    })();
</script>

<style>
    /* Sembunyikan footer dan header default jika perlu untuk mode full */
    footer, header:not(.nav-header) {
        display: none !important;
    }
    #main-content-wrapper {
        padding: 0 !important;
        margin: 0 !important;
        max-width: none !important;
    }
</style>
@endsection
