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
                    <a href="{{ route('admin.layanan.index') }}" class="btn btn-primary btn-sm ml-auto">Kembali</a>
                    </div>
                
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ isset($layanan) ? route('admin.layanan.update', $layanan->id) : route('admin.layanan.store') }}" method="POST">
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
                                    <label for="deskripsi">Deskripsi</label>
                                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukkan Harga Perkilo" value="{{ $layanan->deskripsi ?? '' }}" required>
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