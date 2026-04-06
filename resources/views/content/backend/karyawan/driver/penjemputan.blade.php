@extends('layouts.backend')

@section('title', 'Penjemputan')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-fadeIn">

    {{-- HEADER --}}
    <div>
        <nav class="flex text-[10px] uppercase tracking-widest text-slate-400 mb-2 space-x-2 font-bold">
            <a href="{{ route('karyawan.dashboard') }}" class="hover:text-brand transition">Home</a>
            <span>/</span>
            <span class="text-slate-600 dark:text-slate-300">Penjemputan</span>
        </nav>

        <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
            🚚 Tugas Penjemputan
        </h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
            Daftar pelanggan yang harus dijemput oleh driver hari ini
        </p>
    </div>

    {{-- LIST --}}
    <div class="space-y-6">
        @forelse ($antreanTugas as $item)

            <div
                class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden relative">

                {{-- blob --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>

                <div class="p-8 relative z-10 space-y-6">

                    {{-- INFO --}}
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-14 h-14 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-black text-lg">
                                {{ substr($item->pelanggan?->user?->name ?? '?', 0, 1) }}
                            </div>

                            <div>
                                <p class="text-lg font-black text-slate-800 dark:text-white">
                                    {{ $item->pelanggan?->user?->name ?? 'Pelanggan' }}
                                </p>
                                <p class="text-xs text-slate-500 mt-1 max-w-md">
                                    📍 {{ $item->pelanggan?->alamat_lengkap ?? 'Alamat belum tersedia' }}
                                </p>
                                <p class="text-[10px] text-slate-400 font-mono mt-1">
                                    {{ $item->order_id }}
                                </p>
                            </div>
                        </div>

                        @php
                            $statusLabel = 'Pending';
                            $statusClass = 'bg-orange-100 text-orange-600';
                            if ($item->status == 'menuju lokasi penjemputan') {
                                $statusLabel = 'Menuju Lokasi';
                                $statusClass = 'bg-blue-100 text-blue-600';
                            } elseif ($item->status == 'diambil driver') {
                                $statusLabel = 'Pakaian Diambil';
                                $statusClass = 'bg-green-100 text-green-600';
                            }
                        @endphp
                        <span class="px-4 py-1.5 {{ $statusClass }} text-[10px] font-black uppercase tracking-[0.2em] rounded-full">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    {{-- MAP --}}
                    @if ($item->pelanggan?->latitude && $item->pelanggan?->longitude)
                        @php
                            $destLat = $item->pelanggan->latitude;
                            $destLng = $item->pelanggan->longitude;
                            
                            $outlet = \App\Models\ProfilPerusahaan::first();
                            if ($item->status == 'diambil driver' && $outlet && $outlet->latitude) {
                                $destLat = $outlet->latitude;
                                $destLng = $outlet->longitude;
                            }
                        @endphp
                        <iframe
                            id="map-{{ $item->id }}"
                            class="w-full h-64 rounded-2xl border border-slate-200 dark:border-slate-800"
                            src="https://www.google.com/maps?q={{ $destLat }},{{ $destLng }}&hl=id&z=16&output=embed"
                            loading="lazy">
                        </iframe>
                    @else
                        <div
                            class="w-full h-40 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 text-sm italic">
                            Lokasi pelanggan belum tersedia
                        </div>
                    @endif

                    {{-- ACTION --}}
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-4">

                        <div class="flex items-center gap-4">
                            <a href="https://www.google.com/maps?q={{ $destLat }},{{ $destLng }}"
                               target="_blank"
                               class="flex items-center gap-2 text-slate-400 font-bold text-[10px] uppercase tracking-widest hover:text-slate-600 transition-colors">
                                🧭 Eksternal Maps
                            </a>
                        </div>

                        @if ($item->status == 'menunggu penjemputan')
                            <form action="{{ route('karyawan.driver.jemput', $item->id) }}" method="POST">
                                @csrf
                                <button
                                    class="group bg-slate-900 hover:bg-black text-white px-10 py-4 rounded-2xl font-black text-sm transition-all hover:shadow-2xl hover:shadow-orange-500/20 active:scale-95 flex items-center gap-3">
                                    <span>Mulai Jemput</span>
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </form>
                        @elseif ($item->status == 'menuju lokasi penjemputan')
                            <div class="flex items-center gap-3">
                                <a href="{{ route('karyawan.driver.peta', $item->id) }}"
                                   class="flex items-center gap-2 px-6 py-4 bg-slate-900 text-white rounded-2xl font-black text-sm hover:shadow-xl transition-all active:scale-95">
                                    🗺️ Buka Navigasi App
                                </a>
                                <form action="{{ route('karyawan.driver.sampai', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="group bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-2xl font-black text-sm transition-all hover:shadow-2xl hover:shadow-blue-500/20 active:scale-95 flex items-center gap-3">
                                        <span>Sampai</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            {{-- Script Tracking --}}
                            <div id="tracking-status-{{ $item->id }}" class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800 flex items-center gap-3">
                                <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                                <p class="text-[10px] font-bold text-blue-700 dark:text-blue-300 uppercase tracking-widest leading-none">Pelacakan Aktif</p>
                                <p class="text-[9px] text-blue-500 ml-auto italic">Jangan tutup halaman ini agar pelanggan bisa melacak Anda</p>
                            </div>

                            <script>
                                (function() {
                                    let lastUpdate = 0;
                                    const minInterval = 8000; // Minimal 8 detik antar hit ke server

                                    if ("geolocation" in navigator) {
                                        const watchId = navigator.geolocation.watchPosition((position) => {
                                            const now = Date.now();
                                            if (now - lastUpdate > minInterval) {
                                                lastUpdate = now;
                                                
                                                fetch("{{ route('karyawan.driver.update-lokasi', $item->id) }}", {
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
                        @elseif ($item->status == 'diambil driver')
                             <form action="{{ route('karyawan.driver.terima-kasir', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    class="group bg-green-600 hover:bg-green-700 text-white px-10 py-4 rounded-2xl font-black text-sm transition-all hover:shadow-2xl hover:shadow-green-500/20 active:scale-95 flex items-center gap-3">
                                    <span>Serahkan ke Kasir</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </button>
                            </form>
                        @endif

                    </div>

                </div>
            </div>

        @empty
            <div class="text-center py-24 text-slate-400">
                🚫 Tidak ada tugas penjemputan saat ini
            </div>
        @endforelse
    </div>
</div>

{{-- ANIMATION --}}
<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fadeIn {
    animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
@endsection
