@extends('layouts.backend')

@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8 animate-fadeIn">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <nav class="flex text-[10px] uppercase tracking-widest text-slate-400 mb-2 space-x-2 font-bold">
                    <a href="#" class="hover:text-brand transition">Home</a>
                    <span>/</span>
                    <span class="text-slate-600 dark:text-slate-300">Pengaturan Profil</span>
                </nav>
                <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Profil Saya</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola informasi pribadi dan keamanan akun Anda
                    dalam satu tempat.</p>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>

            <div class="p-8 md:p-12 relative z-10">
                <form action="{{ route('pelanggan.profil.update', $pelanggan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col lg:flex-row gap-16">
                        <div class="w-full lg:w-1/3 flex flex-col items-center">
                            <div class="relative group">
                                <div
                                    class="absolute -inset-2 bg-gradient-to-tr from-brand to-indigo-500 rounded-full opacity-20 group-hover:opacity-40 blur transition duration-500">
                                </div>

                                <div
                                    class="relative w-52 h-52 rounded-full overflow-hidden border-4 border-white dark:border-slate-800 shadow-2xl">
                                    <img id="profile-photo"
                                        src="{{ $pelanggan->foto ? asset('storage/' . $pelanggan->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($pelanggan->user->name) . '&background=0ea5e9&color=fff&size=200' }}"
                                        alt="Foto Profil"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </div>

                                <label for="foto-input"
                                    class="absolute bottom-4 right-4 w-12 h-12 bg-brand hover:bg-brandDark text-white rounded-2xl flex items-center justify-center cursor-pointer shadow-xl transition-all hover:scale-110 hover:rotate-12 active:scale-90 border-4 border-white dark:border-slate-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </label>
                            </div>

                            <div class="mt-8 text-center">
                                <h3 class="text-xl font-black text-slate-800 dark:text-white">{{ $pelanggan->user->name }}
                                </h3>
                                <span
                                    class="inline-block mt-2 px-4 py-1 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-full">
                                    Member Premium
                                </span>
                            </div>

                            <input type="file" id="foto-input" name="foto" class="hidden" accept="image/*">
                            <p class="mt-6 text-[10px] text-slate-400 uppercase font-bold tracking-widest">Format: JPG, PNG
                                (Maks 2MB)</p>
                        </div>

                        <div class="w-full lg:w-2/3 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama
                                        Lengkap</label>
                                    <div class="group relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-brand transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="text" name="nama"
                                            value="{{ old('nama', $pelanggan->user->name) }}"
                                            class="w-full pl-12 pr-6 py-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 focus:bg-white dark:focus:bg-slate-800 focus:ring-4 focus:ring-brand/10 focus:border-brand outline-none transition-all font-semibold"
                                            placeholder="Masukkan nama lengkap">
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor
                                        WhatsApp Aktif</label>
                                    <div class="group relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-brand transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="tel" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}"
                                            class="w-full pl-12 pr-6 py-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 focus:bg-white dark:focus:bg-slate-800 focus:ring-4 focus:ring-brand/10 focus:border-brand outline-none transition-all font-semibold font-mono"
                                            placeholder="08xxxxxxxxxx">
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat
                                        Penjemputan</label>
                                    <div class="group relative">
                                        <div class="absolute bottom-4 right-4 z-10">
                                            <a href="{{ route('pelanggan.alamat') }}"
                                                class="flex items-center gap-2 px-3 py-1.5 bg-brand hover:bg-brandDark text-white rounded-xl text-[10px] font-black transition-all shadow-lg hover:scale-105 active:scale-95">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                                EDIT ALAMAT LENGKAP
                                            </a>
                                        </div>

                                        <div
                                            class="absolute top-4 left-4 text-slate-400 group-focus-within:text-brand transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>

                                        <textarea readonly
                                            class="w-full pl-12 pr-6 pt-4 pb-16 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 outline-none transition-all font-semibold leading-relaxed cursor-not-allowed"
                                            rows="4">{{ $pelanggan->alamat_gabungan }}</textarea>
                                    </div>
                                    <p class="mt-2 ml-1 text-[10px] text-slate-400 font-bold italic">* Alamat mencakup
                                        koordinat GPS untuk akurasi penjemputan.</p>
                                </div>
                            </div>

                            <div class="pt-6">
                                <button type="submit"
                                    class="group w-full md:w-auto bg-slate-900 dark:bg-brand hover:bg-black dark:hover:bg-brandDark text-white px-10 py-4 rounded-2xl font-black text-sm transition-all hover:shadow-2xl hover:shadow-brand/20 active:scale-95 flex items-center justify-center gap-3">
                                    <span>Simpan Perubahan Profil</span>
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview Foto Profil secara Instan
        const fotoInput = document.getElementById('foto-input');
        const profilePhoto = document.getElementById('profile-photo');

        fotoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePhoto.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
@endsection
