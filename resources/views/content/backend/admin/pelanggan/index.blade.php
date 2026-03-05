@extends('layouts.home')

@section('title', 'Data Pelanggan')

@section('content')
    <div x-data="{
        modalOpen: false,
        isEdit: false,
        formAction: '',
        formData: { id: '', name: '', email: '', no_hp: '', alamat: '' },
        openModal(edit = false, data = null) {
            this.isEdit = edit;
            if (edit && data) {
                this.formData = { ...data };
                this.formAction = '{{ route('admin.pelanggan.index') }}/' + data.id;
            } else {
                this.formData = { id: '', name: '', email: '', no_hp: '', alamat: '' };
                this.formAction = '{{ route('admin.pelanggan.store') }}';
            }
            this.modalOpen = true;
        }
    }" class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Manajemen Pelanggan</h2>
                <p class="text-sm text-slate-500">Kelola database pelanggan untuk riwayat transaksi laundry</p>
            </div>
            <button @click="openModal(false)"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center gap-2 active:scale-95">
                <i class="fas fa-plus-circle"></i> Tambah Pelanggan Baru
            </button>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-all">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table id="customerTable" class="w-full text-sm text-left">
                        <thead>
                            <tr
                                class="text-slate-400 dark:text-slate-500 border-b border-slate-100 dark:border-slate-700 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-4 py-5 text-center w-12">No</th>
                                <th class="px-4 py-5">Nama Pelanggan</th>
                                <th class="px-4 py-5">Kontak WhatsApp</th>
                                <th class="px-4 py-5">Alamat Lengkap</th>
                                <th class="px-4 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                            @foreach ($pelanggans as $pelanggan)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors group">
                                    <td class="px-4 py-5 text-center text-slate-400 font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-5 font-bold">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-black">
                                                {{ substr($pelanggan->user->name ?? 'P', 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-slate-800 dark:text-white leading-tight font-black">{{ $pelanggan->user->name ?? 'Tanpa Nama' }}</span>
                                                <span
                                                    class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">{{ $pelanggan->user->email ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 font-medium">
                                        <a href="https://wa.me/{{ $pelanggan->no_hp }}" target="_blank"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-600 hover:text-white transition-all text-xs font-bold">
                                            <i class="fab fa-whatsapp"></i> {{ $pelanggan->no_hp }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-5 max-w-xs">
                                        <p class="text-slate-500 dark:text-slate-400 text-xs line-clamp-1 italic">
                                            {{ $pelanggan->alamat }}</p>
                                    </td>
                                    <td class="px-4 py-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <button
                                                @click="openModal(true, { id: '{{ $pelanggan->id }}', name: '{{ $pelanggan->user->name ?? '' }}', email: '{{ $pelanggan->user->email ?? '' }}', no_hp: '{{ $pelanggan->no_hp }}', alamat: '{{ $pelanggan->alamat }}' })"
                                                class="w-10 h-10 flex items-center justify-center rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all shadow-sm"
                                                title="Edit Data">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>

                                            <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-10 h-10 flex items-center justify-center rounded-2xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white transition-all shadow-sm"
                                                    title="Hapus Data">
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
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen = false"
                    class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

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
                                x-text="isEdit ? 'Ubah Informasi Pelanggan' : 'Daftarkan Pelanggan Baru'"></h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Data pelanggan
                                digunakan untuk penjemputan & notifikasi</p>
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
                            <!-- Input Nama -->
                            <div class="group">
                                <label
                                    class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama
                                    Pelanggan <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fas fa-user-circle text-sm"></i>
                                    </div>
                                    <input type="text" name="name" x-model="formData.name" required
                                        class="block w-full pl-11 pr-4 py-4 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all"
                                        placeholder="Contoh: Bpk. Kurniawan">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Input WhatsApp -->
                                <div class="group">
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">No.
                                        WhatsApp <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                            <i class="fab fa-whatsapp text-sm"></i>
                                        </div>
                                        <input type="text" name="no_hp" x-model="formData.no_hp" required
                                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all"
                                            placeholder="+62812xxxxxx">
                                    </div>
                                </div>

                                <!-- Input Email -->
                                <div class="group">
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Email
                                        <span class="text-slate-300 font-normal">(Opsional)</span></label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                            <i class="fas fa-envelope text-sm"></i>
                                        </div>
                                        <input type="email" name="email" x-model="formData.email"
                                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all"
                                            placeholder="untuk notifikasi struk">
                                    </div>
                                </div>
                            </div>

                            <!-- Input Alamat -->
                            <div class="group">
                                <label
                                    class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Alamat
                                    Penjemputan / Rumah <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div
                                        class="absolute top-4 left-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <i class="fas fa-map-marker-alt text-sm"></i>
                                    </div>
                                    <textarea name="alamat" x-model="formData.alamat" rows="3" required
                                        class="block w-full pl-11 pr-4 py-4 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all resize-none"
                                        placeholder="Jl. Mawar No. 12, Perumahan Asri..."></textarea>
                                </div>
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
                                <span x-text="isEdit ? 'Simpan Perubahan' : 'Simpan Pelanggan'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Cari database pelanggan...",
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
