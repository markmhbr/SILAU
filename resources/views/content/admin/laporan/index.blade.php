@extends('layouts.home')

@section('title', 'Laporan Transaksi')

@section('content')
<style>
  .alert-custom {
    background-color: #effafd;
    color: #000;
    border-radius: 8px;
    border: 1px solid #000;
  }
  .alert-custom p {
    margin: 5px 0;
    font-weight: 500;
  }
  .alert-custom i {
    margin-right: 8px;
    font-size: 20px;
  }
</style>

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Laporan Transaksi</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Laporan Transaksi</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <div class="alert alert-custom" role="alert">
      <p><i class="fas fa-info-circle"></i>Pilih tanggal dari dan sampai untuk menampilkan laporan transaksi</p>
    </div>

    <!-- Card 1: Input Tanggal -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title mb-0">Laporan Transaksi</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.laporan.index') }}" method="GET">
              <div class="form row">
                <div class="form-group col-md-6">
                  <label for="dari_tanggal">Dari Tanggal</label>
                  <input type="date" class="form-control" id="dari_tanggal" 
                         name="dari_tanggal" value="{{ request('dari_tanggal') }}" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="sampai_tanggal">Sampai Tanggal</label>
                  <input type="date" class="form-control" id="sampai_tanggal" 
                         name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Tampilkan</button>
            </form>

          </div>
        </div>
      </div>
    </div>

    <!-- Card 2: Tabel Transaksi -->
    @if($dari && $sampai)
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title mb-0">Transaksi dari {{ $dari }} sampai {{ $sampai }}</h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>ID Transaksi</th>
                  <th>Nama Pelanggan</th>
                  <th>Jumlah Item</th>
                  <th>Total Bayar</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                @forelse($transaksi as $key => $t)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $t->id }}</td>
                  <td>{{ $t->pelanggan->user->name }}</td>
                  <td>{{ $t->layanan->nama_layanan}} - {{ $t->layanan->jenis_layanan}}</td>
                  <td>{{ number_format($t->harga_setelah_diskon, 0, ',', '.') }} Rp</td>
                  <td>{{ $t->tanggal_masuk }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center">Tidak ada transaksi pada rentang tanggal ini</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @endif


  </div>
</section>
@endsection
