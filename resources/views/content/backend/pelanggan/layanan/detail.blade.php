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
              <li class="breadcrumb-item active">Detail layanan</li>
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
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Detail Transaksi</h5>
                        <a href="{{ route('pelanggan.layanan.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>Pelanggan</th>
                                <td>{{ $transaksi->pelanggan->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Layanan</th>
                                <td>{{ $transaksi->layanan->nama_layanan }} ({{ $transaksi->layanan->jenis_layanan }})</td>
                            </tr>
                            <tr>
                                <th>Berat</th>
                                <td>{{ (float)$transaksi->berat }} kg</td>
                            </tr>
                            <tr>
                                <th>Harga Layanan</th>
                                <td>Rp {{ number_format($hargaLayanan,0,',','.') }}</td>
                            </tr>
                            <tr>
                                <th>Diskon</th>
                                <td>Rp {{ number_format($diskon,0,',','.') }}</td>
                            </tr>
                            <tr>
                                <th>Total Bayar</th>
                                <td>Rp {{ number_format($hargaFinal,0,',','.') }}</td>
                            </tr>
                            <tr>
                                <th>Metode Pembayaran</th>
                                <td>{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst($transaksi->status) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        
            @if($transaksi->metode_pembayaran == 'qris' && $transaksi->status == 'pending')
            <div class="card">
                <div class="card-body text-center">
                    <h5>Scan QRIS untuk bayar</h5>
                    <img src="{{ asset('assets/img/Capture.PNG') }}" alt="QRIS" style="max-width:200px;">
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
