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
                    <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-primary btn-sm ml-auto">Kembali</a>
                    </div>
                
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ isset($pelanggan) ? route('admin.pelanggan.update', $pelanggan->id) : route('admin.pelanggan.store') }}" method="POST">
                            @csrf

                            @if(isset($pelanggan))
                                @method('PUT')
                            @endif

                            <div id="alertContainer">
                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="font-weight-bold">Nama Lengkap</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white"><i class="fas fa-user text-primary"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                placeholder="Masukkan Nama Lengkap" 
                                                value="{{ old('name', $pelanggan->user->name ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="email" class="font-weight-bold">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white"><i class="fas fa-envelope text-primary"></i></span>
                                            </div>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                placeholder="Masukkan Alamat Email" 
                                                value="{{ old('email', $pelanggan->user->email ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="password" class="font-weight-bold">
                                            Password 
                                            @if(isset($pelanggan))
                                                <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>
                                            @endif
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white"><i class="fas fa-lock text-primary"></i></span>
                                            </div>
                                            <input type="password" class="form-control" id="password" name="password" 
                                                placeholder="Masukkan Password" 
                                                {{ isset($pelanggan) ? '' : 'required' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                    <i class="fas fa-save mr-2"></i> {{ isset($pelanggan) ? 'Update Pelanggan' : 'Simpan Pelanggan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

@endsection