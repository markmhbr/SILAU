@extends('layouts.home')

@section('title', 'Laporan Transaksi')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Laporan Transaksi</h2>
                <p class="text-sm text-slate-500">Analisis pendapatan dan aktivitas laundry Anda</p>
            </div>
            <nav class="flex text-sm text-slate-500 space-x-2">
                <a href="#" class="hover:text-primary-600">Home</a>
                <span>/</span>
                <span class="text-slate-900 dark:text-slate-200 font-medium">Laporan</span>
            </nav>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <form action="{{ route('admin.laporan.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Dari
                            Tanggal</label>
                        <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" required
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Sampai
                            Tanggal</label>
                        <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" required
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition">
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-primary-500/20 flex items-center justify-center gap-2">
                        <i class="fas fa-filter text-xs"></i> Tampilkan Laporan
                    </button>
                </form>
            </div>
        </div>

        @if ($dari && $sampai)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-primary-600 to-indigo-700 rounded-3xl p-6 text-white shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-xl">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div>
                            <p class="text-primary-100 text-xs font-bold uppercase tracking-wider">Total Pendapatan</p>
                            <h3 class="text-2xl font-black">Rp
                                {{ number_format($transaksi->sum('harga_setelah_diskon'), 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Transaksi</p>
                            <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $transaksi->count() }} <span
                                    class="text-sm font-medium text-slate-400">Pesanan</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-700/30">
                    <h3 class="font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-list-alt text-primary-500"></i>
                        Rincian Transaksi: {{ date('d M Y', strtotime($dari)) }} - {{ date('d M Y', strtotime($sampai)) }}
                    </h3>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table id="laporanTable" class="w-full text-sm text-left">
                            <thead>
                                <tr
                                    class="text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700 uppercase text-[11px] tracking-wider font-bold">
                                    <th class="px-4 py-4 text-center">No</th>
                                    <th class="px-4 py-4">ID / Tanggal</th>
                                    <th class="px-4 py-4">Pelanggan</th>
                                    <th class="px-4 py-4">Layanan</th>
                                    <th class="px-4 py-4 text-right">Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($transaksi as $key => $t)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <td class="px-4 py-4 text-center text-slate-400">{{ $key + 1 }}</td>
                                        <td class="px-4 py-4">
                                            <div class="font-bold text-slate-700 dark:text-white">#{{ $t->id }}</div>
                                            <div class="text-[10px] text-slate-400">
                                                {{ date('d/m/Y', strtotime($t->tanggal_masuk)) }}</div>
                                        </td>
                                        <td class="px-4 py-4 font-semibold text-slate-700 dark:text-slate-300">
                                            {{ $t->pelanggan->user->name }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <span
                                                class="text-xs px-2 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                                {{ $t->layanan->nama_layanan }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-right font-bold text-emerald-600 dark:text-emerald-400">
                                            Rp {{ number_format($t->harga_setelah_diskon, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-12 text-center">
                                            <div class="flex flex-col items-center opacity-40">
                                                <i class="fas fa-folder-open text-4xl mb-2"></i>
                                                <p>Tidak ada transaksi pada rentang tanggal ini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($transaksi->count() > 0)
                    <div
                        class="px-6 py-4 bg-slate-50 dark:bg-slate-700/30 border-t border-slate-100 dark:border-slate-700 flex justify-end">
                        <button onclick="window.print()"
                            class="flex items-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-black transition-all">
                            <i class="fas fa-print"></i> Cetak Laporan
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $('#laporanTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "searching": true,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Cari data laporan...",
                    "lengthMenu": "_MENU_",
                }
            });

            $('.dataTables_filter input').addClass(
                'bg-slate-100 dark:bg-slate-700 border-transparent rounded-xl text-sm focus:ring-2 focus:ring-primary-500 outline-none px-4 py-2 w-64 mb-4 transition-all'
                );
        });
    </script>
@endsection
