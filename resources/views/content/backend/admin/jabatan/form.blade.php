@extends('layouts.home')

@section('title', isset($jabatan) ? 'Edit Jabatan' : 'Tambah Jabatan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                {{ isset($jabatan) ? 'Edit Jabatan' : 'Tambah Jabatan Baru' }}
            </h2>
            <p class="text-sm text-slate-500">Tentukan nama posisi dan tanggung jawabnya</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <a href="{{ route('admin.jabatan.index') }}" class="hover:text-primary-600">Jabatan</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">{{ isset($jabatan) ? 'Edit' : 'Tambah' }}</span>
        </nav>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden max-w-2xl">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 dark:text-white">Formulir Jabatan</h3>
            <a href="{{ route('admin.jabatan.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <div class="p-6">
            <form action="{{ isset($jabatan) ? route('admin.jabatan.update', $jabatan->id) : route('admin.jabatan.store') }}" method="POST">
                @csrf
                @if(isset($jabatan)) @method('PUT') @endif

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label for="nama_jabatan" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Jabatan</label>
                        <input type="text" name="nama_jabatan" id="nama_jabatan" 
                            class="block w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                            placeholder="Contoh: Admin, Kurir, Tukang Cuci" 
                            value="{{ old('nama_jabatan', $jabatan->nama_jabatan ?? '') }}" required>
                    </div>

                    <div class="space-y-2">
                        <label for="deskripsi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="block w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                            placeholder="Tuliskan singkat tugas jabatan ini">{{ old('deskripsi', $jabatan->deskripsi ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <button type="reset" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-all">
                        Reset
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition shadow-md shadow-indigo-500/20">
                        <i class="fas fa-save mr-2"></i> {{ isset($jabatan) ? 'Perbarui' : 'Simpan' }} Jabatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection