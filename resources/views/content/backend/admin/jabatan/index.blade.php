@extends('layouts.home')

@section('title', 'Daftar Jabatan')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Daftar Jabatan</h2>
                <p class="text-sm text-slate-500">Kelola struktur posisi karyawan laundry</p>
            </div>
            <a href="{{ route('admin.jabatan.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-md shadow-indigo-500/20">
                <i class="fas fa-plus mr-2"></i> Tambah Jabatan
            </a>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table id="jabatanTable" class="w-full text-sm text-left">
                        <thead>
                            <tr
                                class="text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700 uppercase text-[11px] tracking-wider">
                                <th class="px-4 py-4 font-bold text-center w-12">No</th>
                                <th class="px-4 py-4 font-bold">Nama Jabatan</th>
                                <th class="px-4 py-4 font-bold">Deskripsi</th>
                                <th class="px-4 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach ($jabatans as $jabatan)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                                    <td class="px-4 py-4 text-center text-slate-500">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4 font-bold text-slate-900 dark:text-white">
                                        {{ $jabatan->nama_jabatan }}
                                    </td>
                                    <td class="px-4 py-4 text-slate-500 dark:text-slate-400 italic text-xs">
                                        {{ $jabatan->deskripsi ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.jabatan.edit', $jabatan->id) }}"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 hover:bg-blue-600 hover:text-white transition-all">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <form action="{{ route('admin.jabatan.destroy', $jabatan->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus jabatan ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 hover:bg-rose-600 hover:text-white transition-all">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
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

    <script>
        $(document).ready(function() {
            $('#jabatanTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
                "language": {
                    "searchPlaceholder": "Cari jabatan..."
                }
            });
        });
    </script>
@endsection
