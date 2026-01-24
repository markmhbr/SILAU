@extends('layouts.backend')

@section('title', 'Data Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-fadeIn">

    {{-- HEADER + SEARCH --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white">
                Data Pelanggan
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Daftar pelanggan terdaftar beserta riwayat transaksinya.
            </p>
        </div>

        <form method="GET" class="flex gap-3">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Cari nama, email, no HP..."
                   class="w-64 px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-sm focus:ring focus:ring-brand/30">
            <button class="px-4 py-2 rounded-xl bg-brand text-white text-sm font-black">
                Cari
            </button>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b">
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                            Pelanggan
                        </th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                            Kontak
                        </th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                            Alamat
                        </th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">
                            Status
                        </th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse ($pelanggan as $p)

                    @php
                        if ($p->transaksi_count >= 10) {
                            $badge = 'bg-emerald-100 text-emerald-600';
                            $label = 'Aktif';
                        } elseif ($p->transaksi_count > 0) {
                            $badge = 'bg-blue-100 text-blue-600';
                            $label = 'Baru';
                        } else {
                            $badge = 'bg-slate-100 text-slate-500';
                            $label = 'Belum';
                        }
                    @endphp

                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">

                        {{-- PELANGGAN --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="{{ $p->foto_url }}"
                                     class="w-9 h-9 rounded-full object-cover border border-slate-200 dark:border-slate-700">
                                <div>
                                    <p class="text-sm font-black text-slate-700 dark:text-slate-200">
                                        {{ $p->user->name }}
                                    </p>
                                    <p class="text-[10px] text-slate-400">
                                        {{ $p->user->email }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- KONTAK --}}
                        <td class="px-6 py-5">
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-200">
                                {{ $p->no_hp ?? '-' }}
                            </p>
                        </td>

                        {{-- ALAMAT --}}
                        <td class="px-6 py-5 max-w-sm">
                            <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2">
                                {{ $p->alamat_gabungan ?? '-' }}
                            </p>
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-5 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black {{ $badge }}">
                                    {{ $p->transaksi_count }}x
                                </span>
                                <span class="text-[9px] uppercase font-bold {{ $badge }}">
                                    {{ $label }}
                                </span>
                            </div>
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">

                                {{-- DETAIL --}}
                                <a href="{{ route('karyawan.kasir.pelanggan.show', $p->id) }}"
                                   class="inline-flex w-10 h-10 items-center justify-center rounded-xl border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-brand hover:border-brand transition">
                                    ➜
                                </a>

                                {{-- MAPS --}}
                                @if($p->latitude && $p->longitude)
                                <a href="https://www.google.com/maps?q={{ $p->latitude }},{{ $p->longitude }}"
                                   target="_blank"
                                   class="inline-flex w-10 h-10 items-center justify-center rounded-xl border border-slate-200 text-blue-500 hover:border-blue-500 transition">
                                    🗺️
                                </a>
                                @endif

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="space-y-3">
                                <span class="text-4xl">👥</span>
                                <p class="text-slate-400 font-bold">
                                    Belum ada data pelanggan
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($pelanggan->hasPages())
            <div class="px-6 py-4 border-t border-slate-50 dark:border-slate-800">
                {{ $pelanggan->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
