@extends('layouts.home')

@section('title', 'Layanan')

@section('content')
<style>
  .alert-custom {
  background-color: #8BBAC4;   /* warna custom */
  color: #000;                 /* teks hitam */
  border-radius: 8px;          /* rounded */
  border: 1px solid #000;      /* biar mirip contoh */
}
.alert-custom p {
  margin: 5px 0;
  font-weight: 500;
}
.alert-custom i {
  margin-right: 8px;
  font-size: 20px;             /* biar icon lebih jelas */
}
</style>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Layanan</h1>
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

        <div class="alert alert-custom" role="alert">
          <p>
            <i class="fas fa-edit"></i>
            Untuk edit data Layanan
          </p>
          <p>
            <i class="fas fa-trash"></i>
            untuk menghapus data Layanan
          </p>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex align-items-center">
              <h3 class="card-title mb-0">Data Layanan</h3>
              <a href="{{ route('layanan.create') }}" class="btn btn-primary btn-sm ml-auto">Tambah</a>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Berat (kg)</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($transaksis as $transaksi)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $transaksi->pelanggan->nama}}</td>
                      <td>{{ $transaksi->layanan->nama_layanan}} - {{ $transaksi->layanan->jenis_layanan}}</td>
                      <td>{{ intval($transaksi->berat) == $transaksi->berat ? intval($transaksi->berat) : $transaksi->berat }} kg</td>
                      <td>Rp {{ number_format($transaksi->harga_total, 0, ',', '.') }}</td>
                      <td>
                          <button type="button" class="btn btn-info btn-status">
                              {{ $transaksi->status}}
                          </button>
                      <td>
                        <a href="{{ route('layanan.edit', $transaksi->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <form action="{{ route('layanan.destroy', $transaksi->id) }}" method="POST" style="display:inline-block;">
                          @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-delete">
                                <i class="fas fa-trash"></i>
                              </button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection