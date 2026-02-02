@extends('layouts.home')

@section('title', 'Beranda Admin')

@section('content')
<div class="space-y-8 animate-fadeIn">
    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card Pelanggan --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-5 transition-all hover:scale-[1.02]">
            <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center text-2xl">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Pelanggan</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ number_format($jumlahPelanggan) }}</h3>
            </div>
        </div>

        {{-- Card Layanan --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-5 transition-all hover:scale-[1.02]">
            <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center text-2xl">
                <i class="fas fa-tshirt"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Layanan</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $jumlahLayanan }}</h3>
            </div>
        </div>

        {{-- Card Transaksi --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-5 transition-all hover:scale-[1.02]">
            <div class="w-14 h-14 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-2xl flex items-center justify-center text-2xl">
                <i class="fas fa-receipt"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Transaksi</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $jumlahTransaksi }}</h3>
            </div>
        </div>

        {{-- Card Omzet --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-5 transition-all hover:scale-[1.02]">
            <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center text-2xl">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Omzet</p>
                <h3 class="text-xl font-black text-emerald-600">Rp {{ number_format($omzet, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    {{-- RECENT TRANSACTIONS TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
            <div>
                <h3 class="font-black text-slate-800 dark:text-white text-lg">Riwayat Transaksi Terakhir</h3>
                <p class="text-xs text-slate-500">Monitoring aktivitas laundry terbaru</p>
            </div>
            <a href="{{ route('admin.transaksi.index') }}" class="text-xs font-bold text-white bg-slate-800 hover:bg-brand px-4 py-2 rounded-xl transition-all">
                Lihat Semua
            </a>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table id="dashboardTable" class="w-full text-sm text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-slate-400 uppercase text-[10px] font-black tracking-[0.1em]">
                            <th class="px-4 py-3 text-left">Nota / ID</th>
                            <th class="px-4 py-3">Pelanggan</th>
                            <th class="px-4 py-3">Berat</th>
                            <th class="px-4 py-3">Total Bayar</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksiTerbaru as $t)
                        <tr class="bg-slate-50/50 dark:bg-slate-700/30 hover:bg-slate-100 dark:hover:bg-slate-700/60 transition-colors">
                            <td class="px-4 py-4 rounded-l-2xl">
                                <span class="font-mono font-bold text-brand">{{ $t->order_id }}</span>
                                <p class="text-[10px] text-slate-400">{{ $t->created_at->format('d M, H:i') }}</p>
                            </td>
                            <td class="px-4 py-4 font-bold text-slate-700 dark:text-slate-200">
                                {{ $t->pelanggan?->user?->name ?? 'Guest' }}
                            </td>
                            <td class="px-4 py-4 text-slate-500">
                                {{ $t->berat_aktual ?? $t->estimasi_berat }} <span class="text-[10px] font-bold">KG</span>
                            </td>
                            <td class="px-4 py-4 font-black text-slate-800 dark:text-white">
                                Rp {{ number_format($t->harga_final ?? $t->harga_estimasi, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                @php
                                    // Mapping warna berdasarkan ENUM migration
                                    $badge = match($t->status) {
                                        'selesai' => 'bg-emerald-500 text-white',
                                        'diproses' => 'bg-blue-500 text-white',
                                        'dibatalkan' => 'bg-rose-500 text-white',
                                        'menunggu pembayaran' => 'bg-amber-500 text-white',
                                        default => 'bg-slate-400 text-white'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase {{ $badge }}">
                                    {{ $t->status }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center rounded-r-2xl">
                                <a href="{{ route('admin.transaksi.show', $t->id) }}" class="p-2 text-slate-400 hover:text-brand transition-all">
                                    <i class="fas fa-external-link-alt"></i>
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
            "pageLength": 5,
            "searching": false,
            "info": false,
            "ordering": false, // Karena sudah diorder di controller
            "language": {
                "paginate": {
                    "previous": "<i class='fas fa-arrow-left'></i>",
                    "next": "<i class='fas fa-arrow-right'></i>"
                }
            }
        });
    });
</script>
@endsection