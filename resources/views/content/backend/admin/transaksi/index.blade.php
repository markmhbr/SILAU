@extends('layouts.home')

@section('title', 'Data Transaksi')

@section('content')
    <div class="space-y-6 animate-fadeIn">
        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-800 dark:text-white">Daftar Transaksi</h2>
                <p class="text-sm text-slate-500">Pantau dan kelola semua pesanan laundry pelanggan</p>
            </div>
            <nav class="flex text-sm text-slate-500 space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Home</a>
                <span>/</span>
                <span class="text-slate-900 dark:text-slate-200 font-medium">Transaksi</span>
            </nav>
        </div>

        {{-- INFO PANEL --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 p-4 rounded-3xl flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-600 text-white rounded-2xl flex items-center justify-center shrink-0 shadow-lg shadow-blue-500/30">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="text-sm text-blue-800 dark:text-blue-300">
                <p class="font-black mb-1 italic uppercase tracking-wider">Quick Guide:</p>
                <p class="opacity-80">Klik pada label status untuk mengubah progres cucian. Transaksi dengan <span class="font-bold underline">ID merah</span> adalah transaksi yang belum lunas atau butuh perhatian.</p>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-white/50 backdrop-blur-md dark:bg-slate-800/50">
                <h3 class="font-black text-slate-800 dark:text-white uppercase tracking-widest text-xs">Master Data Transaksi</h3>
                <a href="{{ route('admin.transaksi.create') }}"
                    class="inline-flex items-center gap-2 bg-slate-900 dark:bg-brand text-white px-5 py-2.5 rounded-2xl text-xs font-black transition hover:scale-105 shadow-xl shadow-slate-900/20 dark:shadow-brand/20">
                    <i class="fas fa-plus"></i> INPUT TRANSAKSI
                </a>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table id="transaksiTable" class="w-full text-sm text-left border-separate border-spacing-y-3">
                        <thead>
                            <tr class="text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nota / Tgl</th>
                                <th class="px-4 py-3">Pelanggan</th>
                                <th class="px-4 py-3">Layanan</th>
                                <th class="px-4 py-3">Berat</th>
                                <th class="px-4 py-3">Total Bayar</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $transaksi)
                                <tr class="bg-slate-50/50 dark:bg-slate-700/30 hover:bg-slate-100 dark:hover:bg-slate-700/60 transition-all group">
                                    <td class="px-4 py-4 text-center font-bold text-slate-400 rounded-l-2xl group-hover:text-brand">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4">
                                        <div class="font-mono font-black text-brand tracking-tighter">{{ $transaksi->order_id }}</div>
                                        <div class="text-[10px] text-slate-400 italic">{{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-bold text-slate-800 dark:text-white uppercase">{{ $transaksi->pelanggan?->user?->name ?? 'Guest/Umum' }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $transaksi->pelanggan?->no_hp ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-slate-700 dark:text-slate-300 font-black text-xs uppercase">{{ $transaksi->layanan->nama_layanan }}</div>
                                        <div class="text-[9px] px-2 py-0.5 bg-slate-200 dark:bg-slate-600 rounded inline-block text-slate-600 dark:text-slate-300 font-bold uppercase">{{ $transaksi->layanan->jenis_layanan }}</div>
                                    </td>
                                    <td class="px-4 py-4 font-bold text-slate-600 dark:text-slate-400">
                                        {{-- Tampilkan berat aktual jika sudah ada, jika tidak pakai estimasi --}}
                                        {{ number_format($transaksi->berat_aktual ?? $transaksi->estimasi_berat, 1) }} kg
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="font-black text-emerald-600 dark:text-emerald-400">
                                            Rp {{ number_format($transaksi->harga_final ?? $transaksi->harga_estimasi, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @php
                                            $statusBadge = match($transaksi->status) {
                                                'selesai' => 'bg-emerald-500 text-white shadow-emerald-500/20',
                                                'diproses' => 'bg-blue-500 text-white shadow-blue-500/20',
                                                'dibatalkan' => 'bg-rose-500 text-white shadow-rose-500/20',
                                                'menunggu pembayaran' => 'bg-amber-500 text-white shadow-amber-500/20',
                                                default => 'bg-slate-400 text-white'
                                            };
                                        @endphp

                                        {{-- Dropdown Status Sederhana --}}
                                        <div class="relative inline-block text-left group/status">
                                            <button type="button" class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-lg transition-all hover:scale-105 {{ $statusBadge }}">
                                                {{ $transaksi->status }}
                                            </button>
                                            
                                            {{-- Menu ubah status (Opsional: Anda bisa buat ini memicu form PUT) --}}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center rounded-r-2xl">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.transaksi.show', $transaksi->id) }}"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-800 hover:text-white dark:bg-slate-700 dark:text-slate-300 transition-all shadow-sm"
                                                title="Detail & Nota">
                                                <i class="fas fa-file-invoice text-xs"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                                    <i class="fas fa-trash-alt text-xs"></i>
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

    {{-- DATATABLES CUSTOM STYLING --}}
    <script>
        $(document).ready(function() {
            $('#transaksiTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "ordering": true,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Filter Nota, Nama atau Layanan...",
                    "lengthMenu": "_MENU_",
                    "paginate": {
                        "previous": "<i class='fas fa-arrow-left'></i>",
                        "next": "<i class='fas fa-arrow-right'></i>"
                    }
                }
            });

            // Styling Search Box
            $('.dataTables_filter input').addClass(
                'bg-slate-100 dark:bg-slate-700 border-none rounded-2xl text-xs font-bold focus:ring-2 focus:ring-brand outline-none px-6 py-3 w-72 mb-4 transition-all'
            );
        });
    </script>

    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
            margin: 0 4px !important;
            border: none !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: transparent !important;
        }
        .dataTables_paginate .paginate_button i {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: #f8fafc;
            color: #64748b;
            transition: all 0.3s ease;
        }
        .dark .dataTables_paginate .paginate_button i {
            background: #1e293b;
            color: #94a3b8;
        }
        .dataTables_paginate .paginate_button.current i {
            background: #2563eb; /* Sesuaikan dengan warna brand */
            color: white;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }
    </style>
@endsection