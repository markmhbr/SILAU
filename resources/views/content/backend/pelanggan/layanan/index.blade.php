@extends('layouts.pelanggan')

@section('title', 'Layanan')
@section('pelanggan')
<div class="space-y-8 animate-fadeIn">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <nav class="flex text-[10px] uppercase tracking-widest text-slate-400 mb-2 space-x-2 font-bold">
                <a href="#" class="hover:text-brand transition">Home</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Daftar Layanan</span>
            </nav>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Katalog Layanan</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Pilih paket laundry terbaik sesuai kebutuhan pakaian Anda.</p>
        </div>
    </div>

    <div class="bg-indigo-50/50 dark:bg-indigo-950/20 border border-indigo-100 dark:border-indigo-800/50 p-5 rounded-[2rem] flex items-center gap-4 backdrop-blur-sm">
        <div class="w-12 h-12 bg-white dark:bg-slate-800 text-indigo-500 rounded-2xl flex items-center justify-center shrink-0 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
        </div>
        <div class="text-sm">
            <p class="font-bold text-indigo-900 dark:text-indigo-200">Informasi Tarif & Layanan</p>
            <p class="text-indigo-700/80 dark:text-indigo-400/80 leading-relaxed">Harga estimasi per kilogram. Geser tabel ke samping <span class="md:hidden inline-flex items-center text-brand font-bold">👉</span> untuk melihat detail.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-4 md:p-8">
            <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-slate-200 dark:scrollbar-thumb-slate-800">
                <table id="serviceTable" class="w-full min-w-[800px] text-sm text-left border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-slate-400 dark:text-slate-500 uppercase text-[11px] tracking-[0.15em] font-black">
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th class="px-6 py-4">Paket Laundry</th>
                            <th class="px-6 py-4">Keunggulan</th>
                            <th class="px-6 py-4 text-right font-black">Harga /Kg</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-0">
                        @foreach($layanans as $layanan)
                        <tr class="group bg-slate-50/50 dark:bg-slate-800/30 hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 shadow-sm hover:shadow-md">
                            <td class="px-6 py-6 text-center text-slate-400 font-mono rounded-l-2xl border-y border-l border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-6 border-y border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-700 text-brand flex items-center justify-center shadow-sm border border-slate-100 dark:border-slate-600 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <div class="whitespace-nowrap">
                                        <div class="font-bold text-slate-800 dark:text-white text-base group-hover:text-brand transition-colors">{{ $layanan->nama_layanan }}</div>
                                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Premium Service</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-slate-500 dark:text-slate-400 border-y border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700 min-w-[250px]">
                                <span class="italic text-xs font-medium leading-relaxed">"{{ $layanan->deskripsi }}"</span>
                            </td>
                            <td class="px-6 py-6 text-right border-y border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700">
                                <span class="px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-black text-base border border-emerald-100 dark:border-emerald-500/20 shadow-sm whitespace-nowrap">
                                    Rp {{ number_format($layanan->harga_perkilo, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-6 text-center rounded-r-2xl border-y border-r border-transparent group-hover:border-slate-100 dark:group-hover:border-slate-700">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand animate-pulse"></span>
                                    Tersedia
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Scrollbar biar tetep estetik di mobile */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    .overflow-x-auto::-webkit-scrollbar-track {
        background: transparent;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .dark .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #1e293b;
    }

    /* Animasi */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endsection