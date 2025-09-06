@extends('layouts.home')

@section('title', 'Detail Transaksi')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail Layanan</h1>
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
        
            <div class="card mb-3">
                <div class="card-body">
                    <p><strong>Pelanggan:</strong> {{ $transaksi->pelanggan->user->name }}</p>
                    <p><strong>Layanan:</strong> {{ $transaksi->layanan->nama_layanan }} ({{ $transaksi->layanan->jenis_layanan }})</p>
                    <p><strong>Berat:</strong> {{ (float)$transaksi->berat }} kg</p>
                    <p><strong>Harga Layanan:</strong> Rp {{ number_format($hargaLayanan,0,',','.') }}</p>
                    <p><strong>Diskon:</strong> Rp {{ number_format($diskon,0,',','.') }}</p>
                    <p><strong>Total Bayar:</strong> Rp {{ number_format($hargaFinal,0,',','.') }}</p>
                    <p><strong>Metode Pembayaran:</strong> {{ ucfirst($transaksi->metode_pembayaran) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($transaksi->status) }}</p>
                </div>
            </div>
        
            @if($transaksi->metode_pembayaran == 'qris' && $transaksi->status == 'proses bayar')
            <div class="card">
                <div class="card-body text-center">
                    <h5>Scan QRIS untuk bayar</h5>
                    <img src="{{ asset('img/QR.svg') }}" alt="QRIS" style="max-width:200px;">
                    <form action="{{ route('pelanggan.layanan.bayar', $transaksi->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <div class="d-flex justify-content-center">
                            <div class="form-group text-center">
                                <label class="d-block">Upload Bukti Bayar</label>
                                <input type="file" name="bukti_bayar" class="form-control mx-auto" style="max-width:300px;" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Bayar & Upload Bukti</button>
                    </form>
                </div>
            </div>
            @elseif($transaksi->status == 'selesai')
            <div class="alert alert-success">Pembayaran sudah selesai ✅</div>
            @endif
        </div>
    </section>
    <!-- /.content -->
@endsection
