@extends('layouts.home')

@section('title', 'Layanan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Daftar Layanan</h2>
            <p class="text-sm text-slate-500">Kelola paket laundry dan harga per kilogram</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">Layanan</span>
        </nav>
    </div>

    <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 p-4 rounded-2xl flex items-start gap-4">
        <div class="w-10 h-10 bg-indigo-500 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-indigo-500/20">
            <i class="fas fa-concierge-bell"></i>
        </div>
        <div class="text-sm text-indigo-800 dark:text-indigo-300">
            <p class="font-bold mb-1">Manajemen Layanan:</p>
            <div class="flex flex-wrap gap-4">
                <span class="flex items-center gap-1.5"><i class="fas fa-edit text-xs"></i> Klik tombol biru untuk memperbarui harga atau deskripsi.</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-trash text-xs text-rose-500"></i> Klik tombol merah untuk menghapus jenis layanan.</span>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 dark:text-white">Data Layanan Laundry</h3>
            {{-- <a href="{{ route('admin.layanan.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-md shadow-primary-500/20">
                Tambah Layanan
            </a> --}}
        </div>

        <div class="p-6">
            <table id="serviceTable" class="w-full text-sm text-left">
                <thead>
                    <tr class="text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700 uppercase text-[11px] tracking-wider">
                        <th class="px-4 py-4 font-bold text-center w-12">No</th>
                        <th class="px-4 py-4 font-bold">Nama Layanan</th>
                        <th class="px-4 py-4 font-bold">Deskripsi</th>
                        <th class="px-4 py-4 font-bold">Harga /Kg</th>
                        <th class="px-4 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach($layanans as $layanan)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                        <td class="px-4 py-4 text-center text-slate-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <span class="font-bold text-slate-900 dark:text-white">{{ $layanan->nama_layanan }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-slate-500 dark:text-slate-400 max-w-xs italic text-xs">
                            "{{ $layanan->deskripsi }}"
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 font-bold tracking-tight">
                                Rp {{ number_format($layanan->harga_perkilo, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.layanan.edit', $layanan->id) }}" 
                                   class="w-9 h-9 flex items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition-all"
                                   title="Edit Layanan">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
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
        $('#serviceTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "search": "",
                "searchPlaceholder": "Cari layanan...",
                "lengthMenu": "_MENU_",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left text-xs'></i>",
                    "next": "<i class='fas fa-chevron-right text-xs'></i>"
                }
            }
        });

        // Styling search input
        $('.dataTables_filter input').addClass('bg-slate-100 dark:bg-slate-700 border-transparent rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none px-4 py-2 w-64 mb-4 transition-all');
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
        background: #6366f1; /* Indigo matching theme */
        color: white;
    }
</style>
@endsection