@extends('layouts.home')

@section('title', 'Tambah Pelanggan')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Pelanggan</h1>
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
                    <h3 class="card-title mb-0">Tambah Pelanggan</h3>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-primary btn-sm ml-auto">Kembali</a>
                    </div>
                
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ isset($pelanggan) ? route('pelanggan.update', $pelanggan->id) : route('pelanggan.store') }}" method="POST">
                            @csrf

                            @if(isset($pelanggan))
                                @method('PUT')
                            @endif

                            <div class="form row">
                                <div class="form-group col-md-4">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="{{ $pelanggan->nama ?? '' }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="no_hp">No HP</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan No HP" value="{{ $pelanggan->no_hp ?? '' }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" required>{{ $pelanggan->alamat ?? '' }}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($pelanggan) ? 'Update' : 'Simpan' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

@endsection