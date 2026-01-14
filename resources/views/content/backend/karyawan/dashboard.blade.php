@extends('layouts.backend')

@section('title', 'Dashboard ' . ucfirst($jabatan))
@section('content')
    <div class="">
        {{-- Header Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center mb-8 md:mb-10">
            <div class="lg:col-span-2 text-left">
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800 dark:text-white">
                    Halo, {{ Auth::user()->name }}! <span class="inline-block animate-bounce">⚡</span>
                </h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400 text-base md:text-lg">
                    Anda login sebagai <span class="font-bold text-brand uppercase">{{ $jabatan }}</span>.
                </p>
            </div>

            {{-- Target Bar: Kasir fokus ke Selesai, Driver fokus ke Pengiriman (Contoh) --}}
            <div
                class="bg-gradient-to-br from-brand to-indigo-700 p-6 rounded-[2rem] flex justify-between items-center shadow-xl shadow-brand/20 relative overflow-hidden group">
                <div class="relative z-10 text-white">
                    <p class="text-[10px] font-bold opacity-80 uppercase tracking-[0.2em]">Target {{ ucfirst($jabatan) }}</p>
                    <p class="text-2xl font-black mt-1">{{ $transaksiSelesaiHariIni }} / {{ $totalTugasHariIni }}</p>
                    <p class="text-[10px]">Tugas Selesai Hari Ini</p>
                </div>
                <div class="text-4xl opacity-30">📊</div>
            </div>
        </div>

        {{-- Stats Cards: Berubah warna/icon berdasarkan Jabatan --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
            @if (str_contains($jabatan, 'kasir'))
                {{-- CARD KHUSUS KASIR (Warna Biru/Emerald) --}}
                <div
                    class="bg-blue-50 dark:bg-blue-950/30 p-5 md:p-6 rounded-[2rem] border border-blue-100 dark:border-blue-900/50">
                    <div
                        class="w-10 h-10 md:w-12 md:h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-blue-500/30">
                        📥</div>
                    <p class="text-blue-600 dark:text-blue-400 font-black text-sm md:text-base">{{ $pesananBaru }}</p>
                    <p class="text-[11px] md:text-sm text-slate-500 font-medium">Pesanan Baru</p>
                </div>

                <div
                    class="bg-amber-50 dark:bg-amber-950/30 p-5 md:p-6 rounded-[2rem] border border-amber-100 dark:border-amber-900/50">
                    <div
                        class="w-10 h-10 md:w-12 md:h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-amber-500/30">
                        🌀</div>
                    <p class="text-amber-600 dark:text-amber-400 font-black text-sm md:text-base">{{ $sedangProses }}</p>
                    <p class="text-[11px] md:text-sm text-slate-500 font-medium">Sedang Dicuci</p>
                </div>

                <div
                    class="bg-purple-50 dark:bg-purple-950/30 p-5 md:p-6 rounded-[2rem] border border-purple-100 dark:border-purple-900/50">
                    <div
                        class="w-10 h-10 md:w-12 md:h-12 bg-purple-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-purple-500/30">
                        🧺</div>
                    <p class="text-purple-600 dark:text-purple-400 font-black text-sm md:text-base">{{ $siapDiambil }}</p>
                    <p class="text-[11px] md:text-sm text-slate-500 font-medium">Siap Diambil</p>
                </div>

                <div
                    class="bg-rose-50 dark:bg-rose-950/30 p-5 md:p-6 rounded-[2rem] border border-rose-100 dark:border-rose-900/50 flex flex-col justify-center items-center text-center cursor-pointer hover:bg-rose-100 transition-colors border-dashed">
                    <a href="{{-- {{ route('karyawan.transaksi.create') }} --}}">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-rose-500 rounded-full flex items-center justify-center text-white text-lg md:text-xl mb-2">
                            +</div>
                        <p class="text-rose-600 dark:text-rose-400 font-black text-xs md:text-sm uppercase">Transaksi Baru
                        </p>
                    </a>
                </div>
                {{-- ... card kasir lainnya ... --}}
            @else
                {{-- CARD KHUSUS DRIVER (Warna Orange/Amber) --}}
                <div class="bg-orange-50 dark:bg-orange-950/30 p-5 rounded-[2rem] border border-orange-100">
                    <div class="w-10 h-10 bg-orange-500 rounded-2xl flex items-center justify-center text-white mb-4">🚚
                    </div>
                    <p class="text-orange-600 font-black text-lg">{{ $antreanTugas->count() }}</p>
                    <p class="text-xs text-slate-500 font-medium">Titik Antar/Jemput</p>
                </div>
            @endif

            {{-- Tombol Aksi Cepat Dinamis --}}
            @if (str_contains($jabatan, 'driver'))
                <div
                    class="bg-slate-900 p-5 rounded-[2rem] flex flex-col justify-center items-center text-center cursor-pointer hover:bg-black transition-all">
                    <a href="#">
                        <div class="text-white text-xl mb-1">📍</div>
                        <p class="text-white font-bold text-[10px] uppercase">Buka Peta</p>
                    </a>
                </div>
            @endif
        </div>

        {{-- Tabel Antrean: Kolom Berubah Sesuai Jabatan --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Antrean Tugas Terbaru</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                            <th class="px-4 py-2">Pelanggan & @if (str_contains($jabatan, 'driver'))
                                    Lokasi
                                @else
                                    Status
                                @endif
                            </th>
                            @if (str_contains($jabatan, 'kasir'))
                                <th class="px-4 py-2">Layanan</th>
                            @endif
                                <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($antreanTugas as $item)
                            <tr class="bg-slate-50/50 dark:bg-slate-800/40 transition-colors">
                                <td class="px-4 py-4 rounded-l-[1.5rem]">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-brand/10 text-brand flex items-center justify-center font-bold">
                                            {{ substr($item->pelanggan->user->name ?? '?', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 dark:text-white">
                                                {{ $item->pelanggan->user->name ?? 'User' }}</p>
                                            {{-- TAMPILKAN ALAMAT JIKA DRIVER --}}
                                            @if (str_contains($jabatan, 'driver'))
                                                <p class="text-[10px] text-slate-500 line-clamp-1 max-w-[200px]">
                                                    📍 {{ $item->pelanggan->alamat_lengkap ?? 'Alamat tidak diisi' }}
                                                </p>
                                            @else
                                                <p class="text-[10px] text-slate-400 font-mono">#INV-{{ $item->id }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                @if (str_contains($jabatan, 'kasir'))
                                    <td class="px-4 py-4">
                                        <span
                                            class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ $item->layanan->nama_layanan }}</span>
                                    </td>
                                @endif


                                <td class="px-4 py-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                                    {{ $item->status == 'baru' ? 'bg-blue-100 text-blue-600' : 'bg-amber-100 text-amber-600' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 rounded-r-[1.5rem] text-right">
                                    @if (str_contains($jabatan, 'driver'))
                                        <a href="https://www.google.com/maps?q={{ $item->pelanggan->latitude }},{{ $item->pelanggan->longitude }}"
                                            target="_blank"
                                            class="inline-block bg-orange-100 text-orange-600 p-2 rounded-xl">
                                            🧭
                                        </a>
                                    @else
                                        <button class="bg-brand/10 text-brand p-2 rounded-xl">
                                            ✅
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            {{-- Empty state --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
