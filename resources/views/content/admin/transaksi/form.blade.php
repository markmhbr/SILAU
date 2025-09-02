@extends('layouts.home')

@section('title', 'Tambah Transaksi')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Transaksi</h1>
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
                    <h3 class="card-title mb-0">Tambah Transaksi</h3>
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-primary btn-sm ml-auto">Kembali</a>
                    </div>
                
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ isset($transaksi) ? route('admin.transaksi.update', $transaksi->id) : route('admin.transaksi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if(isset($transaksi))
                                @method('PUT')
                            @endif
                            

                            <div class="form row">
                                {{-- Pilih Pelanggan --}}
                                {{-- Pilih Pelanggan --}}
                                <div class="form-group col-md-4">
                                    <label for="pelanggan_id">Pelanggan</label>
                                    <input type="text" class="form-control" value="{{ $transaksi->pelanggan->user->name ?? $pelanggan->user->name }}" readonly>
                                    <input type="hidden" name="pelanggan_id" value="{{ $pelanggan->id }}">
                                </div>  

                                {{-- Pilih Layanan --}}
                                <div class="form-group col-md-4">
                                    <label for="layanan_id">Layanan</label>
                                    <select name="layanan_id" id="layananSelect" class="select2bs4" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                      <option disabled selected>- Pilih Layanan -</option>
                                      @foreach($layanan as $l)
                                          <option value="{{ $l->id }}" data-harga="{{ $l->harga_perkilo }}"
                                            {{ isset($transaksi) && $transaksi->layanan_id == $l->id ? 'selected' : '' }}>
                                            {{ $l->nama_layanan }} - {{ $l->jenis_layanan}}
                                          </option>
                                      @endforeach
                                    </select>
                                </div>

                                {{-- Berat --}}
                                <div class="form-group col-md-4">
                                  <label>Berat (kg)</label>
                                  <input type="number" step="0.1" name="berat" class="form-control" value="{{ isset($transaksi) ? (intval($transaksi->berat) == $transaksi->berat ? intval($transaksi->berat) : $transaksi->berat) : '' }}" required>
                                </div>
                                
                                {{-- Metode Pembayaran --}}
                                <div class="form-group col-md-4">
                                    <label>Metode Pembayaran</label>
                                    <select name="metode_pembayaran" class="form-control" id="metodePembayaran">
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="tunai" {{ optional($transaksi)->metode_pembayaran == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                        <option value="transfer" {{ optional($transaksi)->metode_pembayaran == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="e-wallet" {{ optional($transaksi)->metode_pembayaran == 'e-wallet' ? 'selected' : '' }}>E-wallet</option>
                                    </select>
                                </div>

                                
                                {{-- Harga --}}
                                <div class="form-group col-md-4" id="hargaDiv">
                                  <label>Harga</label>
                                  <input type="number" name="harga_total" id="hargaInput" class="form-control" value="{{ isset($transaksi) ? (intval($transaksi->harga_total) == $transaksi->harga_total ? intval($transaksi->harga_total) : $transaksi->harga_total) : '' }}" readonly>
                                </div>

                                {{-- Upload Bukti Bayar --}}
                                <div class="form-group col-md-4" id="buktiBayarDiv"
                                    @if(isset($transaksi) && ($transaksi->metode_pembayaran == 'transfer' || $transaksi->metode_pembayaran == 'e-wallet'))
                                        style="display:block;"
                                    @else
                                        style="display:none;"
                                    @endif>
                                    >
                                    <label>Bukti Bayar</label>
                                    <input type="file" name="bukti_bayar" class="form-control" onchange="previewBukti(this)">
                                </div>

                                {{-- Catatan --}}
                                <div class="form-group col-md-4">
                                    <label>Catatan</label>
                                    <div class="d-flex">
                                        <textarea name="catatan" class="form-control">{{ optional($transaksi)->catatan }}</textarea>
                                        <button type="button" class="btn btn-info ml-3" id="previewButton" style="{{ isset($transaksi->bukti_bayar) ? 'display:inline-block;' : 'display:none;' }}" data-toggle="modal" data-target="#buktiModal">
                                            Preview Bukti
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($transaksi) ? 'Update' : 'Simpan' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal Preview Bukti -->
    <div class="modal fade" id="buktiModal" tabindex="-1" role="dialog" aria-labelledby="buktiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Preview Bukti Bayar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        @if(isset($transaksi->bukti_bayar))
            <img id="modalPreview" src="{{ asset('storage/' . $transaksi->bukti_bayar) }}" alt="Bukti Bayar" style="max-width:100%;">
        @else
            <img id="modalPreview" src="#" alt="Bukti Bayar" style="max-width:100%;">
        @endif
      </div>
    </div>
  </div>
</div>


<script>
const metode = document.getElementById('metodePembayaran');
const buktiDiv = document.getElementById('buktiBayarDiv');
const hargaDiv = document.getElementById('hargaDiv');
const hargaInput = document.getElementById('hargaInput');
const layananSelect = document.getElementById('layananSelect');
const beratInput = document.querySelector('input[name="berat"]');

function updateHarga() {
    const selectedOption = layananSelect.options[layananSelect.selectedIndex];
    const hargaPerKilo = parseFloat(selectedOption.dataset.harga || 0);
    const berat = parseFloat(beratInput.value || 0);
    const total = hargaPerKilo * berat;
    hargaInput.value = total ? total : '';
}

metode.addEventListener('change', function() {
    const previewBtn = document.getElementById('previewButton');
    const fileInput = document.querySelector('input[name="bukti_bayar"]');
    const modalImg = document.getElementById('modalPreview');

    if (this.value === 'tunai') {
        buktiDiv.style.display = 'none';
        previewBtn.style.display = 'none';
        fileInput.value = '';         // reset file input
        modalImg.src = '#';           // reset modal
    } else if (this.value === 'transfer' || this.value === 'e-wallet') {
        buktiDiv.style.display = 'block';
        // button preview akan muncul otomatis saat pilih file
    } else {
        buktiDiv.style.display = 'none';
        previewBtn.style.display = 'none';
        fileInput.value = '';         // reset file input
        modalImg.src = '#';
    }
});



// update harga saat layanan atau berat berubah
layananSelect.addEventListener('change', updateHarga);
beratInput.addEventListener('input', updateHarga);

// fungsi preview bukti tetap sama
function previewBukti(input){
    const modalImg = document.getElementById('modalPreview');
    const previewBtn = document.getElementById('previewButton');

    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = function(e){
            modalImg.src = e.target.result;   // set gambar di modal
            previewBtn.style.display = 'inline-block'; // tampilkan button
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        previewBtn.style.display = 'none'; // sembunyikan button kalau tidak ada file
    }
}

</script>

@endsection