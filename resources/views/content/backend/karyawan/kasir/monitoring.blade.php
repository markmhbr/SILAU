@extends('layouts.backend')

@section('title', 'Monitoring Driver')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fadeIn">
    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
                🚛 Monitoring Driver
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Pantau lokasi driver yang sedang bertugas penjemputan secara real-time
            </p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-green-100 text-green-600 rounded-full text-[10px] font-black uppercase tracking-widest animate-pulse">
            <span class="w-2 h-2 bg-green-600 rounded-full"></span>
            Real-time Live
        </div>
    </div>

    {{-- DRIVER LIST & MAP --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- LIST --}}
        <div class="lg:col-span-1 space-y-4">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Driver Aktif ({{ $activeDrivers->count() }})</h3>
            
            <div class="space-y-3">
                @forelse($activeDrivers as $item)
                <div class="p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl flex items-center gap-4 hover:shadow-lg transition cursor-pointer" onclick="focusDriver('{{ $item->driver_latitude }}', '{{ $item->driver_longitude }}', '{{ $item->id }}')">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-black">
                        {{ substr($item->driver?->user?->name ?? 'D', 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-black text-slate-800 dark:text-white truncate">
                            {{ $item->driver?->user?->name ?? 'Unknown' }}
                        </p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">
                            {{ str_replace('_', ' ', $item->status) }}
                        </p>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-400 italic text-sm bg-slate-100/50 dark:bg-slate-800/50 rounded-2xl border border-dashed border-slate-300 dark:border-slate-700">
                    Tidak ada driver aktif saat ini
                </div>
                @endforelse
            </div>
        </div>

        {{-- MAP --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2.5rem] shadow-sm overflow-hidden p-2">
                <iframe
                    id="monitoring-map"
                    class="w-full h-[500px] rounded-[2rem]"
                    src="https://www.google.com/maps?q={{ $outlet->latitude ?? '-6.200000' }},{{ $outlet->longitude ?? '106.816666' }}&hl=id&z=13&output=embed"
                    loading="lazy">
                </iframe>
            </div>
            
            <div class="flex items-center justify-between text-xs text-slate-500 font-medium px-4">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 bg-blue-500 rounded-full"></span> Menuju Lokasi</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 bg-green-500 rounded-full"></span> Pakaian Diambil</span>
                </div>
                <p>Klik driver untuk fokus pada lokasi mereka</p>
            </div>
        </div>
    </div>
</div>

<script>
    function focusDriver(lat, lng, id) {
        if (!lat || !lng) return;
        const iframe = document.getElementById('monitoring-map');
        iframe.src = `https://www.google.com/maps?q=${lat},${lng}&hl=id&z=17&output=embed`;
    }

    // Auto refresh every 60 seconds
    setInterval(() => {
        window.location.reload();
    }, 60000);
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-page {
    animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
@endsection
