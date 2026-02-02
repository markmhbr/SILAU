<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Laundry - {{ $transaksi->id }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: 58mm; /* Standar thermal printer */
            margin: 0;
            padding: 5mm;
            background-color: #fff;
        }
        .center { text-align: center; }
        .right { text-align: right; }
        .line { 
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        .bold { font-weight: bold; }
        .footer {
            margin-top: 10px;
            font-size: 10px;
        }
        
        /* Menyembunyikan elemen saat diprint jika ada tombol back/tutup */
        @media print {
            .no-print { display: none; }
            @page { margin: 0; }
            body { margin: 0.5cm; }
        }
    </style>
</head>
<body>
    <div class="center">
        {{-- Mengambil Nama Perusahaan dari Table Profil --}}
        <div class="bold">{{ strtoupper($profil->nama_perusahaan ?? 'LAUNDRYKU') }}</div>
        <div>{{ $profil->alamat ?? 'Jl. Contoh No. 123' }}</div>
        <div>Telp: {{ $profil->no_hp ?? $profil->telepon ?? '0812-3456-7890' }}</div>
        <div class="line"></div>
    </div>

    <div>
        <div>Tgl: {{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
        <div>No: #{{ $transaksi->order_id ?? 'TRX'.str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</div>
        <div>Kasir: {{ auth()->user()->name }}</div> 
    </div>
    
    <div class="line"></div>

    <div>
        <div class="bold">Pelanggan:</div>
        <div>{{ $transaksi->pelanggan->user->name }}</div>
        <div>{{ $transaksi->pelanggan->no_hp }}</div>
    </div>

    <div class="line"></div>

    <div>
        <div class="bold">Detail Layanan:</div>
        <div>{{ $transaksi->layanan->nama_layanan }}</div>
        <div class="right">
            {{ $transaksi->berat_aktual ?? $transaksi->estimasi_berat ?? $transaksi->berat }} kg x 
            Rp {{ number_format($transaksi->layanan->harga_perkilo ?? $transaksi->layanan->harga, 0, ',', '.') }}
        </div>
        <div class="right bold">Rp {{ number_format($transaksi->harga_estimasi ?? $transaksi->harga_total, 0, ',', '.') }}</div>
    </div>

    <div class="line"></div>

    <div>
        @if($transaksi->diskon)
        <div>Subtotal:</div>
        <div class="right">Rp {{ number_format($transaksi->harga_estimasi ?? $transaksi->harga_total, 0, ',', '.') }}</div>
        <div>Diskon ({{ $transaksi->diskon->nama_diskon }}):</div>
        <div class="right">-Rp {{ number_format(($transaksi->harga_estimasi ?? $transaksi->harga_total) - ($transaksi->harga_final ?? $transaksi->harga_setelah_diskon), 0, ',', '.') }}</div>
        <div class="line"></div>
        @endif
        
        <div class="bold">TOTAL BAYAR:</div>
        <div class="right bold" style="font-size: 14px;">Rp {{ number_format($transaksi->harga_final ?? $transaksi->harga_setelah_diskon ?? $transaksi->harga_total, 0, ',', '.') }}</div>
        
        <div style="margin-top: 5px">Metode: {{ strtoupper($transaksi->metode_pembayaran ?? 'Tunai') }}</div>
        <div>Status: {{ strtoupper($transaksi->status) }}</div>
    </div>

    <div class="line"></div>

    <div class="footer center">
        <div>Terima Kasih</div>
        @if($transaksi->tanggal_selesai)
        <div>Diambil Pada:</div>
        <div class="bold">{{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d/m/Y') }}</div>
        @else
        <div class="bold italic">Sedang Dalam Proses</div>
        @endif
        <div class="line"></div>
        <div>*Barang yang tidak diambil >30 hari diluar tanggung jawab kami</div>
    </div>

    <script>
        window.onload = function() {
            window.print();
            
            window.onafterprint = function() {
                window.location.href = "{{ route('admin.transaksi.index') }}";
            };
        }
    </script>
</body>
</html>