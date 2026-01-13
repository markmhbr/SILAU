@extends('layouts.home')

@section('title', 'Profil Usaha')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Profil Usaha</h2>
            <p class="text-sm text-slate-500">Kelola identitas dan informasi kontak bisnis Anda</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">Profil Usaha</span>
        </nav>
    </div>

    <form action="{{ route('admin.profil-perusahaan.update', $profil->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-primary-500"></i> Informasi Umum
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Nama Usaha</label>
                            <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $profil->nama_perusahaan) }}" 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="3" 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition">{{ old('deskripsi', $profil->deskripsi) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Tentang Kami</label>
                            <textarea name="tentang_kami" rows="4" 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition">{{ old('tentang_kami', $profil->tentang_kami) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-rose-500"></i> Lokasi & Operasional
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Alamat Lengkap</label>
                            <textarea id="alamat" name="alamat" rows="2" oninput="updateMapPreview()"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition">{{ old('alamat', $profil->alamat) }}</textarea>
                        </div>

                        <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-600 h-64 bg-slate-100 dark:bg-slate-900">
                            <iframe id="mapPreview" width="100%" height="100%" style="border:0;" loading="lazy"
                                src="https://maps.google.com/maps?q={{ urlencode($profil->alamat) }}&t=&z=15&ie=UTF8&iwloc=&output=embed">
                            </iframe>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Jam Layanan</label>
                                <input type="text" name="service_hours" value="{{ old('service_hours', $profil->service_hours) }}" 
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Fast Response</label>
                                <input type="text" name="fast_response" value="{{ old('fast_response', $profil->fast_response) }}" 
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold mb-4">Logo Usaha</h3>
                    <div class="group relative flex flex-col items-center justify-center border-2 border-dashed border-slate-200 dark:border-slate-600 rounded-2xl p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="w-full aspect-square flex items-center justify-center overflow-hidden mb-4 bg-slate-100 dark:bg-slate-900 rounded-xl">
                            <img id="logo-preview" 
                                 src="{{ $profil->logo ? asset('logo/' . $profil->logo) : 'https://via.placeholder.com/400x400.png?text=Logo' }}" 
                                 alt="Logo preview" class="max-h-full max-w-full object-contain">
                        </div>
                        <input type="file" name="logo" id="logo-input" class="hidden" onchange="previewLogo(event)">
                        <label for="logo-input" class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-center rounded-xl cursor-pointer font-medium transition shadow-sm">
                            <i class="fas fa-camera mr-2"></i> Ganti Logo
                        </label>
                        <p class="text-[10px] text-slate-500 mt-3">Gunakan rasio 1:1, Maks 2MB</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold mb-4">Kontak & Sosial</h3>
                    <div class="space-y-4">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </span>
                            <input type="text" name="no_wa" value="{{ old('no_wa', $profil->no_wa) }}" placeholder="WhatsApp"
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none text-sm transition">
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fas fa-envelope text-sm"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email', $profil->email) }}" placeholder="Email"
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none text-sm transition">
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fab fa-instagram text-lg"></i>
                            </span>
                            <input type="text" name="instagram" value="{{ old('instagram', $profil->instagram) }}" placeholder="Instagram"
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none text-sm transition">
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fab fa-tiktok text-sm"></i>
                            </span>
                            <input type="text" name="tiktok" value="{{ old('tiktok', $profil->tiktok) }}" placeholder="TikTok"
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none text-sm transition">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-2xl font-bold shadow-lg shadow-primary-500/30 transition-all hover:scale-[1.02] active:scale-95">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function updateMapPreview() {
        const addressInput = document.getElementById('alamat');
        const mapPreview = document.getElementById('mapPreview');
        const encodedAddress = encodeURIComponent(addressInput.value);
        mapPreview.src = `https://maps.google.com/maps?q=${encodedAddress}&t=&z=15&ie=UTF8&iwloc=&output=embed`;
    }

    function previewLogo(event) {
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('logo-preview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection