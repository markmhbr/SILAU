@extends('layouts.backend')

@section('title', 'Detail Transaksi Kasir')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fadeIn">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Detail Pesanan</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">ID Transaksi: 
                <span class="font-mono text-brand font-bold">#{{ $transaksi->id }}</span>
            </p>
        </div>
        <div class="flex gap-2">
             <span class="px-4 py-2 bg-slate-100 dark:bg-slate-800 rounded-xl font-bold text-[10px] uppercase tracking-widest text-slate-500">
                Oleh: {{ $transaksi->karyawan->name ?? 'System' }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- KOLOM KIRI: RINCIAN HARGA & STATUS --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-brand/10 text-brand rounded-2xl flex items-center justify-center text-xl">🧺</div>
                        <div>
                            <h3 class="font-black text-slate-800 dark:text-white uppercase tracking-wider text-sm">{{ $transaksi->layanan->nama_layanan }}</h3>
                            <p class="text-xs text-slate-400 font-bold">{{ $transaksi->berat }} KG</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Bayar</p>
                        <p class="text-2xl font-black text-brand">Rp {{ number_format($hargaFinal, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="space-y-4 border-t border-slate-100 dark:border-slate-800 pt-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500 font-medium">Harga Layanan ({{ $transaksi->berat }}kg)</span>
                        <span class="text-slate-800 dark:text-slate-200 font-bold text-right">Rp {{ number_format($hargaLayanan, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500 font-medium">Diskon</span>
                        <span class="text-emerald-500 font-bold text-right">- Rp {{ number_format($diskon, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm pt-4 border-t border-dashed border-slate-200 dark:border-slate-700">
                        <span class="text-slate-800 dark:text-white font-black uppercase">Grand Total</span>
                        <span class="text-brand font-black text-xl text-right">Rp {{ number_format($hargaFinal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- CATATAN --}}
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-3xl p-6 border border-slate-100 dark:border-slate-800">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Pesanan</h4>
                <p class="text-sm text-slate-600 dark:text-slate-400 font-medium italic">
                    "{{ $transaksi->catatan ?? 'Tidak ada catatan khusus' }}"
                </p>
            </div>
        </div>

        {{-- KOLOM KANAN: UPDATE STATUS & MEMBER INFO --}}
        <div class="space-y-6">
            {{-- PANEL UPDATE STATUS --}}
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800">
                <h4 class="font-black text-slate-800 dark:text-white mb-6 uppercase tracking-widest text-xs">Update Status Kerja</h4>
                
                <form action="{{ route('karyawan.kasir.status', $transaksi->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <select name="status" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 outline-none text-sm font-bold text-slate-700 dark:text-slate-200">
                            <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending (Belum Bayar)</option>
                            <option value="menunggu konfirmasi" {{ $transaksi->status == 'menunggu konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="proses" {{ $transaksi->status == 'proses' ? 'selected' : '' }}>Sedang Dicuci</option>
                            <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai / Siap Ambil</option>
                            <option value="sedang diantar" {{ $transaksi->status == 'sedang diantar' ? 'selected' : '' }}>Sedang Diantar</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full py-4 bg-brand hover:bg-brandDark text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-brand/20">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- PANEL INFO PELANGGAN --}}
            <div class="bg-brand/5 dark:bg-brand/10 p-8 rounded-[2.5rem] border border-brand/10 dark:border-brand/20">
                <h4 class="text-brand font-black text-xs uppercase tracking-[0.2em] mb-4">Informasi Pelanggan</h4>
                @if($transaksi->pelanggan)
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-brand text-white rounded-2xl flex items-center justify-center font-black">
                            {{ substr($transaksi->pelanggan->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-black text-slate-800 dark:text-white leading-tight">{{ $transaksi->pelanggan->user->name }}</p>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter">{{ $transaksi->pelanggan->user->email }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-brand/10">
                         <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500 text-white text-[9px] font-black rounded-lg uppercase tracking-widest">
                            <span class="w-1 h-1 bg-white rounded-full animate-pulse"></span>
                            Member Aktif
                         </span>
                    </div>
                @else
                    <div class="flex items-center gap-4 opacity-60">
                        <div class="w-12 h-12 bg-slate-200 dark:bg-slate-700 text-slate-500 rounded-2xl flex items-center justify-center text-xl">👤</div>
                        <div>
                            <p class="font-black text-slate-800 dark:text-white leading-tight">Pelanggan Guest</p>
                            <p class="text-[10px] text-slate-500 font-bold italic">Tanpa Akun Member</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('karyawan.kasir.index') }}" class="flex items-center justify-center gap-2 text-xs font-black text-slate-400 hover:text-brand transition-colors uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection