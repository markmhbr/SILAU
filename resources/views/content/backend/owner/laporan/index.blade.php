@extends('layouts.backend')

@section('title', 'Laporan Owner')

@section('content')
    <div>

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800 dark:text-white">
                    Laporan Bisnis 📊
                </h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400">
                    Rekap transaksi & performa usaha
                </p>
            </div>

            {{-- EXPORT --}}
            <div class="flex gap-3">
                <a href="{{ route('owner.laporan.export.excel', request()->query()) }}"
                    class="px-5 py-3 rounded-[1.5rem] bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/20">
                    ⬇ Export Excel
                </a>
                <a href="{{ route('owner.laporan.export.pdf', request()->query()) }}"
                    class="px-5 py-3 rounded-[1.5rem] bg-red-500 text-white text-sm font-bold shadow-lg shadow-red-500/20">
                    ⬇ Export PDF
                </a>
            </div>
        </div>

        {{-- ================= SUMMARY ================= --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">

            {{-- TOTAL TRANSAKSI --}}
            <div
                class="bg-blue-50 dark:bg-blue-950/30 p-5 md:p-6 rounded-[2rem] border border-blue-100 dark:border-blue-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-blue-500/30">
                    🧾
                </div>
                <p class="text-blue-600 dark:text-blue-400 font-black text-sm md:text-base">
                    {{ $totalTransaksi ?? 0 }}
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                    Total Transaksi
                </p>
            </div>

            {{-- TOTAL OMZET --}}
            <div
                class="bg-emerald-50 dark:bg-emerald-950/30 p-5 md:p-6 rounded-[2rem] border border-emerald-100 dark:border-emerald-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-emerald-500/30">
                    💰
                </div>
                <p class="text-emerald-600 dark:text-emerald-400 font-black text-sm md:text-base">
                    Rp {{ number_format($totalOmzet ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                    Total Omzet
                </p>
            </div>

            {{-- PROSES --}}
            <div
                class="bg-amber-50 dark:bg-amber-950/30 p-5 md:p-6 rounded-[2rem] border border-amber-100 dark:border-amber-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-amber-500/30">
                    ⏳
                </div>
                <p class="text-amber-600 dark:text-amber-400 font-black text-sm md:text-base">
                    {{ $totalProses ?? 0 }}
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                    Masih Proses
                </p>
            </div>

            {{-- SELESAI --}}
            <div
                class="bg-purple-50 dark:bg-purple-950/30 p-5 md:p-6 rounded-[2rem] border border-purple-100 dark:border-purple-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-purple-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-purple-500/30">
                    ✅
                </div>
                <p class="text-purple-600 dark:text-purple-400 font-black text-sm md:text-base">
                    {{ $totalSelesai ?? 0 }}
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                    Selesai
                </p>
            </div>

        </div>

        {{-- ================= GUEST vs MEMBER ================= --}}
        <div class="grid grid-cols-2 gap-4 md:gap-6 mb-10">

            {{-- GUEST --}}
            <div
                class="bg-slate-50 dark:bg-slate-800 p-5 md:p-6 rounded-[2rem] border border-slate-200 dark:border-slate-700">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-slate-600 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg">
                    👤
                </div>
                <p class="text-slate-700 dark:text-white font-black text-sm md:text-base">
                    {{ $guestCount ?? 0 }}
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                    Transaksi Guest
                </p>
            </div>

            {{-- MEMBER --}}
            <div
                class="bg-indigo-50 dark:bg-indigo-950/30 p-5 md:p-6 rounded-[2rem] border border-indigo-100 dark:border-indigo-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-indigo-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-indigo-500/30">
                    🧑‍💼
                </div>
                <p class="text-indigo-600 dark:text-indigo-400 font-black text-sm md:text-base">
                    {{ $memberCount ?? 0 }}
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">
                    Transaksi Member
                </p>
            </div>

        </div>

        {{-- ================= FILTER ================= --}}
        <div
            class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 p-6 mb-10 shadow-sm">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">

                {{-- FROM DATE --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 mb-2 block">Dari Tanggal</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">📅</span>
                        <input type="date" name="from" value="{{ request('from') }}"
                            class="w-full pl-11 pr-4 py-3 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-brand focus:border-brand">
                    </div>
                </div>

                {{-- TO DATE --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 mb-2 block">Sampai Tanggal</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">📅</span>
                        <input type="date" name="to" value="{{ request('to') }}"
                            class="w-full pl-11 pr-4 py-3 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-brand focus:border-brand">
                    </div>
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 mb-2 block">
                        Status
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">⚙️</span>

                        <select name="status"
                            class="w-full pl-11 pr-4 py-3 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-brand focus:border-brand">

                            <option value="">Semua Status</option>

                            @foreach ($statusList as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>


                <button class="py-3 rounded-[1.5rem] bg-slate-800 dark:bg-white dark:text-slate-900 text-white font-black">
                    🔍 Terapkan
                </button>

                <a href="{{ route('owner.laporan.index') }}"
                    class="py-3 rounded-[1.5rem] bg-slate-100 dark:bg-slate-800 text-center font-bold">
                    ♻ Reset
                </a>
            </form>
        </div>

        {{-- ================= TABLE ================= --}}
        <div
            class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
            <h2 class="text-xl font-bold mb-6">Detail Laporan</h2>

            <div class="overflow-x-auto">
                <table class="w-full border-separate border-spacing-y-3 text-sm">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Pelanggan</th>
                            <th class="px-4 py-2">Layanan</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2 text-center">Status</th>
                        </tr>
                    </thead>
                    {{-- Ganti bagian <tbody> sampai </tbody> --}}
<tbody>
    @forelse($laporan as $item)
        <tr class="bg-slate-50/70 dark:bg-slate-800/40">
            {{-- TANGGAL --}}
            <td class="px-4 py-4">{{ $item->created_at->format('d M Y') }}</td>
            
            {{-- PELANGGAN --}}
            <td class="px-4 py-4 font-bold">
                {{ $item->pelanggan->user->name ?? 'Guest' }}
                <div class="text-[10px] text-slate-400 font-normal">{{ $item->order_id }}</div>
            </td>

            {{-- LAYANAN --}}
            <td class="px-4 py-4">{{ $item->layanan->nama_layanan ?? '-' }}</td>

            {{-- TOTAL HARGA + LABEL ESTIMASI --}}
            <td class="px-4 py-4">
                @if($item->harga_final)
                    <div class="font-black text-emerald-600">
                        Rp {{ number_format($item->harga_final, 0, ',', '.') }}
                    </div>
                @else
                    <div class="font-black text-amber-600">
                        Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}
                    </div>
                    <span class="text-[9px] text-amber-500 font-bold uppercase italic">Estimasi</span>
                @endif
            </td>

            {{-- STATUS (Badge Berwarna) --}}
            <td class="px-4 py-4 text-center">
                @php
                    $badge = match ($item->status) {
                        'selesai'               => 'bg-emerald-100 text-emerald-600',
                        'dibatalkan'           => 'bg-red-100 text-red-600',
                        'diproses', 'dibayar'   => 'bg-blue-100 text-blue-600',
                        'menunggu pembayaran', 'ditimbang' => 'bg-amber-100 text-amber-600',
                        'menunggu penjemputan', 'menunggu diantar' => 'bg-slate-100 text-slate-600',
                        default                 => 'bg-purple-100 text-purple-600',
                    };
                @endphp

                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $badge }}">
                    {{ $item->status }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center py-10 text-slate-400">
                Tidak ada data laporan untuk filter ini
            </td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
