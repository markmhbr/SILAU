@extends('layouts.home')

@section('title', 'Daftar Jabatan')

@section('content')
    <div x-data="{
        modalOpen: false,
        isEdit: false,
        formAction: '',
        formData: { id: '', nama_jabatan: '', deskripsi: '' },
        openModal(edit = false, data = null) {
            this.isEdit = edit;
            if (edit && data) {
                this.formData = { ...data };
                this.formAction = '{{ route('admin.jabatan.index') }}/' + data.id;
            } else {
                this.formData = { id: '', nama_jabatan: '', deskripsi: '' };
                this.formAction = '{{ route('admin.jabatan.store') }}';
            }
            this.modalOpen = true;
        }
    }" class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Daftar Jabatan</h2>
                <p class="text-sm text-slate-500">Kelola struktur posisi karyawan laundry</p>
            </div>
            <button @click="openModal(false)"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/25 flex items-center gap-2 active:scale-95">
                <i class="fas fa-plus-circle text-lg"></i> Tambah Jabatan Baru
            </button>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table id="jabatanTable" class="w-full text-sm text-left">
                        <thead>
                            <tr
                                class="text-slate-400 dark:text-slate-500 border-b border-slate-100 dark:border-slate-700 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-4 py-5 text-center w-12">No</th>
                                <th class="px-4 py-5">Nama Jabatan</th>
                                <th class="px-4 py-5">Deskripsi Tanggung Jawab</th>
                                <th class="px-4 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                            @foreach ($jabatans as $jabatan)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors group">
                                    <td class="px-4 py-5 text-center text-slate-400 font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-5">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-black text-slate-800 dark:text-white text-base leading-tight">{{ $jabatan->nama_jabatan }}</span>
                                            <span
                                                class="text-[10px] text-indigo-500 font-bold uppercase tracking-wider mt-1">ID:
                                                #JOB-{{ str_pad($jabatan->id, 3, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5">
                                        <p class="text-slate-500 dark:text-slate-400 text-xs italic max-w-md line-clamp-2">
                                            {{ $jabatan->deskripsi ?? 'Tidak ada deskripsi tanggung jawab.' }}
                                        </p>
                                    </td>
                                    <td class="px-4 py-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <button
                                                @click="openModal(true, { id: '{{ $jabatan->id }}', nama_jabatan: '{{ $jabatan->nama_jabatan }}', deskripsi: '{{ $jabatan->deskripsi }}' })"
                                                class="w-10 h-10 flex items-center justify-center rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                            <form action="{{ route('admin.jabatan.destroy', $jabatan->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-10 h-10 flex items-center justify-center rounded-2xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white transition-all shadow-sm">
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

        <!-- Premium Modal Component -->
        <template x-teleport="body">
            <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 lg:p-8" x-cloak>
                <!-- Backdrop -->
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen = false"
                    class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

                <!-- Modal Content -->
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                    class="relative w-full max-w-xl bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl border border-white/20 overflow-hidden">

                    <div
                        class="px-8 py-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-black text-slate-800 dark:text-white"
                                x-text="isEdit ? 'Perbarui Jabatan' : 'Tambah Jabatan Baru'"></h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Detail Informasi
                                Posisi & Tanggung Jawab</p>
                        </div>
                        <button @click="modalOpen = false"
                            class="w-10 h-10 flex items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-rose-500 hover:text-white transition-all">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form :action="formAction" method="POST" class="p-8">
                        @csrf
                        <template x-if="isEdit">
                            @method('PUT')
                        </template>

                        <div class="space-y-6">
                            <!-- Input Nama Jabatan -->
                            <div class="group">
                                <label
                                    class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama
                                    Jabatan <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fas fa-briefcase text-sm"></i>
                                    </div>
                                    <input type="text" name="nama_jabatan" x-model="formData.nama_jabatan" required
                                        class="block w-full pl-11 pr-4 py-4 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all"
                                        placeholder="Contoh: Senior Admin, Kurir Express, Kasir Utama">
                                </div>
                                <p class="text-[10px] text-slate-400 mt-2 px-1 font-medium italic">Gunakan nama yang jelas
                                    untuk membedakan setiap peran di sistem.</p>
                            </div>

                            <!-- Input Deskripsi -->
                            <div class="group">
                                <label
                                    class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Deskripsi
                                    Tugas <span class="text-slate-300 font-normal">(Opsional)</span></label>
                                <div class="relative">
                                    <div
                                        class="absolute top-4 left-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fas fa-align-left text-sm"></i>
                                    </div>
                                    <textarea name="deskripsi" x-model="formData.deskripsi" rows="4"
                                        class="block w-full pl-11 pr-4 py-4 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all resize-none"
                                        placeholder="Jelaskan secara singkat tanggung jawab utama dari jabatan ini..."></textarea>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-2 px-1 font-medium italic">Opsional: Memberikan
                                    konteks lebih mendalam bagi pengelolaan SDM.</p>
                            </div>
                        </div>

                        <div class="mt-10 flex items-center gap-3">
                            <button type="button" @click="modalOpen = false"
                                class="flex-1 px-6 py-4 rounded-2xl text-sm font-black text-slate-500 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 transition-all uppercase tracking-widest">
                                Batalkan
                            </button>
                            <button type="submit"
                                class="flex-[2] bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-4 rounded-2xl text-sm font-black transition-all shadow-xl shadow-indigo-600/30 flex items-center justify-center gap-2 active:scale-95 uppercase tracking-widest">
                                <i class="fas fa-save text-lg"></i>
                                <span x-text="isEdit ? 'Simpan Perubahan' : 'Simpan Jabatan'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <script>
        $(document).ready(function() {
            $('#jabatanTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Cari jabatan...",
                    "paginate": {
                        "previous": "<i class='fas fa-chevron-left'></i>",
                        "next": "<i class='fas fa-chevron-right'></i>"
                    }
                }
            });

            $('.dataTables_filter input').addClass(
                'bg-white dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none px-6 py-3 w-72 mb-4 transition-all'
            );
        });
    </script>

    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
            margin: 0 4px !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: transparent !important;
        }

        .dataTables_paginate .paginate_button i {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #f8fafc;
            color: #64748b;
            transition: all 0.3s;
            border: 2px solid #f1f5f9;
        }

        .dark .dataTables_paginate .paginate_button i {
            background: #1e293b;
            color: #94a3b8;
            border-color: #334155;
        }

        .dataTables_paginate .paginate_button.current i {
            background: #6366f1;
            color: white;
            border-color: #6366f1;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
