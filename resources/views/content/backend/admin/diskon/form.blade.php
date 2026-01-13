@extends('layouts.home')

@section('title', isset($diskon) ? 'Edit Diskon' : 'Tambah Diskon')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">{{ isset($diskon) ? 'Edit Diskon' : 'Tambah Diskon Baru' }}</h2>
            <p class="text-sm text-slate-500">Konfigurasi nilai dan syarat potongan harga</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <a href="{{ route('admin.diskon.index') }}" class="hover:text-primary-600">Diskon</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">{{ isset($diskon) ? 'Edit' : 'Tambah' }}</span>
        </nav>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 flex items-center justify-center">
                    <i class="fas fa-tag"></i>
                </div>
                <h3 class="font-bold text-slate-800 dark:text-white">Detail Informasi Diskon</h3>
            </div>
            <a href="{{ route('admin.diskon.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700 flex items-center gap-2 transition-colors">
                <i class="fas fa-arrow-left text-xs"></i> Kembali
            </a>
        </div>

        <div class="p-8">
            <form action="{{ isset($diskon) ? route('admin.diskon.update', $diskon->id) : route('admin.diskon.store') }}" method="POST">
                @csrf
                @if(isset($diskon))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="md:col-span-2 lg:col-span-1">
                        <label for="nama_diskon" class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Nama Diskon</label>
                        <input type="text" id="nama_diskon" name="nama_diskon" 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-amber-500 outline-none transition"
                            placeholder="Contoh: Promo Ramadhan" value="{{ old('nama_diskon', $diskon->nama_diskon ?? '') }}" required>
                    </div>

                    <div>
                        <label for="tipe" class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Tipe Potongan</label>
                        <select id="tipe" name="tipe" 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-amber-500 outline-none transition cursor-pointer" required>
                            <option value="" disabled selected>- Pilih Tipe -</option>
                            <option value="persentase" {{ (old('tipe', $diskon->tipe ?? '') == 'persentase') ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="nominal" {{ (old('tipe', $diskon->tipe ?? '') == 'nominal') ? 'selected' : '' }}>Nominal (Rp)</option>
                        </select>
                    </div>

                    <div>
                        <label for="nilai" class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Nilai Diskon</label>
                        <div class="relative">
                            <input type="number" id="nilai" name="nilai" 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-amber-500 outline-none transition"
                                placeholder="0" value="{{ old('nilai', isset($diskon) ? (float)$diskon->nilai : '') }}" required min="0">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 font-bold" id="tipe-suffix">
                                {{ (old('tipe', $diskon->tipe ?? '') == 'persentase') ? '%' : 'Rp' }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="minimal_transaksi" class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Min. Transaksi (Rp)</label>
                        <input type="number" id="minimal_transaksi" name="minimal_transaksi" 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-amber-500 outline-none transition"
                            placeholder="0" value="{{ old('minimal_transaksi', isset($diskon) ? (float)$diskon->minimal_transaksi : 0) }}" min="0" required>
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-700 pt-8">
                    <button type="reset" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                        Reset
                    </button>
                    <button type="submit" class="px-10 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold shadow-lg shadow-amber-500/30 transition-all hover:scale-[1.02] active:scale-95">
                        <i class="fas fa-save mr-2"></i> {{ isset($diskon) ? 'Simpan Perubahan' : 'Buat Diskon' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script sederhana untuk mengubah suffix label (Rp/%) secara dinamis
    document.getElementById('tipe').addEventListener('change', function() {
        const suffix = document.getElementById('tipe-suffix');
        suffix.textContent = this.value === 'persentase' ? '%' : 'Rp';
    });
</script>
@endsection