@extends('layouts.home')

@section('title', 'Layanan Saya')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Layanan & Riwayat</h2>
            <p class="text-sm text-slate-500">Pantau status cucian dan riwayat transaksi Anda</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">Layanan</span>
        </nav>
    </div>

    <div class="bg-cyan-50 dark:bg-cyan-900/20 border border-cyan-100 dark:border-cyan-800 p-4 rounded-2xl flex items-start gap-4">
        <div class="w-10 h-10 bg-cyan-500 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-cyan-500/20">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="text-sm text-cyan-800 dark:text-cyan-300">
            <p class="font-bold mb-1">Catatan Pelanggan:</p>
            <p>Gunakan tombol <i class="fas fa-eye mx-1"></i> untuk melihat detail rincian nota dan melacak progres layanan laundry Anda secara real-time.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-white dark:bg-slate-800">
            <h3 class="font-bold text-slate-800 dark:text-white">Riwayat Layanan</h3>
            <a href="{{ route('pelanggan.layanan.create') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm shadow-primary-500/20">
                <i class="fas fa-plus text-xs"></i> Pesan Laundry
            </a>
        </div>

        <div class="p-6">
            <table id="userLayananTable" class="w-full text-sm text-left">
                <thead>
                    <tr class="text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700 uppercase text-[11px] tracking-wider font-bold">
                        <th class="px-4 py-4 text-center">No</th>
                        <th class="px-4 py-4">Layanan</th>
                        <th class="px-4 py-4">Berat</th>
                        <th class="px-4 py-4">Hemat (Diskon)</th>
                        <th class="px-4 py-4">Total Bayar</th>
                        <th class="px-4 py-4 text-center">Status</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach($transaksis as $transaksi)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-4 py-4 text-center text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4">
                            <div class="font-bold text-slate-900 dark:text-white">{{ $transaksi->layanan->nama_layanan }}</div>
                            <div class="text-[10px] text-primary-500 font-bold uppercase tracking-tight">{{ $transaksi->layanan->jenis_layanan }}</div>
                        </td>
                        <td class="px-4 py-4 font-medium text-slate-700 dark:text-slate-300">
                            {{ intval($transaksi->berat) == $transaksi->berat ? intval($transaksi->berat) : $transaksi->berat }} kg
                        </td>
                        <td class="px-4 py-4">
                            @php
                                $diskonNominal = 0;
                                if($transaksi->diskon){
                                    if($transaksi->diskon->tipe === 'persentase'){
                                        $diskonNominal = ($transaksi->layanan->harga_perkilo * $transaksi->berat) * $transaksi->diskon->nilai / 100;
                                    } else {
                                        $diskonNominal = $transaksi->diskon->nilai;
                                    }
                                }
                            @endphp
                            @if($diskonNominal > 0)
                                <span class="text-rose-500 font-medium">- Rp {{ number_format($diskonNominal,0,',','.') }}</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <span class="font-bold text-emerald-600 dark:text-emerald-400 text-base">
                                Rp {{ number_format($transaksi->harga_setelah_diskon, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            @php
                                $statusMap = [
                                    'proses' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                                    'selesai' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                                    'pending' => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400'
                                ];
                                $currentStatus = $statusMap[$transaksi->status] ?? 'bg-rose-100 text-rose-700';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $currentStatus }}">
                                {{ $transaksi->status }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('pelanggan.layanan.detail', $transaksi->id) }}" 
                               class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-cyan-50 text-cyan-600 hover:bg-cyan-600 hover:text-white transition-all shadow-sm"
                               title="Lihat Detail">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#userLayananTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "search": "",
                "searchPlaceholder": "Cari riwayat...",
                "lengthMenu": "_MENU_",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });

        $('.dataTables_filter input').addClass('bg-slate-100 dark:bg-slate-700 border-transparent rounded-xl text-sm focus:ring-2 focus:ring-cyan-500 outline-none px-4 py-2 w-64 mb-4 transition-all');
        $('.dataTables_length select').addClass('bg-slate-100 dark:bg-slate-700 border-transparent rounded-lg text-sm px-2 py-1 outline-none');
    });
</script>

<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0 !important; margin: 0 2px !important; border: none !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: transparent !important; }
    .dataTables_paginate .paginate_button i {
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
        border-radius: 10px; background: #f1f5f9; color: #64748b; transition: all 0.2s;
    }
    .dark .dataTables_paginate .paginate_button i { background: #334155; color: #94a3b8; }
    .dataTables_paginate .paginate_button.current i { background: #06b6d4; color: white; }
</style>
@endsection