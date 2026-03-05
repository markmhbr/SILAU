@extends('layouts.home')

@section('title', 'Manajemen Diskon')

@section('content')
    <div x-data="{
        modalOpen: false,
        isEdit: false,
        formAction: '',
        formData: { id: '', nama_diskon: '', tipe: 'persentase', nilai: '', minimal_transaksi: '' },
        openModal(edit = false, data = null) {
            this.isEdit = edit;
            if (edit && data) {
                this.formData = { ...data };
                this.formAction = '{{ route('admin.diskon.index') }}/' + data.id;
            } else {
                this.formData = { id: '', nama_diskon: '', tipe: 'persentase', nilai: '', minimal_transaksi: '' };
                this.formAction = '{{ route('admin.diskon.store') }}';
            }
            this.modalOpen = true;
        }
    }" class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Manajemen Diskon</h2>
                <p class="text-sm text-slate-500">Kelola promosi, kode voucher, dan potongan harga otomatis</p>
            </div>
            <button @click="openModal(false)"
                class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-amber-500/25 flex items-center justify-center gap-2 active:scale-95">
                <i class="fas fa-plus-circle"></i> Buat Promo Baru
            </button>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-all">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table id="diskonTable" class="w-full text-sm text-left">
                        <thead>
                            <tr
                                class="text-slate-400 dark:text-slate-500 border-b border-slate-100 dark:border-slate-700 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-4 py-5 text-center w-12">No</th>
                                <th class="px-4 py-5 font-bold">Nama Promo</th>
                                <th class="px-4 py-5">Jenis</th>
                                <th class="px-4 py-5 font-bold">Nilai Potongan</th>
                                <th class="px-4 py-5">Min. Belanja</th>
                                <th class="px-4 py-5 text-center">Status & Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                            @foreach ($diskon as $key => $d)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors group">
                                    <td class="px-4 py-5 text-center text-slate-400 font-medium">{{ $key + 1 }}</td>
                                    <td class="px-4 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl {{ (int) $d->aktif === 1 ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'bg-slate-100 text-slate-400 dark:bg-slate-700' }} flex items-center justify-center">
                                                <i class="fas fa-ticket-alt"></i>
                                            </div>
                                            <span
                                                class="font-black text-slate-800 dark:text-white">{{ $d->nama_diskon }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5">
                                        <span
                                            class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest">
                                            {{ $d->tipe }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-5 font-black text-indigo-600 dark:text-indigo-400 text-base">
                                        @if ($d->tipe === 'persentase')
                                            {{ (float) $d->nilai }}%
                                        @else
                                            Rp {{ number_format($d->nilai, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-5 font-bold text-slate-600 dark:text-slate-400">
                                        Rp {{ number_format($d->minimal_transaksi, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('admin.diskon.toggle', $d->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="w-10 h-10 flex items-center justify-center rounded-2xl transition-all shadow-sm {{ (int) $d->aktif === 1 ? 'bg-emerald-500 text-white hover:bg-emerald-600' : 'bg-slate-100 text-slate-400 hover:bg-slate-600 hover:text-white dark:bg-slate-700' }}"
                                                    title="{{ (int) $d->aktif === 1 ? 'Nonaktifkan Promo' : 'Aktifkan Promo' }}">
                                                    <i
                                                        class="fas {{ (int) $d->aktif === 1 ? 'fa-check-circle' : 'fa-power-off' }} text-sm"></i>
                                                </button>
                                            </form>

                                            <button
                                                @click="openModal(true, { id: '{{ $d->id }}', nama_diskon: '{{ $d->nama_diskon }}', tipe: '{{ $d->tipe }}', nilai: '{{ $d->nilai }}', minimal_transaksi: '{{ $d->minimal_transaksi }}' })"
                                                class="w-10 h-10 flex items-center justify-center rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all shadow-sm"
                                                title="Edit Data">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>

                                            <form action="{{ route('admin.diskon.destroy', $d->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn-delete w-10 h-10 flex items-center justify-center rounded-2xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white transition-all shadow-sm"
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
                                x-text="isEdit ? 'Sesuaikan Parameter Promo' : 'Buat Program Diskon Baru'"></h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Atur potongan
                                harga berdasarkan persentase atau nominal rupiah</p>
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
                            <!-- Input Nama Promo -->
                            <div class="group">
                                <label
                                    class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama
                                    Program Promo <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors">
                                        <i class="fas fa-ticket-alt text-sm"></i>
                                    </div>
                                    <input type="text" name="nama_diskon" x-model="formData.nama_diskon" required
                                        class="block w-full pl-11 pr-4 py-4 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all"
                                        placeholder="Contoh: Promo Ramadhan Berkah">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Input Tipe -->
                                <div class="group">
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Tipe
                                        Potongan <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors">
                                            <i class="fas fa-sliders-h text-sm"></i>
                                        </div>
                                        <select name="tipe" x-model="formData.tipe" required
                                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white font-bold focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all appearance-none cursor-pointer">
                                            <option value="persentase">Persentase (%)</option>
                                            <option value="nominal">Nominal Rupiah (Rp)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Input Nilai -->
                                <div class="group">
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">
                                        Besar Potongan <span
                                            x-text="formData.tipe === 'persentase' ? '(%)' : '(Rp)'"></span> <span
                                            class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors">
                                            <i class="fas fa-percentage text-sm"
                                                x-show="formData.tipe === 'persentase'"></i>
                                            <i class="fas fa-coins text-sm" x-show="formData.tipe === 'nominal'"></i>
                                        </div>
                                        <input type="number" name="nilai" x-model="formData.nilai" required
                                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white font-bold focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all"
                                            placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Input Minimal Transaksi -->
                            <div class="group">
                                <label
                                    class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Minimal
                                    Transaksi (Rp) <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors">
                                        <i class="fas fa-shopping-cart text-sm"></i>
                                    </div>
                                    <input type="number" name="minimal_transaksi" x-model="formData.minimal_transaksi"
                                        required
                                        class="block w-full pl-11 pr-4 py-4 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white font-bold focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all"
                                        placeholder="Contoh: 50000">
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex items-center gap-3">
                            <button type="button" @click="modalOpen = false"
                                class="flex-1 px-6 py-4 rounded-2xl text-sm font-black text-slate-500 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 transition-all uppercase tracking-widest">
                                Batalkan
                            </button>
                            <button type="submit"
                                class="flex-[2] bg-amber-500 hover:bg-amber-600 text-white px-6 py-4 rounded-2xl text-sm font-black transition-all shadow-xl shadow-amber-600/30 flex items-center justify-center gap-2 active:scale-95 uppercase tracking-widest">
                                <i class="fas fa-save text-lg"></i>
                                <span x-text="isEdit ? 'Simpan Perubahan' : 'Terbitkan Promo'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <script>
        $(document).ready(function() {
            $('#diskonTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Cari diskon & promo...",
                    "paginate": {
                        "previous": "<i class='fas fa-chevron-left'></i>",
                        "next": "<i class='fas fa-chevron-right'></i>"
                    }
                }
            });

            $('.dataTables_filter input').addClass(
                'bg-white dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none px-6 py-3 w-72 mb-4 transition-all'
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
            background: #f59e0b;
            color: white;
            border-color: #f59e0b;
            box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
