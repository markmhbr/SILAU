@extends('layouts.backend')

@section('title', isset($transaksi) ? 'Edit Transaksi' : 'Pesan Laundry')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8 animate-fadeIn">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <nav class="flex text-[10px] uppercase tracking-widest text-slate-400 mb-2 space-x-2 font-bold">
                    <a href="#" class="hover:text-brand transition">Home</a>
                    <span>/</span>
                    <a href="{{ route('pelanggan.layanan.index') }}" class="hover:text-brand transition">Layanan</a>
                    <span>/</span>
                    <span class="text-slate-600 dark:text-slate-300">Buat Pesanan</span>
                </nav>
                <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
                    {{ isset($transaksi) ? 'Edit Pesanan' : 'Buat Pesanan Baru' }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Lengkapi rincian cucian Anda untuk diproses tim
                    kami.</p>
            </div>

            <a href="{{ route('pelanggan.layanan.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-brand transition-colors bg-white dark:bg-slate-800 px-4 py-2 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali
            </a>
        </div>

        {{-- TAMBAHAN: ALERT JIKA ALAMAT KOSONG --}}
        @if(!$pelanggan->latitude || !$pelanggan->alamat_lengkap)
            <div class="bg-rose-50 dark:bg-rose-950/30 border border-rose-100 dark:border-rose-800 p-6 rounded-[2.5rem] flex flex-col md:flex-row items-center justify-between gap-6 animate-pulse">
                <div class="flex items-center gap-4 text-center md:text-left">
                    <div class="w-14 h-14 bg-rose-500 text-white rounded-2xl flex items-center justify-center shrink-0 shadow-lg shadow-rose-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <circle cx="12" cy="11" r="3" stroke-width="2"></circle>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-black text-rose-900 dark:text-rose-200 uppercase tracking-widest text-xs mb-1">Alamat Belum Lengkap!</h4>
                        <p class="text-rose-700/80 dark:text-rose-400/80 text-sm font-medium">Silahkan atur lokasi penjemputan Anda terlebih dahulu agar kurir bisa menemukan lokasi Anda.</p>
                    </div>
                </div>
                <a href="{{ route('pelanggan.alamat') }}" class="px-6 py-3 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-rose-500/25 whitespace-nowrap">
                    Atur Lokasi Sekarang
                </a>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div
                    class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                    <div class="p-8">
                        <form
                            action="{{ isset($transaksi) ? route('pelanggan.layanan.update', $transaksi->id) : route('pelanggan.layanan.store') }}"
                            method="POST" id="orderForm">
                            @csrf
                            @if (isset($transaksi))
                                @method('PUT')
                            @endif

                            <div class="space-y-6">
                                <div
                                    class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-700 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center font-black text-lg">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">
                                                Pemesan</p>
                                            <p class="font-bold text-slate-700 dark:text-slate-200">{{ Auth::user()->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="pelanggan_id" value="{{ $pelanggan->id }}">
                                    <span
                                        class="px-3 py-1 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold rounded-lg uppercase tracking-tight">Akun
                                        Aktif</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">Pilih
                                            Layanan</label>
                                        <select name="layanan_id" id="layananSelect"
                                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-brand outline-none transition appearance-none cursor-pointer text-sm"
                                            required>
                                            <option value="" disabled selected>- Pilih Layanan -</option>
                                            @foreach ($layanan as $l)
                                                <option value="{{ $l->id }}" data-harga="{{ $l->harga_perkilo }}"
                                                    {{ old('layanan_id', $transaksi->layanan_id ?? '') == $l->id ? 'selected' : '' }}>
                                                    {{ $l->nama_layanan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">Estimasi
                                            Berat</label>
                                        <div class="relative">
                                            <input type="number" step="0.1" name="berat" id="beratInput"
                                                class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-brand outline-none transition text-sm"
                                                placeholder="0.0" value="{{ old('berat', $transaksi->berat ?? '') }}"
                                                required>
                                            <span
                                                class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">KG</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">Promo
                                            / Diskon</label>
                                        <select name="diskon_id" id="diskonSelect"
                                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-brand outline-none transition appearance-none cursor-pointer text-sm">
                                            <option value="">- Tanpa Diskon -</option>
                                            @foreach ($diskon as $d)
                                                @if ((int) $d->aktif === 1)
                                                    <option value="{{ $d->id }}" data-tipe="{{ $d->tipe }}"
                                                        data-nilai="{{ $d->nilai }}">
                                                        {{ $d->nama_diskon }}
                                                        ({{ $d->tipe == 'persentase' ? (float) $d->nilai . '%' : 'Rp' . number_format($d->nilai, 0) }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">Metode
                                            Pembayaran</label>
                                        <select name="metode_pembayaran"
                                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-brand outline-none transition appearance-none cursor-pointer text-sm"
                                            required>
                                            <option value="" disabled selected>- Pilih Metode -</option>
                                            <option value="tunai"
                                                {{ old('metode_pembayaran', $transaksi->metode_pembayaran ?? '') == 'tunai' ? 'selected' : '' }}>
                                                Tunai / Cash</option>
                                            <option value="qris"
                                                {{ old('metode_pembayaran', $transaksi->metode_pembayaran ?? '') == 'qris' ? 'selected' : '' }}>
                                                QRIS / E-Wallet</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">Catatan
                                        Khusus</label>
                                    <textarea name="catatan" rows="3"
                                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-brand outline-none transition text-sm placeholder:text-slate-400"
                                        placeholder="Contoh: Tolong sprei dipisah, jangan pakai pewangi kuat...">{{ old('catatan', $transaksi->catatan ?? '') }}</textarea>
                                </div>

                                {{-- TOMBOL DENGAN KONDISI --}}
                                <button type="submit"
                                    {{ (!$pelanggan->latitude || !$pelanggan->alamat_lengkap) ? 'disabled' : '' }}
                                    class="w-full py-4 {{ (!$pelanggan->latitude || !$pelanggan->alamat_lengkap) ? 'bg-slate-300 dark:bg-slate-800 cursor-not-allowed text-slate-500' : 'bg-brand hover:bg-brandDark text-white shadow-brand/20 hover:scale-[1.02]' }} rounded-2xl font-black shadow-lg transition-all active:scale-95 flex items-center justify-center gap-3 mt-4 text-sm uppercase tracking-widest">
                                    @if(!$pelanggan->latitude || !$pelanggan->alamat_lengkap)
                                        <span>📍 Alamat Belum Lengkap</span>
                                    @else
                                        <span>{{ isset($transaksi) ? 'Perbarui Pesanan' : 'Lanjut ke Ringkasan Nota' }}</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl sticky top-24 overflow-hidden group">
                    <div
                        class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-colors">
                    </div>

                    <h4 class="font-black text-xl mb-6 flex items-center gap-3 relative z-10">
                        <span class="p-2 bg-white/10 rounded-xl">🧾</span>
                        Ringkasan Nota
                    </h4>

                    <div class="space-y-4 border-b border-white/10 pb-6 mb-6 relative z-10">
                        <div class="flex justify-between text-sm">
                            <span class="text-white/60 font-medium">Harga /kg</span>
                            <span id="label-harga" class="font-bold">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-white/60 font-medium">Berat Cucian</span>
                            <span id="label-berat" class="font-bold">0 kg</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-white/60 font-medium">Potongan Diskon</span>
                            <span id="label-diskon" class="text-emerald-400 font-bold">Rp 0</span>
                        </div>
                        {{-- TAMBAHAN: INFO POIN --}}
                        <div class="flex justify-between text-sm pt-2 border-t border-white/5">
                            <span class="text-white/60 font-medium">🪙 Estimasi Poin</span>
                            <span id="label-poin" class="text-amber-400 font-bold">+ 0</span>
                        </div>
                    </div>

                    <div class="flex flex-col relative z-10">
                        <span class="text-[10px] text-white/50 uppercase font-black tracking-[0.2em] mb-1">Total
                            Bayar</span>
                        <span id="label-total" class="text-4xl font-black tracking-tighter">Rp 0</span>
                    </div>

                    <div class="mt-8 bg-white/5 p-4 rounded-2xl border border-white/10 relative z-10">
                        <div class="flex gap-3">
                            <span class="text-xl">💡</span>
                            <p class="text-[10px] text-white/60 leading-relaxed font-medium">
                                Harga ini adalah estimasi sementara. Total akhir akan divalidasi oleh tim laundry saat
                                penimbangan ulang.
                            </p>
                        </div>
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
        const labelPoin = document.getElementById('label-poin'); // ID baru
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

            if (diskonTipe === 'persentase') {
                potongan = (subtotal * diskonNilai) / 100;
            } else {
                potongan = diskonNilai;
            }

            let total = subtotal - potongan;
            if (total < 0) total = 0;

            // Logika Poin: Total / 10
            let poin = Math.floor(total / 10);

            // Update Labels
            labelHarga.textContent = `Rp ${harga.toLocaleString('id-ID')} /kg`;
            labelBerat.textContent = `${berat} kg`;
            labelDiskon.textContent = `- Rp ${potongan.toLocaleString('id-ID')}`;
            labelPoin.textContent = `+ ${poin.toLocaleString('id-ID')}`; // Update Poin
            labelTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        [layananSelect, beratInput, diskonSelect].forEach(el => {
            el.addEventListener('change', calculateLive);
            el.addEventListener('input', calculateLive);
        });

        calculateLive();
    </script>
@endsection