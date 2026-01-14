@extends('layouts.backend')

@section('title', 'Alamat Pengiriman')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-page">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <nav class="flex text-[10px] uppercase tracking-widest text-slate-400 mb-2 space-x-2 font-bold">
                <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-brand transition">Dashboard</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Tambah Alamat</span>
            </nav>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Alamat Penjemputan</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Tandai lokasi Anda agar tim kurir kami mudah menemukan lokasi Anda.</p>
        </div>
    </div>

    <form action="{{ route('pelanggan.alamat.update') }}" method="POST">
    @csrf
    @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            {{-- Input Hidden untuk Koordinat --}}
            <input type="hidden" name="latitude" value="{{ $pelanggan->latitude }}">
            <input type="hidden" name="longitude" value="{{ $pelanggan->longitude }}">
            
            <div class="lg:col-span-3 space-y-4">
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-4 shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden h-[400px] md:h-[550px] relative group">
                    
                    <div class="absolute top-8 left-8 right-8 z-[1000]">
                        <div class="relative group/search">
                            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400 group-focus-within/search:text-brand transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input id="pac-input" type="text" autocomplete="off" class="w-full pl-12 pr-5 py-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border-none rounded-2xl shadow-2xl focus:ring-2 focus:ring-brand outline-none text-sm font-bold text-slate-700 dark:text-white placeholder:text-slate-400 transition-all" placeholder="Cari nama jalan, apartemen, atau komplek...">
                            <div id="search-results" class="absolute w-full mt-2 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 hidden max-h-60 overflow-y-auto"></div>
                        </div>
                    </div>

                    <div id="map" class="w-full h-full rounded-[2rem] bg-slate-100 dark:bg-slate-800 relative z-0">
                        <div id="map-placeholder" class="absolute inset-0 flex items-center justify-center bg-slate-50 dark:bg-slate-800 z-[1]">
                             <div class="text-center space-y-3">
                                <div class="w-16 h-16 bg-brand/10 text-brand rounded-full flex items-center justify-center mx-auto animate-pulse">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                </div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Memuat Peta...</p>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btn-current-location" class="absolute bottom-24 right-6 z-[1000] w-12 h-12 bg-white dark:bg-slate-800 text-brand rounded-2xl shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all border border-slate-100 dark:border-slate-700 group/gps">
                        <svg class="w-6 h-6 group-hover/gps:animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><circle cx="12" cy="11" r="3" stroke-width="2"></circle></svg>
                        <span class="absolute right-14 bg-slate-800 text-white text-[10px] px-3 py-1.5 rounded-lg opacity-0 group-hover/gps:opacity-100 transition-opacity whitespace-nowrap pointer-events-none uppercase tracking-widest font-bold">Lokasi Saya</span>
                    </button>
                    
                    <div class="absolute bottom-6 left-6 right-6 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md p-4 rounded-2xl border border-white/20 shadow-xl flex items-center gap-4 z-[1000] pointer-events-none">
                        <div class="w-10 h-10 bg-brand text-white rounded-xl flex items-center justify-center shrink-0">📍</div>
                        <div class="text-left">
                            <p class="text-[10px] font-black text-brand uppercase tracking-widest">Pinpoint</p>
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-200 truncate">Klik peta untuk geser pin</p>
                        </div>
                    </div>
                </div>
                
                <div id="alert-manual" class="hidden bg-amber-50/50 dark:bg-amber-950/20 border border-amber-100 dark:border-amber-800/50 p-5 rounded-[2rem] flex items-start gap-4 backdrop-blur-sm animate-in fade-in slide-in-from-top-4 duration-500">
                    <div class="w-12 h-12 bg-white dark:bg-slate-800 text-amber-500 rounded-2xl flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="text-sm">
                        <p class="font-bold text-amber-900 dark:text-amber-200 uppercase tracking-widest text-[10px] mb-1">Data Belum Lengkap</p>
                        <p class="text-amber-700/80 dark:text-amber-400/80 leading-relaxed">Beberapa rincian wilayah tidak ditemukan otomatis. <span class="font-bold text-brand">Silahkan isi kolom yang kosong secara manual</span> agar pengiriman lebih akurat.</p>
                    </div>
                </div>

                <div class="bg-brand/5 dark:bg-brand/10 border border-brand/10 rounded-2xl p-4 flex items-center gap-3">
                    <span class="text-brand">💡</span>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium leading-relaxed">Gunakan fitur cari untuk menemukan lokasi lebih cepat, lalu klik pada peta untuk akurasi posisi kurir.</p>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-200 dark:border-slate-800">
                    <h4 class="font-black text-slate-800 dark:text-white text-lg mb-6 flex items-center gap-2">
                        <span class="text-brand">📝</span> Rincian Alamat
                    </h4>

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Provinsi</label>
                                <input type="text" name="provinsi" value="{{ $pelanggan->provinsi }}" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 focus:ring-2 focus:ring-brand outline-none transition text-sm font-bold text-slate-700 dark:text-white" placeholder="Pilih titik di peta" readonly>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kota / Kabupaten</label>
                                <input type="text" name="kota" value="{{ $pelanggan->kota }}" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 focus:ring-2 focus:ring-brand outline-none transition text-sm font-bold text-slate-700 dark:text-white" placeholder="Pilih titik di peta" readonly>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kecamatan</label>
                            <input type="text" name="kecamatan" value="{{ $pelanggan->kecamatan }}" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 focus:ring-2 focus:ring-brand outline-none transition text-sm font-bold text-slate-700 dark:text-white" placeholder="Pilih titik di peta" readonly>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Desa / Kelurahan</label>
                            <input type="text" name="desa" value="{{ $pelanggan->desa }}" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 focus:ring-2 focus:ring-brand outline-none transition text-sm font-bold text-slate-700 dark:text-white" placeholder="Pilih titik di peta" readonly>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Jalan / Komplek</label>
                            <textarea name="alamat_lengkap" rows="3" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 focus:ring-2 focus:ring-brand outline-none transition text-sm font-bold text-slate-700 dark:text-white" placeholder="Contoh: Jl. Dipati Ukur No. 123...">{{ $pelanggan->alamat_lengkap }}</textarea>
                        </div>

                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                            <label class="block text-[10px] font-black text-brand uppercase tracking-[0.2em] mb-4">Detail Tambahan (Opsional)</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">No. Rumah/Lantai</label>
                                    <input type="text" name="no_rumah" value="{{ $pelanggan->no_rumah }}" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-2 focus:ring-brand outline-none transition text-sm font-bold text-slate-700 dark:text-white" placeholder="Contoh: Blok B2 No. 5">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">Kode Pos</label>
                                    <input type="number" name="kode_pos" value="{{ $pelanggan->kode_pos }}" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-2 focus:ring-brand outline-none transition text-sm font-bold text-slate-700 dark:text-white" placeholder="40xxx">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">Patokan Lokasi</label>
                                <input type="text" name="patokan" value="{{ $pelanggan->patokan }}" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-2 focus:ring-brand outline-none transition text-sm font-bold text-slate-700 dark:text-white" placeholder="Contoh: Sebelah warung kelontong cat hijau">
                            </div>
                        </div>

                        <button disabled id="submitBtn" type="submit" class="w-full py-4 bg-brand hover:bg-brandDark text-white rounded-2xl font-black shadow-lg shadow-brand/20 transition-all hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-3 mt-4 text-xs uppercase tracking-widest disabled:opacity-50 disabled:cursor-not-allowed">
                            Simpan Lokasi Penjemputan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
    // AMBIL DATA LAMA DARI INPUT HIDDEN
    const oldLat = document.querySelector('[name="latitude"]').value;
    const oldLng = document.querySelector('[name="longitude"]').value;
    
    // TENTUKAN KOORDINAT AWAL (Default Jakarta jika data lama kosong)
    const initialLat = oldLat ? parseFloat(oldLat) : -6.200000;
    const initialLng = oldLng ? parseFloat(oldLng) : 106.816666;
    const initialZoom = oldLat ? 17 : 13;

    const map = L.map('map', { zoomControl: false }).setView([initialLat, initialLng], initialZoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OSM' }).addTo(map);
    document.getElementById('map-placeholder').style.display = 'none';

    let marker;
    const searchInput = document.getElementById('pac-input');
    const resultsContainer = document.getElementById('search-results');
    const alertBanner = document.getElementById('alert-manual');
    const btnGPS = document.getElementById('btn-current-location');
    let searchTimeout;

    // JIKA DATA LAMA ADA, PASANG MARKER DAN AKTIFKAN TOMBOL
    if (oldLat && oldLng) {
        marker = L.marker([initialLat, initialLng]).addTo(map);
        document.getElementById('submitBtn').disabled = false;
        
        // Cek styling untuk field yang sudah ada isinya
        ['provinsi', 'kota', 'kecamatan', 'desa'].forEach(f => {
            const el = document.querySelector(`[name="${f}"]`);
            if(el.value) {
                el.readOnly = true;
                el.classList.add('bg-slate-100', 'dark:bg-slate-800/50');
            }
        });
    }

    // FUNGSI GPS (LOKASI SAAT INI)
    btnGPS.addEventListener('click', () => {
        if (!navigator.geolocation) {
            alert("Geolocation tidak didukung oleh browser Anda");
            return;
        }

        btnGPS.classList.add('animate-pulse');
        
        navigator.geolocation.getCurrentPosition((position) => {
            const latlng = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            
            map.setView(latlng, 17);
            updateLocation(latlng);
            btnGPS.classList.remove('animate-pulse');
        }, (error) => {
            btnGPS.classList.remove('animate-pulse');
            alert("Gagal mengambil lokasi. Pastikan izin lokasi sudah diaktifkan.");
        }, {
            enableHighAccuracy: true
        });
    });

    // PENCARIAN INSTAN (200ms)
    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        const query = searchInput.value;
        if (query.length < 3) { resultsContainer.classList.add('hidden'); return; }
        
        resultsContainer.classList.remove('hidden');
        resultsContainer.innerHTML = '<div class="px-5 py-3 text-xs font-bold text-slate-400 animate-pulse">Mencari lokasi...</div>';

        searchTimeout = setTimeout(async () => {
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&countrycodes=id&limit=5&accept-language=id`);
                const data = await res.json();
                resultsContainer.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'px-5 py-3 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer text-xs font-bold text-slate-600 dark:text-slate-300 border-b border-slate-50 dark:border-slate-800 last:border-none';
                        div.innerText = item.display_name;
                        div.onclick = () => {
                            const latlng = { lat: parseFloat(item.lat), lng: parseFloat(item.lon) };
                            map.setView(latlng, 17);
                            updateLocation(latlng);
                            resultsContainer.classList.add('hidden');
                            searchInput.value = item.display_name;
                        };
                        resultsContainer.appendChild(div);
                    });
                } else {
                    resultsContainer.innerHTML = '<div class="px-5 py-3 text-xs font-bold text-rose-500">Lokasi tidak ditemukan</div>';
                }
            } catch (err) { resultsContainer.classList.add('hidden'); }
        }, 200); 
    });

    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.classList.add('hidden');
        }
    });

    map.on('click', (e) => { updateLocation(e.latlng); });

    async function updateLocation(latlng) {
        if (marker) { marker.setLatLng(latlng); } else { marker = L.marker(latlng).addTo(map); }
        document.querySelector('[name="latitude"]').value = latlng.lat;
        document.querySelector('[name="longitude"]').value = latlng.lng;

        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}&accept-language=id`);
            const data = await res.json();
            const a = data.address || {};

            fillAddressField('provinsi', a.state || a.region);
            fillAddressField('kota', a.city || a.county || a.city_district);
            fillAddressField('kecamatan', a.suburb || a.city_district || a.town || a.village);
            fillAddressField('desa', a.village || a.hamlet || a.neighbourhood || a.suburb);
            
            document.querySelector('[name="alamat_lengkap"]').value = data.display_name || '';
            document.querySelector('[name="kode_pos"]').value = a.postcode || '';
            document.getElementById('submitBtn').disabled = false;

            const fields = ['provinsi', 'kota', 'kecamatan', 'desa'];
            let isMissing = fields.some(f => !document.querySelector(`[name="${f}"]`).value);
            
            if (isMissing) { alertBanner.classList.remove('hidden'); } 
            else { alertBanner.classList.add('hidden'); }

        } catch (error) { console.error(error); }
    }

    function fillAddressField(name, value) {
        const input = document.querySelector(`[name="${name}"]`);
        if (!input) return;
        if (value) {
            input.value = value;
            input.readOnly = true;
            input.classList.add('bg-slate-100', 'dark:bg-slate-800/50');
        } else {
            input.value = '';
            input.readOnly = false;
            input.classList.remove('bg-slate-100', 'dark:bg-slate-800/50');
        }
    }
});
</script>
@endsection