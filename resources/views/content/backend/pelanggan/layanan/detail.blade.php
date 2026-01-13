@extends('layouts.home')

@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Rincian Transaksi</h2>
            <p class="text-sm text-slate-500">ID Pesanan: #TRX-{{ $transaksi->id }}{{ date('Ymd') }}</p>
        </div>
        <a href="{{ route('pelanggan.layanan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-primary-600 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Riwayat
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-8">
                        <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-1">Status Layanan</p>
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-tighter 
                                {{ $transaksi->status == 'selesai' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                {{ $transaksi->status }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Metode Bayar</p>
                            <p class="font-bold text-slate-700 dark:text-slate-200 uppercase">{{ $transaksi->metode_pembayaran }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-dashed border-slate-200 dark:border-slate-700">
                            <div>
                                <p class="font-bold text-slate-800 dark:text-white">{{ $transaksi->layanan->nama_layanan }}</p>
                                <p class="text-xs text-slate-500 italic">{{ $transaksi->layanan->jenis_layanan }}</p>
                            </div>
                            <p class="font-semibold text-slate-700 dark:text-slate-300">{{ (float)$transaksi->berat }} kg</p>
                        </div>

                        <div class="space-y-2 pt-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500 italic">Harga Subtotal</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium">Rp {{ number_format($hargaLayanan,0,',','.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500 italic">Potongan Diskon</span>
                                <span class="text-rose-500 font-medium">- Rp {{ number_format($diskon,0,',','.') }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-slate-100 dark:border-slate-700">
                                <span class="font-bold text-slate-800 dark:text-white text-lg">Total Bayar</span>
                                <span class="text-2xl font-black text-primary-600">Rp {{ number_format($hargaFinal,0,',','.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="px-8 py-4 bg-slate-50 dark:bg-slate-700/30 border-t border-slate-100 dark:border-slate-700 flex items-center gap-3">
                    <i class="fas fa-user-circle text-slate-400"></i>
                    <p class="text-xs text-slate-500">Dipesan oleh: <span class="font-bold text-slate-700 dark:text-slate-300">{{ $transaksi->pelanggan->user->name }}</span></p>
                </div>
            </div>
        </div>

        <div class="md:col-span-1">
            @if($transaksi->metode_pembayaran == 'qris' && $transaksi->status == 'pending')
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border-2 border-primary-100 dark:border-primary-900 overflow-hidden sticky top-6">
                <div class="bg-primary-600 p-4 text-center">
                    <h5 class="text-white font-bold text-sm uppercase tracking-widest">Pembayaran QRIS</h5>
                </div>
                <div class="p-6 text-center space-y-6">
                    <div class="bg-white p-3 rounded-2xl border border-slate-100 inline-block shadow-inner">
                        <img src="{{ asset('assets/img/Capture.PNG') }}" alt="QRIS" class="w-48 h-auto mx-auto grayscale hover:grayscale-0 transition-all duration-500">
                    </div>
                    
                    <div class="text-xs text-slate-500 leading-relaxed px-2">
                        Silakan scan kode QR di atas melalui aplikasi e-wallet Anda (Gopay, OVO, Dana, dll).
                    </div>

                    <form action="{{ route('pelanggan.layanan.bayar', $transaksi->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Upload Bukti Transfer</label>
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-2xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-slate-400 mb-2"></i>
                                    <p class="text-[10px] text-slate-400">Klik untuk pilih file</p>
                                </div>
                                <input type="file" name="bukti_bayar" class="hidden" required />
                            </label>
                        </div>
                        <button type="submit" class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-500/30 transition-all">
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>
            @elseif($transaksi->status == 'selesai')
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 p-6 rounded-3xl text-center">
                <div class="w-16 h-16 bg-emerald-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/30">
                    <i class="fas fa-check text-2xl"></i>
                </div>
                <h4 class="font-bold text-emerald-800 dark:text-emerald-300">Transaksi Selesai</h4>
                <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-2">Terima kasih telah mempercayakan laundry Anda kepada kami!</p>
            </div>
            @else
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 p-6 rounded-3xl text-center">
                <div class="w-16 h-16 bg-blue-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/30">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <h4 class="font-bold text-blue-800 dark:text-blue-300">Sedang Diproses</h4>
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-2">Cucian Anda sedang dalam tahap pengerjaan oleh tim kami.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection