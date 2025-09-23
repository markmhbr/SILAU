@extends('layouts.home')

@section('title', 'Tambah Transaksi')

@section('content')

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tambah Transaksi</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Tambah Layanan</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title mb-0">Tambah Transaksi</h3>
            <a href="{{ route('pelanggan.layanan.index') }}" class="btn btn-primary btn-sm ml-auto">Kembali</a>
          </div>

          <div class="card-body">
            <form action="{{ isset($transaksi) ? route('pelanggan.layanan.update', $transaksi->id) : route('pelanggan.layanan.store') }}" method="POST">
              @csrf
              @if(isset($transaksi))
                @method('PUT')
              @endif

              <div class="form row">
                {{-- Pelanggan --}}
                <div class="form-group col-md-4">
                  <label>Pelanggan</label>
                  <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                  <input type="hidden" name="pelanggan_id" value="{{ $pelanggan->id }}">
                </div>

                {{-- Layanan --}}
                <div class="form-group col-md-4">
                  <label>Layanan</label>
                  <select name="layanan_id" id="layananSelect" class="select2bs4" data-dropdown-css-class="select2-primary" style="width: 100%;">
                    <option disabled selected>- Pilih Layanan -</option>
                    @foreach($layanan as $l)
                      <option value="{{ $l->id }}" data-harga="{{ $l->harga_perkilo }}"
                        {{ isset($transaksi) && $transaksi->layanan_id == $l->id ? 'selected' : '' }}>
                        {{ $l->nama_layanan }} - {{ $l->jenis_layanan }}
                      </option>
                    @endforeach
                  </select>
                </div>

                {{-- Berat --}}
                <div class="form-group col-md-4">
                  <label>Berat (kg)</label>
                  <input type="number" step="0.1" name="berat" class="form-control" value="{{ isset($transaksi) ? $transaksi->berat : '' }}" required>
                </div>

                {{-- Diskon --}}
                <div class="form-group col-md-4">
                    <label>Diskon</label>
                    <select name="diskon_id" class="form-control">
                        <option value="">- Pilih Diskon -</option>
                        @foreach($diskon as $d)
                            @if((int)$d->aktif === 0) {{-- Hanya tampilkan yang aktif --}}
                                <option value="{{ $d->id }}">
                                    {{ $d->nama_diskon }} -  
                                    @if($d->tipe == 'persentase')
                                        {{ (float)$d->nilai }}%
                                    @else
                                        Rp {{ number_format($d->nilai, 0, ',', '.') }}
                                    @endif
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>


                {{-- Metode Pembayaran --}}
                <div class="form-group col-md-4">
                  <label>Metode Pembayaran</label>
                  <select name="metode_pembayaran" class="form-control">
                    <option value="">-- Pilih Metode --</option>
                    <option value="tunai" {{ optional($transaksi)->metode_pembayaran == 'tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="qris" {{ optional($transaksi)->metode_pembayaran == 'qris' ? 'selected' : '' }}>QRIS</option>
                  </select>
                </div>

                {{-- Catatan --}}
                <div class="form-group col-md-4">
                  <label>Catatan</label>
                  <textarea name="catatan" class="form-control">{{ optional($transaksi)->catatan }}</textarea>
                </div>
              </div>

              <button type="submit" class="btn btn-primary">{{ isset($transaksi) ? 'Update' : 'Lanjut ke Detail' }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
const layananSelect = document.getElementById('layananSelect');
const beratInput = document.querySelector('input[name="berat"]');

// Harga total dihitung di halaman detail, form hanya input
function updateHarga() {
  const selectedOption = layananSelect.options[layananSelect.selectedIndex];
  const hargaPerKilo = parseFloat(selectedOption.dataset.harga || 0);
  const berat = parseFloat(beratInput.value || 0);
  // bisa simpan sementara di JS jika mau tampil di preview detail
}

layananSelect.addEventListener('change', updateHarga);
beratInput.addEventListener('input', updateHarga);
</script>

@endsection
