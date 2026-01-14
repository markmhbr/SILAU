@extends('layouts.home')

@section('title', 'Data Pelanggan')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Manajemen Pelanggan</h2>
                <p class="text-sm text-slate-500">Daftar semua pelanggan yang terdaftar di sistem</p>
            </div>
            <nav class="flex text-sm text-slate-500 space-x-2">
                <a href="#" class="hover:text-primary-600">Home</a>
                <span>/</span>
                <span class="text-slate-900 dark:text-slate-200 font-medium">Pelanggan</span>
            </nav>
        </div>

        <div
            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 p-4 rounded-2xl flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center shrink-0">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="text-sm text-blue-800 dark:text-blue-300">
                <p class="font-bold mb-1">Panduan Aksi:</p>
                <div class="flex flex-wrap gap-4">
                    <span class="flex items-center gap-1.5"><i class="fas fa-edit text-xs"></i> Gunakan tombol biru untuk
                        edit data.</span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-trash text-xs text-rose-500"></i> Gunakan
                        tombol merah untuk menghapus data.</span>
                </div>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-all">
            <div
                class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-white dark:bg-slate-800 sticky left-0">
                <h3 class="font-bold text-slate-800 dark:text-white">Data Pelanggan</h3>
                {{-- <a href="{{ route('admin.pelanggan.create') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm shadow-primary-500/20">
                <i class="fas fa-plus text-xs"></i> Tambah Pelanggan
            </a> --}}
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table id="customerTable" class="w-full text-sm text-left">
                        <thead>
                            <tr
                                class="text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700 uppercase text-[11px] tracking-wider">
                                <th class="px-4 py-4 font-bold text-center w-12">No</th>
                                <th class="px-4 py-4 font-bold">Nama Pelanggan</th>
                                <th class="px-4 py-4 font-bold">No. WhatsApp</th>
                                <th class="px-4 py-4 font-bold">Alamat</th>
                                <th class="px-4 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach ($pelanggans as $pelanggan)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                                    <td class="px-4 py-4 text-center text-slate-500 font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-primary-600 font-bold text-xs">
                                                {{ substr($pelanggan->user->name, 0, 1) }}
                                            </div>
                                            <span
                                                class="font-semibold text-slate-900 dark:text-white">{{ $pelanggan->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 font-medium text-slate-600 dark:text-slate-400">
                                        <a href="https://wa.me/{{ $pelanggan->no_hp }}" target="_blank"
                                            class="hover:text-emerald-500 flex items-center gap-2 transition-colors">
                                            <i class="fab fa-whatsapp text-emerald-500"></i> {{ $pelanggan->no_hp }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 max-w-xs truncate text-slate-500 dark:text-slate-400">
                                        {{ $pelanggan->alamat }}</td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition-all shadow-sm"
                                                title="Edit Data">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>

                                            <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn-delete w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white transition-all shadow-sm"
                                                    title="Hapus Data">
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
    </div>

    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Cari pelanggan...",
                    "lengthMenu": "_MENU_",
                    "paginate": {
                        "previous": "<i class='fas fa-chevron-left'></i>",
                        "next": "<i class='fas fa-chevron-right'></i>"
                    }
                }
            });

            // Styling search input
            $('.dataTables_filter input').addClass(
                'bg-slate-100 dark:bg-slate-700 border-transparent rounded-xl text-sm focus:ring-2 focus:ring-primary-500 outline-none px-4 py-2 w-64 mb-4 transition-all'
                );
            $('.dataTables_length select').addClass(
                'bg-slate-100 dark:bg-slate-700 border-transparent rounded-lg text-sm px-2 py-1 outline-none transition-all'
                );
        });
    </script>

    <style>
        /* Merapikan style DataTable agar serasi dengan Tailwind */
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
            background: #2563eb;
            color: white;
        }
    </style>
@endsection
