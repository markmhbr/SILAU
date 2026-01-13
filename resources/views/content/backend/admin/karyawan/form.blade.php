@extends('layouts.home')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Tambah Karyawan Baru</h2>
            <p class="text-sm text-slate-500">Buat akun akses untuk staf laundry</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <a href="{{ route('admin.karyawan.index') }}" class="hover:text-primary-600">Karyawan</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">Tambah</span>
        </nav>
    </div>

    <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 p-4 rounded-2xl flex items-start gap-4">
        <div class="w-10 h-10 bg-indigo-500 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-indigo-500/20">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="text-sm text-indigo-800 dark:text-indigo-300">
            <p class="font-bold mb-1">Informasi Akun:</p>
            <p>Admin hanya membuatkan akun dasar (Email & Jabatan). Detail pribadi seperti alamat dan nomor HP akan dilengkapi oleh karyawan melalui profil mereka masing-masing.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 dark:text-white">Formulir Akun Karyawan</h3>
            <a href="{{ route('admin.karyawan.index') }}" class="text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.karyawan.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-user text-xs"></i>
                            </div>
                            <input type="text" name="name" id="name" 
                                class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:white focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                                placeholder="Masukkan nama karyawan" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Email Perusahaan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-envelope text-xs"></i>
                            </div>
                            <input type="email" name="email" id="email" 
                                class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:white focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                                placeholder="email@laundry.com" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="jabatan_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Jabatan / Posisi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-briefcase text-xs"></i>
                            </div>
                            <select name="jabatan_id" id="jabatan_id" 
                                class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:white focus:ring-2 focus:ring-indigo-500 outline-none transition-all" required>
                                <option value="" disabled selected>Pilih Jabatan</option>
                                @foreach($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Password Sementara</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-lock text-xs"></i>
                            </div>
                            <input type="password" name="password" id="password" 
                                class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:white focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                                placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <button type="reset" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all">
                        Reset
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition shadow-md shadow-indigo-500/20">
                        <i class="fas fa-save mr-2"></i> Simpan Akun Karyawan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection