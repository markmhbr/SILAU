@extends('layouts.home')

@section('title', 'Data Absensi Karyawan')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Data Absensi Karyawan</h1>
            <p class="text-slate-500 mt-2">Pantau kehadiran seluruh karyawan tokoh.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif



        <!-- Tabel Rekap -->
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center">
                <h3 class="text-lg font-bold">Semua Riwayat Kehadiran</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left" id="dataTable">
                    <thead class="bg-slate-50 dark:bg-slate-900/50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Karyawan</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Waktu Masuk</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Waktu Keluar</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($absensis as $absen)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-xs">
                                            {{ substr($absen->karyawan->user->name ?? '?', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm">{{ $absen->karyawan->user->name ?? 'Unknown' }}</p>
                                            <p class="text-[10px] text-slate-500">
                                                {{ $absen->karyawan->jabatan->nama_jabatan ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($absen->waktu_masuk)
                                        {{ $absen->waktu_masuk }}
                                        @if ($absen->latitude)
                                            <a href="https://www.google.com/maps?q={{ $absen->latitude }},{{ $absen->longitude }}"
                                                target="_blank" class="text-blue-500 ml-1" title="Lihat Peta">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </a>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $absen->waktu_keluar ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full 
                                {{ $absen->status == 'hadir'
                                    ? 'bg-green-100 text-green-700'
                                    : ($absen->status == 'izin'
                                        ? 'bg-blue-100 text-blue-700'
                                        : ($absen->status == 'sakit'
                                            ? 'bg-amber-100 text-amber-700'
                                            : 'bg-red-100 text-red-700')) }}">
                                        {{ ucfirst($absen->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button"
                                        onclick="openEditModal({{ $absen->id }}, '{{ $absen->status }}', `{{ $absen->keterangan ?? '' }}`)"
                                        class="text-blue-500 hover:text-blue-700 p-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada data absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl w-full max-w-md mx-4 overflow-hidden shadow-2xl transform transition-all">
            <div
                class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Update Status Absensi</h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-red-500 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="editForm" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Status</label>
                    <select name="status" id="edit_status"
                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 px-4 py-2.5 focus:ring-2 focus:ring-primary-500 transition-all dark:text-white"
                        required>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alfa">Alfa</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Keterangan
                        Tambahan</label>
                    <textarea name="keterangan" id="edit_keterangan" rows="3"
                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 px-4 py-2.5 focus:ring-2 focus:ring-primary-500 transition-all dark:text-white"
                        placeholder="Contoh: Sakit demam berdarah / Izin keperluan keluarga"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-xl transition-colors shadow-lg shadow-primary-500/30">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    @endpush
@endsection
