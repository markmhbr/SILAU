@extends('layouts.home')

@section('title', isset($transaksi) ? 'Edit Transaksi' : 'Pesan Laundry')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">{{ isset($transaksi) ? 'Edit Pesanan' : 'Buat Pesanan Baru' }}</h2>
            <p class="text-sm text-slate-500">Silakan isi rincian cucian Anda di bawah ini</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <a href="{{ route('pelanggan.layanan.index') }}" class="hover:text-primary-600">Layanan</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">Tambah</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 dark:text-white">Formulir Pesanan</h3>
                    <a href="{{ route('pelanggan.layanan.index') }}" class="text-xs font-semibold text-slate-500 hover:text-primary-600 transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>

                <div class="p-6">
                    <form action="{{ isset($transaksi) ? route('pelanggan.layanan.update', $transaksi->id) : route('pelanggan.layanan.store') }}" method="POST" id="orderForm">
                        @csrf
                        @if(isset($transaksi)) @method('PUT') @endif

                        <div class="space-y-5">
                            <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-600">
                                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-1">Pelanggan Aktif</label>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ Auth::user()->name }}</span>
                                    <input type="hidden" name="pelanggan_id" value="{{ $pelanggan->id }}">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Pilih Layanan</label>
                                    <select name="layanan_id" id="layananSelect" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition cursor-pointer" required>
                                        <option value="" disabled selected>- Pilih Layanan -</option>
                                        @foreach($layanan as $l)
                                            <option value="{{ $l->id }}" data-harga="{{ $l->harga_perkilo }}" {{ (old('layanan_id', $transaksi->layanan_id ?? '') == $l->id) ? 'selected' : '' }}>
                                                {{ $l->nama_layanan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Estimasi Berat (kg)</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="berat" id="beratInput" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition" placeholder="0.0" value="{{ old('berat', $transaksi->berat ?? '') }}" required>
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">KG</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Promo / Diskon</label>
                                    <select name="diskon_id" id="diskonSelect" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition cursor-pointer">
                                        <option value="">- Tanpa Diskon -</option>
                                        @foreach($diskon as $d)
                                            @if((int)$d->aktif === 0)
                                                <option value="{{ $d->id }}" data-tipe="{{ $d->tipe }}" data-nilai="{{ $d->nilai }}">
                                                    {{ $d->nama_diskon }} ({{ $d->tipe == 'persentase' ? (float)$d->nilai.'%' : 'Rp'.number_format($d->nilai,0) }})
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition cursor-pointer" required>
                                        <option value="" disabled selected>- Pilih Metode -</option>
                                        <option value="tunai" {{ (old('metode_pembayaran', $transaksi->metode_pembayaran ?? '') == 'tunai') ? 'selected' : '' }}>Tunai / Cash</option>
                                        <option value="qris" {{ (old('metode_pembayaran', $transaksi->metode_pembayaran ?? '') == 'qris') ? 'selected' : '' }}>QRIS / E-Wallet</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Catatan Tambahan (Opsional)</label>
                                <textarea name="catatan" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition placeholder:text-slate-400" placeholder="Contoh: Tolong jemput jam 4 sore, atau pakaian bayi dipisah...">{{ old('catatan', $transaksi->catatan ?? '') }}</textarea>
                            </div>

                            <button type="submit" class="w-full py-3.5 bg-primary-600 hover:bg-primary-700 text-white rounded-2xl font-bold shadow-lg shadow-primary-500/30 transition-all hover:scale-[1.01] active:scale-95 flex items-center justify-center gap-2 mt-4">
                                {{ isset($transaksi) ? 'Perbarui Pesanan' : 'Lanjut ke Ringkasan Nota' }} <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-primary-600 rounded-3xl p-6 text-white shadow-xl sticky top-6">
                <h4 class="font-bold text-lg mb-4 flex items-center gap-2">
                    <i class="fas fa-calculator text-primary-200"></i> Estimasi Biaya
                </h4>
                
                <div class="space-y-4 border-b border-primary-500 pb-4 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-primary-100">Harga Layanan</span>
                        <span id="label-harga">Rp 0 /kg</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-primary-100">Berat Cucian</span>
                        <span id="label-berat">0 kg</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-primary-100">Potongan Diskon</span>
                        <span id="label-diskon" class="text-emerald-300">Rp 0</span>
                    </div>
                </div>

                <div class="flex flex-col">
                    <span class="text-xs text-primary-200 uppercase font-bold tracking-widest">Total Bayar</span>
                    <span id="label-total" class="text-3xl font-black">Rp 0</span>
                </div>

                <div class="mt-6 bg-primary-700/50 p-3 rounded-xl flex items-center gap-3">
                    <i class="fas fa-info-circle text-primary-200"></i>
                    <p class="text-[10px] text-primary-100 leading-relaxed">
                        Harga ini adalah estimasi sementara. Total akhir akan divalidasi oleh tim laundry saat penimbangan ulang.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const layananSelect = document.getElementById('layananSelect');
    const beratInput = document.getElementById('beratInput');
    const diskonSelect = document.getElementById('diskonSelect');

    const labelHarga = document.getElementById('label-harga');
    const labelBerat = document.getElementById('label-berat');
    const labelDiskon = document.getElementById('label-diskon');
    const labelTotal = document.getElementById('label-total');

    function calculateLive() {
        const optionLayanan = layananSelect.options[layananSelect.selectedIndex];
        const harga = parseFloat(optionLayanan.dataset.harga || 0);
        const berat = parseFloat(beratInput.value || 0);
        
        const optionDiskon = diskonSelect.options[diskonSelect.selectedIndex];
        const diskonTipe = optionDiskon.dataset.tipe || '';
        const diskonNilai = parseFloat(optionDiskon.dataset.nilai || 0);

        let subtotal = harga * berat;
        let potongan = 0;

        if(diskonTipe === 'persentase') {
            potongan = (subtotal * diskonNilai) / 100;
        } else {
            potongan = diskonNilai;
        }

        let total = subtotal - potongan;
        if(total < 0) total = 0;

        // Update Labels
        labelHarga.textContent = `Rp ${harga.toLocaleString('id-ID')} /kg`;
        labelBerat.textContent = `${berat} kg`;
        labelDiskon.textContent = `- Rp ${potongan.toLocaleString('id-ID')}`;
        labelTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    [layananSelect, beratInput, diskonSelect].forEach(el => {
        el.addEventListener('change', calculateLive);
        el.addEventListener('input', calculateLive);
    });

    // Run on init
    calculateLive();
</script>
@endsection