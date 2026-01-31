@extends('layouts.backend')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8 animate-fadeIn">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <nav class="flex text-[10px] uppercase tracking-widest text-slate-400 mb-2 space-x-2 font-bold">
                    <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-brand transition">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-600 dark:text-slate-300">Detail Transaksi</span>
                </nav>
                <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Rincian Pesanan</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">ID: <span
                        class="font-mono text-brand">#{{ $transaksi->order_id ?? 'TRX-' . $transaksi->id }}</span>
                </p>
            </div>

            <a href="{{ route('pelanggan.layanan.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-brand transition-colors bg-white dark:bg-slate-800 px-4 py-2 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Riwayat
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                    <div class="p-8">
                        <div
                            class="flex flex-wrap justify-between items-center gap-4 mb-10 pb-6 border-b border-slate-100 dark:border-slate-800">
                            <div class="space-y-1">
                                <p class="text-[10px] uppercase tracking-widest font-black text-slate-400">Status Pesanan
                                </p>
                                @php
                                    $statusStyle = [
                                        'menunggu penjemputan' => 'bg-slate-100 dark:bg-slate-500/10 text-slate-600',
                                        'diambil_driver'       => 'bg-blue-100 dark:bg-blue-500/10 text-blue-600',
                                        'diterima_kasir'       => 'bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600',
                                        'ditimbang'            => 'bg-purple-100 dark:bg-purple-500/10 text-purple-600',
                                        'menunggu pembayaran'  => 'bg-rose-100 dark:bg-rose-500/10 text-rose-600',
                                        'dibayar'              => 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600',
                                        'diproses'             => 'bg-amber-100 dark:bg-amber-500/10 text-amber-600',
                                        'selesai'              => 'bg-green-100 dark:bg-green-500/10 text-green-600',
                                        'dibatalkan'           => 'bg-red-100 dark:bg-red-500/10 text-red-600',
                                    ];
                                    $statusText = str_replace('_', ' ', $transaksi->status);
                                    $currentStyle = $statusStyle[$transaksi->status] ?? 'bg-amber-100 text-amber-600';
                                @endphp
                                <span
                                    class="inline-flex px-4 py-1.5 rounded-xl text-[11px] font-black uppercase tracking-wider {{ $currentStyle }}">
                                    {{ $statusText }}
                                </span>
                            </div>
                            <div class="text-right space-y-1">
                                <p class="text-[10px] uppercase tracking-widest font-black text-slate-400">Metode Bayar</p>
                                <p class="font-bold text-slate-700 dark:text-slate-200 uppercase tracking-tight">
                                    {{ $transaksi->metode_pembayaran }}</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div
                                class="flex items-center gap-5 p-5 bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] border border-slate-100 dark:border-slate-700">
                                <div
                                    class="w-14 h-14 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center text-2xl shadow-sm">
                                    🧺</div>
                                <div class="flex-1">
                                    <h4 class="font-black text-slate-800 dark:text-white capitalize">
                                        {{ $transaksi->layanan->nama_layanan }}</h4>
                                    <p class="text-xs text-slate-500 italic">
                                        {{ $transaksi->cara_serah == 'jemput' ? 'Layanan Jemput' : 'Antar Sendiri' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-brand text-lg">{{ (float) ($transaksi->berat_aktual ?? $transaksi->estimasi_berat) }} kg</p>
                                    <span class="text-[9px] font-bold uppercase {{ $transaksi->berat_aktual ? 'text-emerald-500' : 'text-slate-400' }}">
                                        {{ $transaksi->berat_aktual ? 'Berat Aktual' : 'Estimasi Berat' }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-3 px-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-500 font-medium">Subtotal Harga</span>
                                    <span class="text-slate-700 dark:text-slate-300 font-bold">Rp
                                        {{ number_format($hargaLayanan, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-500 font-medium">Potongan Diskon</span>
                                    <span class="text-emerald-500 font-bold">- Rp
                                        {{ number_format($diskon, 0, ',', '.') }}</span>
                                </div>
                                <div
                                    class="flex justify-between items-center pt-6 mt-4 border-t-2 border-dashed border-slate-100 dark:border-slate-800">
                                    <span
                                        class="font-black text-slate-800 dark:text-white text-xl uppercase tracking-tighter">Total
                                        Bayar</span>
                                    <span class="text-3xl font-black text-brand tracking-tighter">Rp
                                        {{ number_format($hargaFinal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="px-8 py-5 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-xs">
                                👤</div>
                            <p class="text-xs text-slate-500 font-medium">Atas Nama: <span
                                    class="text-slate-700 dark:text-slate-200 font-bold">{{ Auth::user()->name }}</span>
                            </p>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            {{ $transaksi->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                @if ($transaksi->metode_pembayaran == 'qris' && $transaksi->status == 'menunggu pembayaran')
                    <div
                        class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-xl border border-brand/20 overflow-hidden sticky top-24">
                        <div class="bg-brand p-5 text-center">
                            <h5 class="text-white font-black text-xs uppercase tracking-[0.2em]">Pembayaran Online</h5>
                        </div>
                        <div class="p-8 text-center space-y-6">
                            <div
                                class="bg-slate-50 dark:bg-slate-800 p-6 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-700">
                                <span class="text-4xl">💳</span>
                                <p class="text-sm font-bold text-slate-700 dark:text-white mt-3">Midtrans Secure Payment</p>
                                <p class="text-[10px] text-slate-500 mt-1">Gopay, ShopeePay, Virtual Account, & Lainnya</p>
                            </div>

                            <button id="pay-button"
                                class="w-full py-4 bg-brand hover:bg-brandDark text-white rounded-2xl font-black shadow-lg shadow-brand/20 transition-all active:scale-95 text-xs uppercase tracking-widest">
                                Bayar Sekarang
                            </button>

                            <p class="text-[10px] text-slate-400 font-medium italic">*Status akan otomatis berubah setelah
                                pembayaran berhasil.</p>
                        </div>
                    </div>

                    {{-- Script Snap Midtrans --}}
                    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const payButton = document.getElementById('pay-button');
                            if (payButton) {
                                payButton.addEventListener('click', function (e) {
                                    e.preventDefault();
                                    window.snap.pay('{{ $transaksi->snap_token }}');
                                });
                            }
                        });
                    </script>

                @elseif($transaksi->status == 'dibayar' || $transaksi->status == 'menunggu pembayaran' && $transaksi->paid_at)
                    <div
                        class="bg-blue-50 dark:bg-blue-500/5 border border-blue-100 dark:border-blue-500/20 p-8 rounded-[2.5rem] text-center space-y-4">
                        <div
                            class="w-20 h-20 bg-blue-500 text-white rounded-3xl flex items-center justify-center mx-auto shadow-xl shadow-blue-500/30">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-black text-blue-800 dark:text-blue-400 text-xl tracking-tight">Pembayaran Berhasil</h4>
                            <p class="text-xs text-blue-600/70 dark:text-blue-500/60 font-medium">Transaksi telah terverifikasi. Pesanan akan segera diproses oleh tim kami.</p>
                        </div>
                    </div>
                @elseif($transaksi->status == 'selesai')
                    <div
                        class="bg-emerald-50 dark:bg-emerald-500/5 border border-emerald-100 dark:border-emerald-500/20 p-8 rounded-[2.5rem] text-center space-y-4">
                        <div
                            class="w-20 h-20 bg-emerald-500 text-white rounded-3xl flex items-center justify-center mx-auto shadow-xl shadow-emerald-500/30 transform -rotate-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-black text-emerald-800 dark:text-emerald-400 text-xl tracking-tight">Cucian
                                Selesai!</h4>
                            <p class="text-xs text-emerald-600/70 dark:text-emerald-500/60 font-medium">Pakaian Anda sudah
                                bersih, wangi, dan siap diambil.</p>
                        </div>
                    </div>
                @elseif($transaksi->status == 'menunggu penjemputan' || $transaksi->status == 'diambil_driver')
                    <div
                        class="bg-indigo-50 dark:bg-indigo-500/5 border border-indigo-100 dark:border-indigo-500/20 p-8 rounded-[2.5rem] text-center space-y-4">
                        <div
                            class="w-20 h-20 bg-indigo-500 text-white rounded-3xl flex items-center justify-center mx-auto shadow-xl shadow-indigo-500/30">
                            🚚
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-black text-indigo-800 dark:text-indigo-400 text-xl tracking-tight">Dalam Penjemputan</h4>
                            <p class="text-xs text-indigo-600/70 dark:text-indigo-500/60 font-medium">Driver kami sedang menuju lokasi atau sedang membawa cucian Anda ke outlet.</p>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-brand/5 dark:bg-brand/10 border border-brand/10 dark:border-brand/20 p-8 rounded-[2.5rem] text-center space-y-4">
                        <div
                            class="w-20 h-20 bg-brand text-white rounded-3xl flex items-center justify-center mx-auto shadow-xl shadow-brand/30 animate-pulse">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-black text-brand text-xl tracking-tight">Sedang Diproses</h4>
                            <p class="text-xs text-brand/70 font-medium">Tim kami sedang mengerjakan cucian Anda dengan
                                sepenuh hati.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection