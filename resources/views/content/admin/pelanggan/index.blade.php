@extends('layouts.home')

@section('title', 'Pelanggan')

@section('content')
<style>
  .alert-custom {
  background-color: #effafd;   /* warna custom */
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
            <h1 class="m-0">Pelanggan</h1>
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
            Untuk edit data pelanggan
          </p>
          <p>
            <i class="fas fa-trash"></i>
            untuk menghapus data pelanggan
          </p>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex align-items-center">
              <h3 class="card-title mb-0">Data Pelanggan</h3>
              {{-- <a href="{{ route('pelanggan.create') }}" class="btn btn-primary btn-sm ml-auto">Tambah</a> --}}
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>id</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($pelanggans as $pelanggan)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $pelanggan->user->name}}</td>
                      <td>{{ $pelanggan->no_hp}}</td>
                      <td>{{ $pelanggan->alamat}}</td>
                      <td>
                        <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}" method="POST" style="display:inline-block;">
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