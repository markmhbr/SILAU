@extends('layouts.home')

@section('title', 'Diskon')

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
            <h1 class="m-0">Diskon</h1>
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
            Untuk edit data diskon
          </p>
          <p>
            <i class="fas fa-trash"></i>
            untuk menghapus data diskon
          </p>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex align-items-center">
              <h3 class="card-title mb-0">Daftar Diskon</h3>
              <a href="{{ route('admin.diskon.create') }}" class="btn btn-primary btn-sm ml-auto">Tambah</a>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Diskon</th>
                            <th>Tipe</th>
                            <th>Nilai</th>
                            <th>Minimal Transaksi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diskon as $key => $d)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $d->nama_diskon }}</td>
                            <td>{{ ucfirst($d->tipe) }}</td>
                            <td>{{ (float)$d->nilai }}{{ $d->tipe === 'persentase' ? '%' : ' Rp' }}</td>
                            <td>{{ (float)$d->minimal_transaksi }} Rp</td>
                            <td>
                                @if((int)$d->status === 0)
                                  <p style="color: green">Aktif</p>
                                @else
                                  <p>Nonaktif</p>
                                @endif
                            </td>

                            <td>
                                @if((int)$d->status === 0)
                                    <ion-icon name="checkmark-circle-outline" style="color: green; font-size: 20px;" title="Aktif"></ion-icon>
                                @else
                                    <ion-icon name="close-circle-outline" style="color: gray; font-size: 20px;" title="Nonaktif"></ion-icon>
                                @endif
                                <a href="{{ route('admin.diskon.edit', $d->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.diskon.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus diskon ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
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