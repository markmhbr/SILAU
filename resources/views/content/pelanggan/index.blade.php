@extends('layouts.home')

@section('title', 'Pelanggan')

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
              <a href="/pelanggan/tambah" class="btn btn-primary btn-sm ml-auto">Tambah</a>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>id</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Miftah</td>
                      <td>Tanjung Sari</td>
                      <td>0897655777</td>
                      <td>
                        <button type="button" class="btn btn-primary">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Miftah</td>
                      <td>Tanjung Sari</td>
                      <td>0897655777</td>
                      <td>
                        <button type="button" class="btn btn-primary">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
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