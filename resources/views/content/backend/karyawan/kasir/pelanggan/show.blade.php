@extends('layouts.backend')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-fadeIn">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white">Detail Pelanggan</h2>
            <p class="text-sm text-slate-500 mt-1">Informasi pelanggan dan riwayat transaksi</p>
        </div>

        <a href="{{ route('karyawan.kasir.pelanggan') }}"
            class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-black hover:border-brand transition">
            ← Kembali
        </a>
    </div>

    {{-- DATA PELANGGAN --}}
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                <tr>
                    <td class="px-6 py-5 w-64 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Pelanggan</td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-brand/10 text-brand flex items-center justify-center font-bold">
                                {{ strtoupper(substr($pelanggan->user->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-700 dark:text-slate-200">{{ $pelanggan->user->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $pelanggan->user->email }}</p>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">No HP / WhatsApp</td>
                    <td class="px-6 py-5 text-sm font-bold">{{ $pelanggan->no_hp ?? '-' }}</td>
                </tr>

                <tr>
                        <td class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                            Alamat
                        </td>
                        <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">
                            {{ $pelanggan->alamat_gabungan ?? '-' }}

                            @if ($pelanggan->latitude && $pelanggan->longitude)
                                <div class="mt-2">
                                    <a href="https://www.google.com/maps?q={{ $pelanggan->latitude }},{{ $pelanggan->longitude }}"
                                        target="_blank" class="text-xs font-bold text-blue-500">
                                        🗺️ Lihat di Google Maps
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>

                <tr>
                    <td class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Total Transaksi</td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black bg-emerald-100 text-emerald-600">
                            {{ $pelanggan->transaksi->count() }} Kali
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- RIWAYAT TRANSAKSI --}}
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-50 dark:border-slate-800">
            <h3 class="text-lg font-black text-slate-800 dark:text-white">Riwayat Transaksi</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Order ID / Tgl</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Layanan</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Berat</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Total Tagihan</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($pelanggan->transaksi->sortByDesc('created_at') as $t)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition">
                            <td class="px-6 py-5">
                                <p class="font-mono text-xs font-bold text-brand">{{ $t->order_id ?? '#'.$t->id }}</p>
                                <p class="text-[10px] text-slate-400">{{ $t->created_at->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-5 text-sm font-bold">{{ $t->layanan->nama_layanan }}</td>
                            <td class="px-6 py-5 text-sm">
                                {{-- Menampilkan berat aktual jika ada, jika tidak pakai estimasi --}}
                                {{ $t->berat_aktual ?? $t->estimasi_berat }} kg
                            </td>
                            <td class="px-6 py-5 text-sm font-black">
                                {{-- Menampilkan harga final jika ada, jika tidak pakai estimasi --}}
                                Rp {{ number_format($t->harga_final ?? $t->harga_estimasi, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black 
                                    {{ $t->status == 'selesai' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                    {{ strtoupper($t->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 font-bold">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection