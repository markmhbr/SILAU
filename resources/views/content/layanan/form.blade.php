@extends('layouts.home')

@section('title', 'Tambah layanan')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Layanan</h1>
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                    <h3 class="card-title mb-0">Tambah Layanan</h3>
                    <a href="{{ route('layanan.index') }}" class="btn btn-primary btn-sm ml-auto">Kembali</a>
                    </div>
                
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ isset($layanan) ? route('layanan.update', $layanan->id) : route('layanan.store') }}" method="POST">
                            @csrf

                            @if(isset($layanan))
                                @method('PUT')
                            @endif

                            <div class="form row">
                                <div class="form-group col-md-4">
                                    <label for="nama_layanan">Nama Layanan</label>
                                    <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" placeholder="Masukkan Nama Layanan" value="{{ $layanan->nama_layanan ?? '' }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="jenis_layanan">Jenis Layanan</label>
                                    <select class="form-control" id="jenis_layanan" name="jenis_layanan" required>
                                      <option value="">- Pilih Jenis Layanan -</option>
                                      <option value="reguler" {{ (isset($layanan) && $layanan->jenis_layanan == 'reguler') ? 'selected' : '' }}>Reguler</option>
                                      <option value="express" {{ (isset($layanan) && $layanan->jenis_layanan == 'express') ? 'selected' : '' }}>Express / Kilat</option>
                                      <option value="khusus" {{ (isset($layanan) && $layanan->jenis_layanan == 'khusus') ? 'selected' : '' }}>Khusus</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="harga_perkilo">Harga Perkilo</label>
                                    <input type="number" class="form-control" id="harga_perkilo" name="harga_perkilo" placeholder="Masukkan Harga Perkilo" value="{{ $layanan->harga_perkilo ?? '' }}" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($layanan) ? 'Update' : 'Simpan' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

@endsection