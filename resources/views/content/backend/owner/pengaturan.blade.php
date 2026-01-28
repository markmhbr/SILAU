@extends('layouts.backend')

@section('title', 'Pengaturan Owner')

@section('content')
<div>

    {{-- ================= HEADER ================= --}}
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800 dark:text-white">
            Pengaturan ⚙️
        </h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400">
            Kelola identitas & informasi perusahaan
        </p>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="mb-6 bg-emerald-100 text-emerald-700 px-6 py-4 rounded-[1.5rem] font-bold">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ================= FORM ================= --}}
    <form method="POST"
        action="{{ route('owner.pengaturan.update') }}"
        enctype="multipart/form-data"
        class="space-y-10">

        @csrf

        {{-- ================= IDENTITAS ================= --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border p-6 shadow-sm">
            <h2 class="text-xl font-black mb-6">🏪 Identitas Perusahaan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-xs font-bold text-slate-500 mb-2 block">
                        Nama Perusahaan
                    </label>
                    <input type="text" name="nama_perusahaan"
                        value="{{ old('nama_perusahaan', $profil->nama_perusahaan) }}"
                        class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 mb-2 block">
                        Email
                    </label>
                    <input type="email" name="email"
                        value="{{ old('email', $profil->email) }}"
                        class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 mb-2 block">
                        WhatsApp
                    </label>
                    <input type="text" name="no_wa"
                        value="{{ old('no_wa', $profil->no_wa) }}"
                        class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 mb-2 block">
                        Jam Operasional
                    </label>
                    <input type="text" name="service_hours"
                        value="{{ old('service_hours', $profil->service_hours) }}"
                        placeholder="08.00 - 17.00"
                        class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs font-bold text-slate-500 mb-2 block">
                        Alamat
                    </label>
                    <textarea name="alamat" rows="3"
                        class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">{{ old('alamat', $profil->alamat) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs font-bold text-slate-500 mb-2 block">
                        Deskripsi Singkat
                    </label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">{{ old('deskripsi', $profil->deskripsi) }}</textarea>
                </div>

            </div>
        </div>

        {{-- ================= LOGO ================= --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border p-6 shadow-sm">
            <h2 class="text-xl font-black mb-6">🖼 Logo Perusahaan</h2>

            <div class="flex items-center gap-6">
                @if($profil->logo)
                    <img src="{{ asset('storage/'.$profil->logo) }}"
                        class="w-24 h-24 rounded-2xl object-cover border">
                @else
                    <div class="w-24 h-24 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                        No Logo
                    </div>
                @endif

                <input type="file" name="logo"
                    class="block w-full text-sm">
            </div>
        </div>

        {{-- ================= SOSIAL MEDIA ================= --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border p-6 shadow-sm">
            <h2 class="text-xl font-black mb-6">🌐 Sosial Media</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <input type="text" name="instagram"
                    placeholder="Instagram"
                    value="{{ old('instagram', $profil->instagram) }}"
                    class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">

                <input type="text" name="facebook"
                    placeholder="Facebook"
                    value="{{ old('facebook', $profil->facebook) }}"
                    class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">

                <input type="text" name="tiktok"
                    placeholder="TikTok"
                    value="{{ old('tiktok', $profil->tiktok) }}"
                    class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">

                <input type="text" name="youtube"
                    placeholder="YouTube"
                    value="{{ old('youtube', $profil->youtube) }}"
                    class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">
            </div>
        </div>

        {{-- ================= TENTANG KAMI ================= --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border p-6 shadow-sm">
            <h2 class="text-xl font-black mb-6">📖 Tentang Kami</h2>

            <textarea name="tentang_kami" rows="5"
                class="w-full py-3 px-4 rounded-[1.5rem] border dark:bg-slate-900">{{ old('tentang_kami', $profil->tentang_kami) }}</textarea>
        </div>

        {{-- ================= ACTION ================= --}}
        <div class="text-right">
            <button
                class="px-8 py-4 rounded-[1.5rem] bg-emerald-500 text-white font-black shadow-lg shadow-emerald-500/30">
                💾 Simpan Pengaturan
            </button>
        </div>

    </form>

</div>
@endsection
