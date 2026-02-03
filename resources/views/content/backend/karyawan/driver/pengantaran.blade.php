@extends('layouts.backend')

@section('title', 'Tugas Pengantaran')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8 animate-fadeIn">

        <div>
            <nav class="flex text-[10px] uppercase tracking-widest text-slate-400 mb-2 space-x-2 font-bold">
                <a href="{{ route('karyawan.dashboard') }}" class="hover:text-brand transition">Home</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Pengantaran</span>
            </nav>
            <h2 class="text-2xl font-black text-slate-800">
                🗺️ Tugas Pengantaran
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Daftar pelanggan yang harus diantar oleh driver hari ini
            </p>
        </div>

        @forelse ($tugasAntar as $item)
            <div class="bg-white rounded-xl shadow p-6 space-y-4">

                {{-- INFO PELANGGAN --}}
                <div class="flex justify-between items-start">
                    <div class="flex gap-4">
                        {{-- Logika Foto vs Inisial --}}
                        @if ($item->pelanggan->foto)
                            <img src="{{ $item->pelanggan->foto_url }}" class="w-12 h-12 rounded-full object-cover border shadow-sm" alt="Avatar">
                        @else
                            <div class="w-12 h-12 rounded-full bg-brand/10 border border-brand/20 flex items-center justify-center shadow-sm">
                                <span class="text-brand font-bold text-lg">
                                    {{ strtoupper(substr($item->pelanggan->user->name ?? 'P', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                        
                        <div>
                            <p class="font-bold text-lg leading-none">
                                {{ $item->pelanggan->user->name ?? '...' }}
                            </p>
                            <p class="text-sm text-slate-600 mt-1">
                                📍 {{ $item->pelanggan->alamat_gabungan ?? '...' }}
                            </p>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-xs font-mono bg-slate-100 px-2 py-1 rounded text-slate-500">
                                    #{{ $item->order_id ?? '...' }}
                                </span>
                                @if($item->pelanggan->no_hp)
                                    <a href="https://wa.me/{{ $item->pelanggan->no_hp }}" target="_blank" class="text-xs text-green-600 font-bold hover:underline">
                                        📞 Hubungi: {{ $item->pelanggan->no_hp }}
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">📞 No. HP tidak ada</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700 font-bold uppercase tracking-wider">
                        Siap Diantar
                    </span>
                </div>

                {{-- MAPS --}}
                <div class="rounded-xl overflow-hidden border">
                    @if($item->pelanggan->latitude && $item->pelanggan->longitude)
                        <iframe width="100%" height="250" style="border:0" loading="lazy" allowfullscreen
                            src="https://maps.google.com/maps?q={{ $item->pelanggan->latitude }},{{ $item->pelanggan->longitude }}&hl=id&z=15&output=embed">
                        </iframe>
                    @else
                        <div class="h-[250px] bg-slate-100 flex flex-col items-center justify-center text-slate-400 text-sm italic">
                            <svg class="w-8 h-8 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Koordinat lokasi tidak tersedia
                        </div>
                    @endif
                </div>

                @if($item->pelanggan->latitude)
                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $item->pelanggan->latitude }},{{ $item->pelanggan->longitude }}"
                    target="_blank"
                    class="inline-block text-brand font-bold text-xs uppercase tracking-widest hover:underline">
                    🧭 Petunjuk Arah (Google Maps)
                </a>
                @endif

                {{-- AKSI --}}
                <form action="{{ route('karyawan.driver.antar', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    @if ($item->catatan)
                        <div class="p-3 bg-amber-50 border border-amber-100 rounded-lg text-sm text-amber-700 mb-3">
                            <strong>Catatan:</strong> "{{ $item->catatan }}"
                        </div>
                    @endif

                    <button type="submit" onclick="return confirm('Konfirmasi bahwa pesanan ini telah sampai di tangan pelanggan?')"
                        class="w-full py-4 rounded-xl bg-slate-900 text-white font-bold hover:bg-black transition shadow-lg shadow-slate-200">
                        ✅ Selesaikan Pengantaran
                    </button>
                </form>

            </div>
        @empty
            <div class="text-center bg-white rounded-2xl py-20 shadow-sm border border-dashed border-slate-300">
                <div class="text-6xl mb-4 text-slate-300">🚚</div>
                <p class="text-slate-500 font-medium">Belum ada paket yang siap diantar.</p>
                <p class="text-xs text-slate-400 mt-1">Halaman ini akan otomatis terisi saat admin/kasir merubah status pesanan.</p>
            </div>
        @endforelse

    </div>
@endsection