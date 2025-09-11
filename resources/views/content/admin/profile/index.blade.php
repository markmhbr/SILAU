@extends('layouts.home')
@section('title', 'Profil Usaha')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Profil Usaha</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Profil Usaha</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h3 class="card-title mb-0">Pengaturan Profil Usaha</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil-perusahaan.update', $profil->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form row">
                            <!-- Kiri: Nama, Deskripsi, Tentang Kami -->
                            <div class="form-group col-md-7">
                                <label for="nama_perusahaan">Nama Usaha</label>
                                <input type="text" class="form-control mb-3" id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan', $profil->nama_perusahaan) }}" required>
                            
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control mb-3" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $profil->deskripsi) }}</textarea>
                            
                                <label for="tentang_kami">Tentang Kami</label>
                                <textarea class="form-control" id="tentang_kami" name="tentang_kami" rows="4">{{ old('tentang_kami', $profil->tentang_kami) }}</textarea>
                            </div>
                        
                            <!-- Kanan: Logo -->
                            <div class="form-group col-md-5">
                                <label class="form-label fw-bold">Logo Usaha</label>
                                <div class="file-upload-wrapper text-center">
                                    <div class="logo-container mb-3" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <img id="logo-preview" 
                                             src="{{ $profil->logo ? asset('storage/' . $profil->logo) : 'https://via.placeholder.com/400x400.png?text=Pilih+Logo' }}" 
                                             alt="Logo preview" class="img-fluid rounded" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                    </div>
                                    <input type="file" name="logo" id="logo-input" class="d-none" onchange="previewLogo(event)">
                                    <label for="logo-input" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-upload me-2"></i>Pilih File Logo
                                    </label>
                                    <div class="form-text mt-2">Gunakan gambar rasio 1:1 (persegi).</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-3">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea id="alamat" name="alamat" class="form-control" rows="3" oninput="updateMapPreview()">{{ old('alamat', $profil->alamat) }}</textarea>
                        </div>
                        <div class="form-group mt-2">
                            <label>Preview Peta</label>
                            <div class="border rounded" style="height: 300px; background-color: #f8f9fa;">
                                <iframe id="mapPreview" width="100%" height="100%" style="border:0;" loading="lazy"
                                        src="https://maps.google.com/maps?q={{ urlencode($profil->alamat) }}&t=&z=15&ie=UTF8&iwloc=&output=embed">
                                </iframe>
                            </div>
                        </div>
                        <div class="form row mt-3">
                            <div class="form-group col-md-6">
                                <label for="service_hours">Jam Layanan</label>
                                <input type="text" name="service_hours" id="service_hours" class="form-control" value="{{ old('service_hours', $profil->service_hours) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fast_response">Fast Response</label>
                                <input type="text" name="fast_response" id="fast_response" class="form-control" value="{{ old('fast_response', $profil->fast_response) }}">
                            </div>
                        </div>
                        <h5 class="mt-4">Kontak & Sosial Media</h5>
                        <div class="form row mt-2">
                            <div class="form-group col-md-4">
                                <label for="no_wa">No. WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                    <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ old('no_wa', $profil->no_wa) }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $profil->email) }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="instagram">Instagram</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                    <input type="text" class="form-control" id="instagram" name="instagram" value="{{ old('instagram', $profil->instagram) }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4 mt-2">
                                <label for="facebook">Facebook</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                                    <input type="text" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', $profil->facebook) }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4 mt-2">
                                <label for="tiktok">TikTok</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                                    <input type="text" class="form-control" id="tiktok" name="tiktok" value="{{ old('tiktok', $profil->tiktok) }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4 mt-2">
                                <label for="youtube">YouTube</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                    <input type="url" class="form-control" id="youtube" name="youtube" value="{{ old('youtube', $profil->youtube) }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>
{{-- SCRIPT --}}
<script>
    function updateMapPreview() {
        const addressInput = document.getElementById('alamat');
        const mapPreview = document.getElementById('mapPreview');
        mapPreview.src = `https://maps.google.com/maps?q=${encodeURIComponent(addressInput.value)}&t=&z=15&ie=UTF8&iwloc=&output=embed`;
    }
    function previewLogo(event) {
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('logo-preview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
{{-- STYLE --}}
<style>
.file-upload-wrapper {
    border: 2px dashed #E5E7EB;
    padding: 1.5rem;
    border-radius: 0.5rem;
    background-color: #F9FAFB;
    display: flex;
    flex-direction: column;
    justify-content: center;
    transition: background-color 0.2s;
}
.file-upload-wrapper:hover { background-color: #F3F4F6; }
.logo-container {
    overflow: hidden;
}
</style>
@endsection