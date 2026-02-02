@extends('layouts.backend')

@section('title', 'Profil Owner')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8 animate-fadeIn">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <nav class="flex text-[10px] uppercase tracking-widest text-slate-400 mb-2 space-x-2 font-bold">
                    <a href="{{ route('owner.dashboard') }}" class="hover:text-brand transition">Home</a>
                    <span>/</span>
                    <span class="text-slate-600 dark:text-slate-300">Pengaturan Profil</span>
                </nav>
                <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
                    Profil Owner
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Kelola informasi akun dan identitas pemilik usaha.
                </p>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>

            <div class="p-8 md:p-12 relative z-10">
                <form action="{{ route('owner.profil.update', $owner->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col lg:flex-row gap-16">
                        {{-- FOTO PROFIL --}}
                        <div class="w-full lg:w-1/3 flex flex-col items-center">
                            <div class="relative group">
                                <div
                                    class="absolute -inset-2 bg-gradient-to-tr from-emerald-500 to-teal-500 rounded-full opacity-20 group-hover:opacity-40 blur transition duration-500">
                                </div>

                                <div
                                    class="relative w-52 h-52 rounded-full overflow-hidden border-4 border-white dark:border-slate-800 shadow-2xl">
                                    <img id="profile-photo"
                                        src="{{ $owner->foto
                                            ? asset('storage/' . $owner->foto)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($owner->user->name) . '&background=10b981&color=fff&size=200' }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </div>

                                <label for="foto-input"
                                    class="absolute bottom-4 right-4 w-12 h-12 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl flex items-center justify-center cursor-pointer shadow-xl transition-all hover:scale-110 hover:rotate-12 active:scale-90 border-4 border-white dark:border-slate-900">
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
                                <h3 class="text-xl font-black text-slate-800 dark:text-white">
                                    {{ $owner->user->name }}
                                </h3>
                                <span
                                    class="inline-block mt-2 px-4 py-1 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-full">
                                    OWNER
                                </span>
                            </div>

                            <input type="file" id="foto-input" name="foto" class="hidden" accept="image/*">
                            <p class="mt-6 text-[10px] text-slate-400 uppercase font-bold tracking-widest">
                                Format: JPG, PNG (Maks 2MB)
                            </p>
                        </div>

                        {{-- DATA OWNER --}}
                        <div class="w-full lg:w-2/3 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div class="md:col-span-2">
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">
                                        Nama Lengkap
                                    </label>
                                    <input type="text" name="nama"
                                        value="{{ old('nama', $owner->user->name) }}"
                                        class="w-full px-6 py-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 focus:ring-4 focus:ring-emerald-500/10 font-semibold">
                                </div>

                                <div class="md:col-span-2">
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">
                                        Nomor WhatsApp
                                    </label>
                                    <input type="tel" name="no_hp"
                                        value="{{ old('no_hp', $owner->no_hp) }}"
                                        class="w-full px-6 py-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 focus:ring-4 focus:ring-emerald-500/10 font-semibold font-mono">
                                </div>

                                <div class="md:col-span-2">
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">
                                        Alamat Owner
                                    </label>
                                    <textarea readonly rows="4"
                                        class="w-full px-6 py-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-800 text-slate-600 cursor-not-allowed">{{ $owner->alamat_gabungan }}</textarea>

                                    <a href="{{ route('owner.alamat') }}"
                                        class="inline-block mt-3 px-4 py-2 bg-emerald-500 text-white rounded-xl text-xs font-black">
                                        Edit Alamat
                                    </a>
                                </div>
                            </div>

                            <div class="pt-6">
                                <button type="submit"
                                    class="bg-slate-900 dark:bg-emerald-500 hover:bg-black text-white px-10 py-4 rounded-2xl font-black text-sm transition-all">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- PREVIEW FOTO --}}
    <script>
        const fotoInput = document.getElementById('foto-input');
        const profilePhoto = document.getElementById('profile-photo');

        fotoInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => profilePhoto.src = ev.target.result;
            reader.readAsDataURL(file);
        });
    </script>
@endsection
