@extends('layouts.backend')

@section('title', 'Lacak Driver')

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-fadeIn">
    {{-- HEADER --}}
    <div class="text-center">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
            📍 Lacak Penjemputan
        </h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
            Pesanan #TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}
        </p>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden relative p-8 space-y-6">
        
        {{-- DRIVER INFO --}}
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black text-xl">
                {{ substr($transaksi->driver?->user?->name ?? 'D', 0, 1) }}
            </div>
            <div>
                <p class="text-lg font-black text-slate-800 dark:text-white">
                    {{ $transaksi->driver?->user?->name ?? 'Driver Sedang Menuju' }}
                </p>
                <p class="text-sm text-slate-500">
                    Status: <span class="font-bold text-blue-600">{{ ucfirst($transaksi->status) }}</span>
                </p>
            </div>
        </div>

        {{-- MAP --}}
        <div class="relative">
            <iframe
                id="tracking-map"
                class="w-full h-96 rounded-2xl border border-slate-200 dark:border-slate-800"
                src="https://www.google.com/maps?q={{ $transaksi->driver_latitude ?? $transaksi->pelanggan?->latitude }},{{ $transaksi->driver_longitude ?? $transaksi->pelanggan?->longitude }}&hl=id&z=17&output=embed"
                loading="lazy">
            </iframe>
            
            @if(!$transaksi->driver_latitude)
            <div class="absolute inset-0 bg-slate-900/10 backdrop-blur-sm flex items-center justify-center rounded-2xl">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-xl text-center">
                    <p class="text-sm font-bold">Menunggu lokasi driver...</p>
                </div>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl">
                <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">Estimasi Tiba</p>
                <p class="text-lg font-black text-slate-800 dark:text-white">-- Menit</p>
            </div>
            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl">
                <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">Jarak</p>
                <p class="text-lg font-black text-slate-800 dark:text-white">-- Km</p>
            </div>
        </div>

        <p class="text-xs text-center text-slate-400 italic">
            Halaman ini akan memperbarui lokasi driver secara otomatis setiap 30 detik.
        </p>
    </div>
</div>

<script>
    // Refresh halaman setiap 30 detik untuk update lokasi driver
    setInterval(() => {
        window.location.reload();
    }, 30000);
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
@endsection
