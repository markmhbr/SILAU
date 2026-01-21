@extends('layouts.backend')

@section('title', 'Layanan Saya')

@section('content')
<div class="space-y-8 animate-fadeIn">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <nav class="flex text-[10px] uppercase tracking-widest text-slate-400 mb-2 space-x-2 font-bold">
                <a href="#" class="hover:text-brand transition">Home</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Layanan & Riwayat</span>
            </nav>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Riwayat Layanan</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Pantau status cucian dan riwayat transaksi Anda secara real-time.</p>
        </div>
    </div>

    <div class="bg-cyan-50/50 dark:bg-cyan-950/20 border border-cyan-100 dark:border-cyan-800/50 p-5 rounded-[2rem] flex items-start gap-4 backdrop-blur-sm">
        <div class="w-12 h-12 bg-white dark:bg-slate-800 text-cyan-500 rounded-2xl flex items-center justify-center shrink-0 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="text-sm">
            <p class="font-bold text-cyan-900 dark:text-cyan-200 uppercase tracking-widest text-[10px] mb-1">Tips Navigasi</p>
            <p class="text-cyan-700/80 dark:text-cyan-400/80 leading-relaxed">Geser tabel ke samping <span class="md:hidden font-bold text-brand">👉</span> untuk melihat detail harga dan status lengkap.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-slate-200 dark:scrollbar-thumb-slate-800">
                <table id="userLayananTable" class="w-full min-w-[1000px] text-sm text-left border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-slate-400 dark:text-slate-500 uppercase text-[11px] tracking-[0.15em] font-black">
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th class="px-6 py-4">Layanan & Jenis</th>
                            <th class="px-6 py-4">Berat</th>
                            <th class="px-4 py-4 text-right">Hemat (Diskon)</th>
                            <th class="px-6 py-4 text-right">Total Bayar</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-0">
                        @foreach($transaksis as $transaksi)
                        <tr class="group bg-slate-50/50 dark:bg-slate-800/30 hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 shadow-sm hover:shadow-md">
                            <td class="px-6 py-5 text-center text-slate-400 font-mono rounded-l-2xl border-y border-l border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-5 border-y border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700">
                                <div class="font-bold text-slate-800 dark:text-white group-hover:text-brand transition-colors whitespace-nowrap">{{ $transaksi->layanan->nama_layanan }}</div>
                                <div class="text-[10px] bg-brand/10 text-brand px-2 py-0.5 rounded-md inline-block mt-1 font-black uppercase tracking-tighter">
                                    {{ $transaksi->layanan->jenis_layanan }}
                                </div>
                            </td>
                            <td class="px-6 py-5 font-bold text-slate-600 dark:text-slate-300 border-y border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700 whitespace-nowrap">
                                {{ intval($transaksi->berat) == $transaksi->berat ? intval($transaksi->berat) : $transaksi->berat }} <span class="text-[10px] font-normal text-slate-400 uppercase">kg</span>
                            </td>
                            <td class="px-4 py-5 text-right border-y border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700 whitespace-nowrap">
                                @php
                                    $diskonNominal = 0;
                                    if($transaksi->diskon){
                                        $diskonNominal = ($transaksi->diskon->tipe === 'persentase') 
                                            ? ($transaksi->layanan->harga_perkilo * $transaksi->berat) * $transaksi->diskon->nilai / 100 
                                            : $transaksi->diskon->nilai;
                                    }
                                @endphp
                                @if($diskonNominal > 0)
                                    <div class="text-rose-500 font-bold">- Rp {{ number_format($diskonNominal,0,',','.') }}</div>
                                @else
                                    <span class="text-slate-300 dark:text-slate-600">--</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-right border-y border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700 whitespace-nowrap">
                                <span class="font-black text-slate-900 dark:text-white text-base">
                                    Rp {{ number_format($transaksi->harga_after_diskon ?? $transaksi->harga_setelah_diskon, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center border-y border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700">
    @php
        $statusMap = [
            'pending'             => 'bg-slate-100 text-slate-500 dark:bg-slate-700/50 dark:text-slate-400 border-slate-200',
            'menunggu konfirmasi' => 'bg-amber-100 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 border-amber-200',
            'proses'              => 'bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 border-blue-200',
            'sedang diantar'      => 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 border-indigo-200',
            'selesai'             => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border-emerald-200',
        ];
        
        // Mengambil style berdasarkan status, default ke warna rose jika status tidak terdaftar
        $currentStatus = $statusMap[strtolower($transaksi->status)] ?? 'bg-rose-100 text-rose-600 border-rose-200';
    @endphp
    
    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-[0.1em] border {{ $currentStatus }} whitespace-nowrap">
        {{ $transaksi->status }}
    </span>
</td>
                            <td class="px-6 py-5 text-center rounded-r-2xl border-y border-r border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700">
                                <a href="{{ route('pelanggan.layanan.detail', $transaksi->id) }}" 
                                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white dark:bg-slate-700 text-slate-400 hover:text-brand hover:shadow-md transition-all border border-slate-100 dark:border-slate-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Agar scrollbar tetap estetik */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    .overflow-x-auto::-webkit-scrollbar-track {
        background: transparent;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .dark .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #1e293b;
    }
</style>
@endsection