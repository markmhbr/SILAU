@extends('layouts.home')
@section('title', 'Atur Jam Kerja')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Atur Jam Kerja</h1>
            <p class="text-slate-500 dark:text-slate-400">Tentukan jam masuk dan kepulangan standar untuk semua karyawan.</p>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden relative">
            <div class="p-6 sm:p-8">
                <form action="{{ route('admin.jam.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Jam Masuk -->
                        <div class="relative group">
                            <label for="jam_masuk"
                                class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Jam
                                Masuk</label>
                            <div class="relative flex items-center">
                                <i class="fas fa-sign-in-alt absolute left-4 text-emerald-500 text-lg"></i>
                                <input type="time" id="jam_masuk" name="jam_masuk"
                                    value="{{ \Carbon\Carbon::parse($jamKerja->jam_masuk)->format('H:i') }}"
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white font-medium text-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                                    required>
                            </div>
                            <p class="text-xs text-slate-500 mt-2">Batas paling lambat karyawan harus melakukan scan masuk.
                            </p>
                        </div>

                        <!-- Jam Keluar -->
                        <div class="relative group">
                            <label for="jam_keluar"
                                class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Jam
                                Keluar</label>
                            <div class="relative flex items-center">
                                <i class="fas fa-sign-out-alt absolute left-4 text-rose-500 text-lg"></i>
                                <input type="time" id="jam_keluar" name="jam_keluar"
                                    value="{{ \Carbon\Carbon::parse($jamKerja->jam_keluar)->format('H:i') }}"
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white font-medium text-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all outline-none"
                                    required>
                            </div>
                            <p class="text-xs text-slate-500 mt-2">Batas paling cepat karyawan diizinkan melakukan scan
                                pulang.</p>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-slate-100 dark:border-slate-700">
                        <button type="submit"
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm shadow-indigo-600/20 transition-all flex items-center gap-2 transform hover:-translate-y-0.5"
                            id="btn-save">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
