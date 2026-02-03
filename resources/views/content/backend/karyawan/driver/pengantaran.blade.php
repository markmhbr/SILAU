@extends('layouts.backend')

@section('title', 'Tugas Pengantaran')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <h1 class="text-2xl font-black text-slate-800">
            🗺️ Tugas Pengantaran
        </h1>

        @forelse ($tugasAntar as $item)
            <div class="bg-white rounded-xl shadow p-6 space-y-4">

                {{-- INFO PELANGGAN --}}
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-lg">
                            {{ $item->pelanggan->user->name ?? 'Pelanggan' }}
                        </p>
                        <p class="text-sm text-slate-600">
                            📍 {{ $item->pelanggan->alamat }}
                        </p>
                        <p class="text-xs text-slate-400 mt-1">
                            ID Order: #{{ $item->order_id }}
                        </p>
                    </div>

                    <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700 font-medium">
                        Siap Diantar
                    </span>
                </div>

                {{-- MAPS --}}
                <div class="rounded-xl overflow-hidden border">
                    <iframe width="100%" height="250" style="border:0" loading="lazy" allowfullscreen
                        src="https://www.google.com/maps?q={{ $item->pelanggan->latitude }},{{ $item->pelanggan->longitude }}&hl=es;z=14&output=embed">
                    </iframe>
                </div>

                <a href="https://www.google.com/maps/search/?api=1&query={{ $item->pelanggan->latitude }},{{ $item->pelanggan->longitude }}"
                    target="_blank" class="inline-block text-orange-600 font-bold text-xs uppercase tracking-widest hover:underline">
                    🧭 Buka di Google Maps App
                </a>

                {{-- AKSI --}}
                <form action="{{ route('karyawan.driver.antar', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    {{-- Catatan dari Kasir jika ada --}}
                    @if($item->catatan)
                        <div class="p-3 bg-slate-50 rounded-lg text-sm text-slate-600 mb-3 italic">
                            "{{ $item->catatan }}"
                        </div>
                    @endif

                    <button type="submit" onclick="return confirm('Selesaikan pengantaran ini?')" 
                        class="w-full py-3 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700 transition">
                        ✅ Selesaikan Pengantaran
                    </button>
                </form>

            </div>
        @empty
            <div class="text-center bg-white rounded-xl py-20 shadow">
                <div class="text-5xl mb-4">🚚</div>
                <p class="text-slate-500 font-medium">Tidak ada tugas pengantaran saat ini.</p>
            </div>
        @endforelse

    </div>
@endsection