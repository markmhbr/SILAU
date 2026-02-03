@extends('layouts.backend')

@section('title', 'Pengaturan Owner')

@section('content')
    <div class="max-w-5xl mx-auto">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800 dark:text-white">
                    Pengaturan ⚙️
                </h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400">
                    Kelola identitas & informasi publik laundry Anda
                </p>
            </div>
        </div>

        {{-- FLASH MESSAGES --}}
        @if (session('success'))
            <div
                class="mb-8 bg-emerald-500 text-white px-6 py-4 rounded-[1.5rem] font-bold shadow-lg shadow-emerald-500/20 flex items-center gap-3">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('owner.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') {{-- Tambahkan baris ini --}}

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT COLUMN: LOGO & SOSIAL MEDIA --}}
                <div class="space-y-8">
                    {{-- LOGO --}}
                    <div
                        class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                        <h2 class="text-lg font-bold mb-6 flex items-center gap-2">🖼 Logo</h2>
                        <div class="flex flex-col items-center gap-4">
                            <div class="relative group">
                                {{-- Tambahkan ID dan pastikan ada ID pada pembungkus jika logo kosong --}}
                                <div id="preview-container">
                                    @if ($profil->logo)
                                        <img id="logo-preview" src="{{ asset('logo/' . $profil->logo) }}"
                                            class="w-32 h-32 rounded-[2rem] object-cover border-4 border-slate-50 shadow-md">
                                    @else
                                        <div id="logo-placeholder"
                                            class="w-32 h-32 rounded-[2rem] bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 border-2 border-dashed">
                                            No Logo
                                        </div>
                                        {{-- Hidden img element untuk menampung preview jika awalnya kosong --}}
                                        <img id="logo-preview" src="#"
                                            class="hidden w-32 h-32 rounded-[2rem] object-cover border-4 border-slate-50 shadow-md">
                                    @endif
                                </div>
                            </div>

                            <label class="w-full">
                                <span class="sr-only">Pilih Logo</span>
                                <input type="file" name="logo" id="logo-input" accept="image/*"
                                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-slate-800 file:text-white hover:file:bg-slate-700 cursor-pointer" />
                            </label>
                            <p class="text-[10px] text-slate-400">Format: JPG, PNG, WebP. Maks 2MB</p>
                        </div>
                    </div>

                    {{-- SOSIAL MEDIA --}}
                    <div
                        class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                        <h2 class="text-lg font-bold mb-6 flex items-center gap-2">🌐 Sosial Media</h2>
                        <div class="space-y-4">
                            @foreach (['instagram', 'facebook', 'tiktok', 'youtube'] as $sosmed)
                                <div class="relative">
                                    <input type="text" name="{{ $sosmed }}"
                                        placeholder="Username {{ ucfirst($sosmed) }}"
                                        value="{{ old($sosmed, $profil->$sosmed) }}"
                                        class="w-full pl-4 pr-4 py-3 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: IDENTITAS --}}
                <div class="lg:col-span-2 space-y-8">
                    <div
                        class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
                        <h2 class="text-lg font-bold mb-8 flex items-center gap-2">🏪 Profil Perusahaan</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label
                                    class="text-xs font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block">Nama
                                    Perusahaan</label>
                                <input type="text" name="nama_perusahaan"
                                    value="{{ old('nama_perusahaan', $profil->nama_perusahaan) }}"
                                    class="w-full py-3.5 px-5 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-emerald-500">
                            </div>

                            <div>
                                <label
                                    class="text-xs font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block">Email
                                    Bisnis</label>
                                <input type="email" name="email" value="{{ old('email', $profil->email) }}"
                                    class="w-full py-3.5 px-5 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-emerald-500">
                            </div>

                            <div>
                                <label
                                    class="text-xs font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block">WhatsApp</label>
                                <input type="text" name="no_wa" value="{{ old('no_wa', $profil->no_wa) }}"
                                    class="w-full py-3.5 px-5 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-emerald-500">
                            </div>

                            <div class="md:col-span-2">
                                <label
                                    class="text-xs font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block">Jam
                                    Operasional</label>
                                <input type="text" name="service_hours"
                                    value="{{ old('service_hours', $profil->service_hours) }}"
                                    placeholder="Contoh: Senin - Minggu (08.00 - 21.00)"
                                    class="w-full py-3.5 px-5 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-emerald-500">
                            </div>

                            <div class="md:col-span-2">
                                <label
                                    class="text-xs font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block">Alamat
                                    Lengkap</label>
                                <textarea name="alamat" rows="3"
                                    class="w-full py-3.5 px-5 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-emerald-500">{{ old('alamat', $profil->alamat) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- TENTANG KAMI --}}
                    <div
                        class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
                        <h2 class="text-lg font-bold mb-6 flex items-center gap-2">📖 Narasi Tentang Kami</h2>
                        <textarea name="tentang_kami" rows="6" placeholder="Ceritakan visi atau keunggulan laundry Anda..."
                            class="w-full py-4 px-6 rounded-[2rem] border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-emerald-500">{{ old('tentang_kami', $profil->tentang_kami) }}</textarea>
                    </div>

                    {{-- ACTION --}}
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="group relative px-10 py-4 bg-slate-900 dark:bg-white dark:text-slate-900 text-white rounded-[1.5rem] font-black text-lg transition-all hover:scale-105 active:scale-95 shadow-xl">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('logo-input').onchange = function(evt) {
            const [file] = this.files;
            if (file) {
                const preview = document.getElementById('logo-preview');
                const placeholder = document.getElementById('logo-placeholder');

                // Masukkan source gambar dari file yang dipilih
                preview.src = URL.createObjectURL(file);

                // Tampilkan gambar preview
                preview.classList.remove('hidden');

                // Sembunyikan placeholder "No Logo" jika ada
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }
        }
    </script>
@endsection
