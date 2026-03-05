@extends('layouts.home')

@section('title', 'Manajemen Karyawan')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Daftar Karyawan</h2>
                <p class="text-sm text-slate-500">Kelola akun dan akses staf laundry</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.karyawan.print-all') }}" target="_blank"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-md shadow-emerald-500/20 flex items-center justify-center">
                    <i class="fas fa-print mr-2"></i> Cetak Semua Kartu
                </a>
                <button type="button" onclick="openModal('modalTambah')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-md shadow-indigo-500/20 flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i> Tambah Akun
                </button>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table id="karyawanTable" class="w-full text-sm text-left">
                        <thead>
                            <tr
                                class="text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700 uppercase text-[11px] tracking-wider">
                                <th class="px-4 py-4 font-bold text-center w-12">No</th>
                                <th class="px-4 py-4 font-bold">Nama / Email</th>
                                <th class="px-4 py-4 font-bold">Jabatan</th>
                                <th class="px-4 py-4 font-bold">Status Profile</th>
                                <th class="px-4 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach ($karyawans as $karyawan)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="px-4 py-4 text-center text-slate-500">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-bold text-slate-900 dark:text-white">{{ $karyawan->user->name }}</span>
                                            <span class="text-xs text-slate-500">{{ $karyawan->user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium">
                                            {{ $karyawan->jabatan->nama_jabatan ?? 'Belum Diatur' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        @if ($karyawan->no_hp)
                                            <span class="text-emerald-500 text-xs font-bold"><i
                                                    class="fas fa-check-circle mr-1"></i> Lengkap</span>
                                        @else
                                            <span class="text-amber-500 text-xs font-bold"><i class="fas fa-clock mr-1"></i>
                                                Menunggu Update</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.karyawan.print-card', $karyawan->id) }}"
                                                target="_blank"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 hover:bg-slate-200 dark:hover:bg-slate-600 transition-all"
                                                title="Cetak Kartu ID">
                                                <i class="fas fa-id-card text-sm"></i>
                                            </a>
                                            <button type="button" onclick="openModal('modalEdit{{ $karyawan->id }}')"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 hover:bg-blue-600 hover:text-white transition-all"
                                                title="Edit Data">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                            <form action="{{ route('admin.karyawan.destroy', $karyawan->user_id) }}"
                                                method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="btn-delete w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 hover:bg-rose-600 hover:text-white transition-all"
                                                    title="Hapus Data">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Modal Edit -->
                                        <div id="modalEdit{{ $karyawan->id }}"
                                            class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center px-4">
                                            <div
                                                class="bg-white dark:bg-slate-800 rounded-2xl w-full max-w-md p-6 shadow-xl relative">
                                                <h3 class="text-lg font-bold mb-4 text-left">Edit Akun Karyawan</h3>
                                                <form action="{{ route('admin.karyawan.update', $karyawan->id) }}"
                                                    method="POST" class="space-y-4 text-left">
                                                    @csrf
                                                    @method('PUT')
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Nama
                                                            Lengkap</label>
                                                        <input type="text" name="name"
                                                            value="{{ $karyawan->user->name }}"
                                                            class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 outline-none"
                                                            required>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Email</label>
                                                        <input type="email" name="email"
                                                            value="{{ $karyawan->user->email }}"
                                                            class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 outline-none"
                                                            required>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Password
                                                            <span class="text-xs text-slate-400 font-normal">(Kosongkan jika
                                                                tidak diubah)</span></label>
                                                        <input type="password" name="password"
                                                            class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 outline-none">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Jabatan</label>
                                                        <select name="jabatan_id"
                                                            class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 outline-none"
                                                            required>
                                                            @foreach ($jabatans as $jb)
                                                                <option value="{{ $jb->id }}"
                                                                    {{ $karyawan->jabatan_id == $jb->id ? 'selected' : '' }}>
                                                                    {{ $jb->nama_jabatan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="flex justify-end gap-3 mt-6">
                                                        <button type="button"
                                                            onclick="closeModal('modalEdit{{ $karyawan->id }}')"
                                                            class="px-4 py-2 text-sm text-slate-500">Batal</button>
                                                        <button type="submit"
                                                            class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modalTambah" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full max-w-md p-6 shadow-xl">
            <h3 class="text-lg font-bold mb-4">Buat Akun Karyawan</h3>
            <form action="{{ route('admin.karyawan.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                    <input type="text" name="name"
                        class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 outline-none"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Email</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 outline-none"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 outline-none"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Jabatan</label>
                    <select name="jabatan_id"
                        class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 outline-none"
                        required>
                        <option value="">Pilih Jabatan</option>
                        @foreach ($jabatans as $jb)
                            <option value="{{ $jb->id }}">{{ $jb->nama_jabatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal('modalTambah')"
                        class="px-4 py-2 text-sm text-slate-500">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold">Simpan
                        Akun</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        $(document).ready(function() {
            $('#karyawanTable').DataTable({
                "responsive": true,
                "language": {
                    "searchPlaceholder": "Cari karyawan..."
                }
            });
        });
    </script>
@endsection
