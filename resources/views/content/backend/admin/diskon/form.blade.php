@extends('layouts.home')

@section('title', isset($diskon) ? 'Edit Diskon' : 'Tambah Diskon')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">{{ isset($diskon) ? 'Edit Diskon' : 'Tambah Diskon' }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title mb-0">{{ isset($diskon) ? 'Edit Diskon' : 'Tambah Diskon' }}</h3>
            <a href="{{ route('admin.diskon.index') }}" class="btn btn-primary btn-sm ml-auto">Kembali</a>
          </div>
          <div class="card-body">
            <form action="{{ isset($diskon) ? route('admin.diskon.update', $diskon->id) : route('admin.diskon.store') }}" method="POST">
              @csrf
              @if(isset($diskon))
                  @method('PUT')
              @endif

              <div class="form row">
                <div class="form-group col-md-4">
                  <label for="nama_diskon">Nama Diskon</label>
                  <input type="text" class="form-control" id="nama_diskon" name="nama_diskon" placeholder="Masukkan Nama Diskon" value="{{ $diskon->nama_diskon ?? '' }}" required>
                </div>

                <div class="form-group col-md-4">
                  <label for="tipe">Tipe Diskon</label>
                  <select class="form-control" id="tipe" name="tipe" required>
                    <option value="">- Pilih Tipe Diskon -</option>
                    <option value="persentase" {{ (isset($diskon) && $diskon->tipe == 'persentase') ? 'selected' : '' }}>Persen (%)</option>
                    <option value="nominal" {{ (isset($diskon) && $diskon->tipe == 'nominal') ? 'selected' : '' }}>Nominal (Rp)</option>
                  </select>
                </div>

                <div class="form-group col-md-4">
                  <label for="nilai">Nilai Diskon</label>
                  <input type="number" class="form-control" id="nilai" name="nilai" placeholder="Masukkan Nilai Diskon" 
                         value="{{ isset($diskon) ? (float)$diskon->nilai : '' }}" required min="0">
                </div>

                <div class="form-group col-md-4">
                  <label for="minimal_transaksi">Minimal Transaksi (Rp)</label>
                  <input type="number" class="form-control" id="minimal_transaksi" name="minimal_transaksi" 
                         placeholder="Masukkan Minimal Transaksi" value="{{ isset($diskon) ? (float)$diskon->minimal_transaksi : 0 }}" min="0" required>
                </div>
              </div>

              <button type="submit" class="btn btn-primary">
                {{ isset($diskon) ? 'Update' : 'Simpan' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /.content -->

@endsection
