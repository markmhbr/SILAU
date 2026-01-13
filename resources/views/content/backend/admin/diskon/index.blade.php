@extends('layouts.home')

@section('title', 'Manajemen Diskon')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Manajemen Diskon</h2>
            <p class="text-sm text-slate-500">Kelola potongan harga dan promosi laundry</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">Diskon</span>
        </nav>
    </div>

    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 p-4 rounded-2xl flex items-start gap-4">
        <div class="w-10 h-10 bg-amber-500 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-amber-500/20">
            <i class="fas fa-tags text-sm"></i>
        </div>
        <div class="text-sm text-amber-800 dark:text-amber-300">
            <p class="font-bold mb-1">Panduan Pengelolaan:</p>
            <div class="flex flex-wrap gap-4 text-xs">
                <span class="flex items-center gap-1.5"><i class="fas fa-check-circle text-emerald-500"></i> Aktifkan diskon agar muncul di transaksi.</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-edit"></i> Edit data untuk mengubah minimal transaksi.</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-trash text-rose-500"></i> Diskon yang dihapus tidak bisa dikembalikan.</span>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 dark:text-white">Daftar Promo & Diskon</h3>
            <a href="{{ route('admin.diskon.create') }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-md shadow-amber-500/20">
                <i class="fas fa-plus text-xs"></i> Tambah Diskon
            </a>
        </div>

        <div class="p-6">
            <table id="diskonTable" class="w-full text-sm text-left">
                <thead>
                    <tr class="text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700 uppercase text-[11px] tracking-wider">
                        <th class="px-4 py-4 font-bold text-center w-12">No</th>
                        <th class="px-4 py-4 font-bold">Nama Diskon</th>
                        <th class="px-4 py-4 font-bold">Tipe</th>
                        <th class="px-4 py-4 font-bold">Nilai</th>
                        <th class="px-4 py-4 font-bold">Min. Transaksi</th>
                        <th class="px-4 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach($diskon as $key => $d)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-4 py-4 text-center text-slate-500">{{ $key + 1 }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg {{ (int)$d->aktif === 1 ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-slate-100 text-slate-400 dark:bg-slate-700' }} flex items-center justify-center">
                                    <i class="fas fa-ticket-alt text-xs"></i>
                                </div>
                                <span class="font-bold text-slate-900 dark:text-white">{{ $d->nama_diskon }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 uppercase text-[10px] font-bold tracking-widest text-slate-400">
                            {{ $d->tipe }}
                        </td>
                        <td class="px-4 py-4 font-bold text-emerald-600 dark:text-emerald-400">
                            {{ (float)$d->nilai }}{{ $d->tipe === 'persentase' ? '%' : ' Rp' }}
                        </td>
                        <td class="px-4 py-4 text-slate-600 dark:text-slate-400">
                            Rp {{ number_format($d->minimal_transaksi, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Toggle Aktif/Nonaktif --}}
                                <form action="{{ route('admin.diskon.toggle', $d->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl transition-all {{ (int)$d->aktif === 1 ? 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-900/30' : 'bg-slate-100 text-slate-400 hover:bg-slate-600 hover:text-white dark:bg-slate-700' }}" title="{{ (int)$d->aktif === 1 ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas {{ (int)$d->aktif === 1 ? 'fa-check-circle' : 'fa-power-off' }} text-sm"></i>
                                    </button>
                                </form>
                              
                                {{-- Edit --}}
                                <a href="{{ route('admin.diskon.edit', $d->id) }}" 
                                   class="w-9 h-9 flex items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                              
                                {{-- Hapus --}}
                                <form action="{{ route('admin.diskon.destroy', $d->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white transition-all">
                                        <i class="fas fa-trash text-sm"></i>
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
        $('#diskonTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "search": "",
                "searchPlaceholder": "Cari diskon...",
                "lengthMenu": "_MENU_",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });

        $('.dataTables_filter input').addClass('bg-slate-100 dark:bg-slate-700 border-transparent rounded-xl text-sm focus:ring-2 focus:ring-amber-500 outline-none px-4 py-2 w-64 mb-4 transition-all');
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
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: transparent !important;
    }
    .dataTables_paginate .paginate_button i {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #f1f5f9;
        color: #64748b;
        transition: all 0.2s;
    }
    .dark .dataTables_paginate .paginate_button i {
        background: #334155;
        color: #94a3b8;
    }
    .dataTables_paginate .paginate_button.current i {
        background: #f59e0b; /* Amber */
        color: white;
    }
</style>
@endsection