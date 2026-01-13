@extends('layouts.home')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Pengaturan Profil</h2>
            <p class="text-sm text-slate-500">Kelola informasi pribadi dan foto profil Anda</p>
        </div>
        <nav class="flex text-sm text-slate-500 space-x-2">
            <a href="#" class="hover:text-primary-600">Home</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-slate-200 font-medium">Profil</span>
        </nav>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="p-8">
            <form action="{{ route('pelanggan.profil.update', $pelanggan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="flex flex-col lg:flex-row gap-12">
                    <div class="w-full lg:w-1/3 flex flex-col items-center">
                        <div class="relative group">
                            <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-slate-50 dark:border-slate-700 shadow-xl ring-1 ring-slate-200 dark:ring-slate-600">
                                <img id="profile-photo" 
                                     src="{{ $pelanggan->foto ? asset('storage/'.$pelanggan->foto) : 'https://ui-avatars.com/api/?name='.urlencode($pelanggan->user->name).'&background=6366f1&color=fff&size=200' }}" 
                                     alt="Foto Profil" 
                                     class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-500">
                            </div>
                            <label for="foto-input" class="absolute bottom-2 right-2 w-10 h-10 bg-primary-600 hover:bg-primary-700 text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg transition-all hover:scale-110">
                                <i class="fas fa-camera text-sm"></i>
                            </label>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <h3 class="font-bold text-lg text-slate-800 dark:text-white">{{ $pelanggan->user->name }}</h3>
                            <p class="text-sm text-slate-500 italic">Member Pelanggan</p>
                        </div>

                        <input type="file" id="foto-input" name="foto" class="hidden" accept="image/*">
                        <p class="mt-4 text-[10px] text-slate-400 text-center uppercase tracking-widest">Klik ikon kamera untuk ganti foto</p>
                    </div>

                    <div class="w-full lg:w-2/3 space-y-5">
                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <label for="nama" class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                        <i class="fas fa-user text-xs"></i>
                                    </span>
                                    <input type="text" id="nama" name="nama" value="{{ old('nama', $pelanggan->user->name) }}" 
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition" placeholder="Nama Lengkap">
                                </div>
                            </div>

                            <div>
                                <label for="nomor_hp" class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Nomor WhatsApp</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                        <i class="fab fa-whatsapp text-sm font-bold"></i>
                                    </span>
                                    <input type="tel" id="nomor_hp" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}" 
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition" placeholder="08xxxxxx">
                                </div>
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Alamat Rumah</label>
                                <div class="relative">
                                    <span class="absolute top-3 left-3.5 text-slate-400">
                                        <i class="fas fa-map-marked-alt text-xs"></i>
                                    </span>
                                    <textarea id="alamat" name="alamat" rows="3" 
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-2 focus:ring-primary-500 outline-none transition" placeholder="Alamat lengkap...">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold shadow-lg shadow-primary-500/30 transition-all hover:scale-[1.01] active:scale-95 flex items-center justify-center gap-2">
                                <i class="fas fa-save text-sm"></i> Perbarui Profil
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
@endsection