@extends('layouts.home')

@section('title', 'Data Transaksi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Daftar Transaksi</h2>
            <p class="text-sm text-slate-500">Pantau dan kelola semua pesanan laundry pelanggan</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">Transaksi</span>
        </nav>
    </div>

    <div class="bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 rounded-2xl flex items-start gap-4 shadow-sm">
        <div class="w-10 h-10 bg-primary-600 text-white rounded-xl flex items-center justify-center shrink-0">
            <i class="fas fa-exchange-alt"></i>
        </div>
        <div class="text-sm text-slate-600 dark:text-slate-300">
            <p class="font-bold mb-1">Informasi Kelola:</p>
            <div class="flex flex-wrap gap-4 text-xs">
                <span class="flex items-center gap-1.5"><i class="fas fa-edit text-blue-500"></i> Edit rincian.</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-file-invoice text-slate-500"></i> Cetak nota/invoice.</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-trash text-rose-500"></i> Hapus transaksi.</span>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-white dark:bg-slate-800 sticky left-0">
            <h3 class="font-bold text-slate-800 dark:text-white">Data Transaksi</h3>
            <a href="{{ route('admin.transaksi.create') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm shadow-primary-500/20">
                <i class="fas fa-plus text-xs"></i> Transaksi Baru
            </a>
        </div>

        <div class="p-6">
            <table id="transaksiTable" class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700 uppercase text-[11px] tracking-wider font-bold">
                        <th class="px-4 py-4 text-center">No</th>
                        <th class="px-4 py-4 text-center">Pelanggan</th>
                        <th class="px-4 py-4">Layanan</th>
                        <th class="px-4 py-4">Berat</th>
                        <th class="px-4 py-4">Total Harga</th>
                        <th class="px-4 py-4 text-center">Status</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach($transaksis as $transaksi)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-4 py-4 text-center font-medium text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4">
                            <div class="font-bold text-slate-900 dark:text-white">{{ $transaksi->pelanggan?->user?->name ?? 'Umum' }}</div>
                            <div class="text-[10px] text-slate-400">ID: #{{ $transaksi->id }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-slate-700 dark:text-slate-300 font-medium">{{ $transaksi->layanan->nama_layanan }}</div>
                            <div class="text-[10px] uppercase tracking-wider text-primary-500 font-bold">{{ $transaksi->layanan->jenis_layanan }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="font-semibold text-slate-900 dark:text-white">
                                {{ intval($transaksi->berat) == $transaksi->berat ? intval($transaksi->berat) : $transaksi->berat }} kg
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                Rp {{ number_format($transaksi->harga_total, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400',
                                    'proses'  => 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800',
                                    'selesai' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800',
                                    'diambil' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400'
                                ];
                                $currentClass = $statusClasses[$transaksi->status] ?? 'bg-rose-50 text-rose-600';
                            @endphp
                            
                            <form action="{{ route('admin.transaksi.status', $transaksi->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="button" class="btn-status px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-transform hover:scale-105 {{ $currentClass }}">
                                    {{ $transaksi->status }}
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Edit --}}
                                <a href="{{ route('admin.transaksi.edit', $transaksi->id) }}" 
                                   class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-blue-900/30 transition-all" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                
                                {{-- Invoice --}}
                                <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" 
                                   class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-600 hover:text-white dark:bg-slate-700 dark:text-slate-300 transition-all" title="Nota">
                                    <i class="fas fa-file-invoice text-xs"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-900/30 transition-all" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
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
        $('#transaksiTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "search": "",
                "searchPlaceholder": "Cari data transaksi...",
                "lengthMenu": "_MENU_",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });

        $('.dataTables_filter input').addClass('bg-slate-100 dark:bg-slate-700 border-transparent rounded-xl text-sm focus:ring-2 focus:ring-primary-500 outline-none px-4 py-2 w-64 mb-4 transition-all');
        $('.dataTables_length select').addClass('bg-slate-100 dark:bg-slate-700 border-transparent rounded-lg text-sm px-2 py-1 outline-none transition-all');
    });
</script>

<style>
    /* Styling khusus tombol paginasi */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0 !important;
        margin: 0 2px !important;
        border: none !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: transparent !important; }
    .dataTables_paginate .paginate_button i {
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
        border-radius: 10px; background: #f1f5f9; color: #64748b; transition: all 0.2s;
    }
    .dark .dataTables_paginate .paginate_button i { background: #334155; color: #94a3b8; }
    .dataTables_paginate .paginate_button.current i { background: #2563eb; color: white; }
</style>
@endsection