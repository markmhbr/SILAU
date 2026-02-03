@extends('layouts.backend')

@section('title', 'Pengantaran')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <h1 class="text-2xl font-black text-slate-800">
            🗺️ Tugas Pengantaran
        </h1>

        @forelse ($tugasAntar as $item)
            <div class="bg-white rounded-xl shadow p-6 space-y-4">

                {{-- INFO --}}
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-lg">
                            {{ $item->pelanggan->user->name }}
                        </p>
                        <p class="text-sm text-slate-600">
                            {{ $item->pelanggan->alamat }}
                        </p>
                    </div>

                    <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700">
                        Siap Diantar
                    </span>
                </div>

                {{-- MAP --}}
                <div class="rounded-xl overflow-hidden border">
                    <iframe width="100%" height="250" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q={{ $item->pelanggan->latitude }},{{ $item->pelanggan->longitude }}&output=embed">
                    </iframe>
                </div>

                <a href="https://www.google.com/maps?q={{ $item->pelanggan->latitude }},{{ $item->pelanggan->longitude }}"
                    target="_blank" class="text-orange-600 font-bold text-xs uppercase tracking-widest">
                    🧭 Buka Google Maps
                </a>


                {{-- AKSI --}}
                <form action="{{ route('karyawan.driver.antar', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <button class="w-full py-3 rounded-xl bg-brand text-white font-bold hover:scale-[1.02] transition">
                        🧭 Mulai Antar
                    </button>
                </form>

            </div>
        @empty
            <div class="text-center text-slate-500 py-20">
                Tidak ada tugas pengantaran 🚚
            </div>
        @endforelse

    </div>
@endsection
