@extends('layouts.home')

@section('title', 'Beranda')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-5 transition-all hover:shadow-md">
            <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center text-2xl">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Pelanggan</p>
                <h3 class="text-2xl font-bold mt-1 text-slate-800 dark:text-white">{{ $jumlahPelanggan }}</h3>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-5 transition-all hover:shadow-md">
            <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center text-2xl">
                <i class="fas fa-tshirt"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Layanan</p>
                <h3 class="text-2xl font-bold mt-1 text-slate-800 dark:text-white">{{ $jumlahLayanan }}</h3>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-5 transition-all hover:shadow-md">
            <div class="w-14 h-14 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl flex items-center justify-center text-2xl">
                <i class="fas fa-receipt"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Transaksi</p>
                <h3 class="text-2xl font-bold mt-1 text-slate-800 dark:text-white">{{ $jumlahTransaksi }}</h3>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-5 transition-all hover:shadow-md">
            <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center text-2xl">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Omzet</p>
                <h3 class="text-2xl font-bold mt-1 text-emerald-600 dark:text-emerald-400">Rp {{ number_format($omzet, 0, ',', '.') }}</h3>
            </div>
        </div>

    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 dark:text-white">Riwayat Transaksi Terakhir</h3>
            <a href="{{ route('admin.transaksi.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 bg-primary-50 dark:bg-primary-900/20 px-3 py-1.5 rounded-lg transition-colors">
                Lihat Semua
            </a>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table id="dashboardTable" class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700 uppercase text-[11px] tracking-wider">
                            <th class="px-4 py-3 font-semibold text-left">Nota</th>
                            <th class="px-4 py-3 font-semibold">Pelanggan</th>
                            <th class="px-4 py-3 font-semibold">Total Bayar</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($transaksiTerbaru as $t)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-4 py-4 font-medium text-slate-900 dark:text-white">#{{ $t->id }}</td>
                            <td class="px-4 py-4 font-medium text-slate-700 dark:text-slate-300">
                                {{ $t->pelanggan?->user?->name ?? 'Pelanggan Umum' }}
                            </td>
                            <td class="px-4 py-4 font-bold text-emerald-600 dark:text-emerald-400">
                                Rp {{ number_format($t->harga_total, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-4">
                                @php
                                    $statusClasses = [
                                        'proses' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
                                        'selesai' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400',
                                        'pending' => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400'
                                    ];
                                    $class = $statusClasses[$t->status] ?? 'bg-rose-100 text-rose-600';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $class }}">
                                    {{ $t->status }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <a href="{{ route('admin.transaksi.show', $t->id) }}" class="text-slate-400 hover:text-primary-600 transition-all hover:scale-110 inline-block">
                                    <i class="fas fa-eye"></i>
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

<script>
    $(document).ready(function() {
        $('#dashboardTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 5,
            "searching": false, // Matikan pencarian di dashboard agar minimalis
            "info": false,      // Matikan info baris agar bersih
            "language": {
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });
</script>
@endsection