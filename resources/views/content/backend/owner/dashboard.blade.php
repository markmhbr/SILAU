@extends('layouts.backend')

@section('title', 'Dashboard Owner')

@section('content')
    <div class="">

        {{-- ================= HEADER ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center mb-10">
            <div class="lg:col-span-2">
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800 dark:text-white">
                    Dashboard Owner 👑
                </h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400">
                    Ringkasan performa bisnis hari ini
                </p>
            </div>

            {{-- OMZET HARI INI --}}
            <div
                class="bg-gradient-to-br from-emerald-500 to-green-700 p-6 rounded-[2rem] shadow-xl shadow-emerald-500/20 text-white">
                <p class="text-[10px] uppercase tracking-[0.2em] opacity-80">Omzet Hari Ini</p>
                <p class="text-3xl font-black mt-1">
                    Rp {{ number_format($omzetHariIni ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-[11px] opacity-80">
                    {{ $totalTransaksiHariIni ?? 0 }} transaksi
                </p>
            </div>
        </div>

        {{-- ================= KPI CARDS ================= --}}
        {{-- ================= KPI CARDS ================= --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">

            {{-- TRANSAKSI BULAN INI --}}
            <div
                class="bg-blue-50 dark:bg-blue-950/30 p-5 md:p-6 rounded-[2rem] border border-blue-100 dark:border-blue-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-blue-500/30">
                    🧾
                </div>
                <p class="text-blue-600 dark:text-blue-400 font-black text-sm md:text-base">
                    {{ $totalTransaksiBulanIni ?? 0 }}
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                    Transaksi Bulan Ini
                </p>
            </div>

            {{-- OMZET BULAN INI --}}
            <div
                class="bg-emerald-50 dark:bg-emerald-950/30 p-5 md:p-6 rounded-[2rem] border border-emerald-100 dark:border-emerald-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-emerald-500/30">
                    💰
                </div>
                <p class="text-emerald-600 dark:text-emerald-400 font-black text-sm md:text-base">
                    Rp {{ number_format($omzetBulanIni ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                    Omzet Bulan Ini
                </p>
            </div>

            {{-- ORDER BELUM SELESAI --}}
            <div
                class="bg-amber-50 dark:bg-amber-950/30 p-5 md:p-6 rounded-[2rem] border border-amber-100 dark:border-amber-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-amber-500/30">
                    ⏳
                </div>
                <p class="text-amber-600 dark:text-amber-400 font-black text-sm md:text-base">
                    {{ $orderBelumSelesai ?? 0 }}
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                    Order Belum Selesai
                </p>
            </div>

            {{-- LAYANAN TERLARIS --}}
            <div
                class="bg-purple-50 dark:bg-purple-950/30 p-5 md:p-6 rounded-[2rem] border border-purple-100 dark:border-purple-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-purple-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-purple-500/30">
                    ⭐
                </div>
                <p class="text-purple-600 dark:text-purple-400 font-black text-sm md:text-base line-clamp-1">
                    {{ $layananTerlaris->nama_layanan ?? 'Belum ada' }}
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                    Layanan Terlaris
                </p>
            </div>

        </div>


        {{-- ================= TABEL TRANSAKSI TERAKHIR ================= --}}
        <div
            class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6">
                Transaksi Terakhir
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                            <th class="px-4 py-2">Pelanggan</th>
                            <th class="px-4 py-2">Layanan</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerbaru as $item)
                            <tr class="bg-slate-50/70 dark:bg-slate-800/40">
                                <td class="px-4 py-4">
                                    <div class="font-bold text-slate-800 dark:text-white">
                                        {{ $item->pelanggan->user->name ?? 'Guest' }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 uppercase tracking-tight">
                                        {{ $item->order_id ?? '#PENDING' }}
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600 dark:text-slate-300">
                                    {{ $item->layanan->nama_layanan ?? '-' }}
                                </td>

                                <td class="px-4 py-4">
                                    @if ($item->harga_final)
                                        <div class="font-bold text-emerald-600">
                                            Rp {{ number_format($item->harga_final, 0, ',', '.') }}
                                        </div>
                                        <span class="text-[9px] font-bold text-emerald-500 uppercase italic">Harga
                                            Final</span>
                                    @else
                                        <div class="font-bold text-amber-600">
                                            Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}
                                        </div>
                                        <span class="text-[9px] font-bold text-amber-500 uppercase italic">Estimasi</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                    @php
if($item->status === 'selesai') echo 'bg-emerald-100 text-emerald-600';
                        elseif($item->status === 'dibatalkan') echo 'bg-red-100 text-red-600';
                        elseif($item->status === 'diproses') echo 'bg-blue-100 text-blue-600';
                        else echo 'bg-amber-100 text-amber-600'; @endphp">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-slate-400 py-10 italic">
                                    Belum ada transaksi terbaru
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
