@extends('layouts.backend')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6 animate-fadeIn">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Data Transaksi</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Kelola semua pesanan pelanggan (Member & Guest) di sini.
                </p>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">ID /
                                Tanggal</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Pelanggan
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Layanan
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Total
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Status
                            </th>
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">
                                Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse($transaksi as $t)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <p class="font-mono text-xs font-bold text-brand">#{{ $t->id }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">
                                        {{ $t->created_at->format('d M Y, H:i') }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    @if ($t->pelanggan)
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-black">
                                                MB
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-slate-700 dark:text-slate-200">
                                                    {{ $t->pelanggan->user->name }}
                                                </p>
                                                <p class="text-[10px] text-slate-400">
                                                    {{ $t->pelanggan->no_hp ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    @elseif($t->nama_guest)
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center text-[10px] font-black">
                                                GS
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-slate-700 dark:text-slate-200">
                                                    {{ $t->nama_guest }}
                                                </p>
                                                <p class="text-[10px] text-slate-400">
                                                    {{ $t->no_hp_guest ?? '-' }}
                                                </p>
                                                @if ($t->waktu_ambil)
                                                    <p class="text-[9px] font-black text-brand uppercase mt-0.5">
                                                        Ambil: {{ $t->waktu_ambil }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-[10px] font-black">
                                                GS
                                            </div>
                                            <p class="text-sm font-bold text-slate-400 italic">Pelanggan Umum</p>
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200 capitalize">
                                        {{ $t->layanan->nama_layanan }}
                                    </p>
                                    <p class="text-[10px] text-slate-400">
                                        {{ $t->berat_aktual ?? $t->estimasi_berat }} kg
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <p class="text-sm font-black text-slate-800 dark:text-white">
                                        Rp {{ number_format($t->harga_final ?? $t->harga_estimasi, 0, ',', '.') }}
                                    </p>
                                    <p class="text-[10px] uppercase font-bold text-slate-400">
                                        {{ $t->metode_pembayaran }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    @php
                                        $statusMap = [
                                            'menunggu penjemputan' => 'bg-blue-100 text-blue-600',
                                            'menunggu diantar' => 'bg-indigo-100 text-indigo-600',
                                            'diterima_kasir' => 'bg-cyan-100 text-cyan-600',
                                            'ditimbang' => 'bg-amber-100 text-amber-600',
                                            'diproses' => 'bg-orange-100 text-orange-600',
                                            'menunggu pembayaran' => 'bg-yellow-100 text-yellow-700',
                                            'dibayar' => 'bg-emerald-100 text-emerald-600',
                                            'selesai' => 'bg-green-100 text-green-600',
                                            'dibatalkan' => 'bg-rose-100 text-rose-600',
                                        ];
                                    @endphp

                                    <span
                                        class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider
                                {{ $statusMap[$t->status] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ $t->status }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-center space-x-2">
                                    <a href="{{ route('karyawan.kasir.show', $t->id) }}"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-brand hover:border-brand transition-all"
                                        title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                    <a href="{{ url('karyawan/kasir/struk/' . $t->id) }}" target="_blank"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-brand hover:border-brand transition-all"
                                        title="Cetak Struk">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <span class="text-4xl">📥</span>
                                    <p class="text-slate-400 font-bold mt-3">Belum ada transaksi.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($transaksi->hasPages())
                <div class="px-6 py-4 border-t border-slate-50 dark:border-slate-800">
                    {{ $transaksi->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
