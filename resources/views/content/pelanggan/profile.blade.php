@extends('layouts.home')

@section('title', 'Profile')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Profil</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content p-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h3 class="card-title mb-0">Data Profile</h3>
                            </div>

                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-5 d-flex flex-column align-items-center justify-content-center p-3 border rounded mx-5">
                                        <h4 class="h5 font-weight-semibold mb-4">Foto</h4>
                                        <div class="profile-photo-container rounded-circle bg-light d-flex align-items-center justify-content-center overflow-hidden mb-4 border">
                                            <img id="profile-photo" src="https://placehold.co/160x160/cccccc/ffffff?text=Foto" alt="Foto Profil" class="img-fluid w-100 h-100">
                                        </div>
                                        <input type="file" id="foto-input" class="form-control" accept="image/*">
                                    </div>

                                    <div class="col-md-5 p-3">
                                        <form>
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Lengkap">
                                            </div>
                                            <div class="mb-3">
                                                <label for="nomor_hp" class="form-label">Nomor HP</label>
                                                <input type="tel" class="form-control" id="nomor_hp" placeholder="Masukkan Nomor HP">
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat" rows="3" placeholder="Masukkan Alamat Lengkap"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
            </div></section>
    <!-- /.content -->
@endsection