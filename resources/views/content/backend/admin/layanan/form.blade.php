@extends('layouts.home')

@section('title', isset($layanan) ? 'Edit Layanan' : 'Tambah Layanan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                {{ isset($layanan) ? 'Edit Layanan' : 'Tambah Layanan Baru' }}
            </h2>
            <p class="text-sm text-slate-500">Isi formulir di bawah ini untuk mengelola data paket laundry</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <a href="{{ route('admin.layanan.index') }}" class="hover:text-primary-600">Layanan</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">{{ isset($layanan) ? 'Edit' : 'Tambah' }}</span>
        </nav>
    </div>

    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 p-4 rounded-2xl flex items-start gap-4">
        <div class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-blue-500/20">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="text-sm text-blue-800 dark:text-blue-300">
            <p class="font-bold mb-1">Tips Pengisian:</p>
            <p>Pastikan harga yang dimasukkan adalah harga per kilogram (Kg) dan deskripsi menjelaskan cakupan layanan tersebut.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 dark:text-white">Formulir Layanan</h3>
            <a href="{{ route('admin.layanan.index') }}" class="text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <div class="p-6">
            <form action="{{ isset($layanan) ? route('admin.layanan.update', $layanan->id) : route('admin.layanan.store') }}" method="POST">
                @csrf
                @if(isset($layanan))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="nama_layanan" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Nama Layanan
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-tag text-xs"></i>
                            </div>
                            <input type="text" name="nama_layanan" id="nama_layanan" 
                                class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all placeholder:text-slate-400"
                                placeholder="Contoh: Cuci Kering Setrika" 
                                value="{{ old('nama_layanan', $layanan->nama_layanan ?? '') }}" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="harga_perkilo" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Harga per Kg
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <span class="text-xs font-bold">Rp</span>
                            </div>
                            <input type="number" name="harga_perkilo" id="harga_perkilo" 
                                class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all placeholder:text-slate-400"
                                placeholder="0" 
                                value="{{ old('harga_perkilo', $layanan->harga_perkilo ?? '') }}" required>
                        </div>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Deskripsi Layanan
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                            class="block w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all placeholder:text-slate-400"
                            placeholder="Jelaskan detail layanan (misal: Selesai dalam 2 hari)" required>{{ old('deskripsi', $layanan->deskripsi ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <button type="reset" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all">
                        Reset
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition shadow-md shadow-indigo-500/20">
                        <i class="fas fa-save mr-2"></i>
                        {{ isset($layanan) ? 'Perbarui Layanan' : 'Simpan Layanan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection