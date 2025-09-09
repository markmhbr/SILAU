<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Laundry</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: 48mm; /* Lebar thermal printer */
            margin: 0;
            padding: 5mm;
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="center">
        <div class="bold">LAUNDRYKU</div>
        <div>Jl. Contoh No. 123</div>
        <div>Telp: 0812-3456-7890</div>
        <div class="line"></div>
    </div>

    <!-- Transaksi Info -->
    <div>
        <div>Tgl: {{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
        <div>No: {{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</div>
        <div>Kasir: {{ $transaksi->kasir }}</div>
    </div>
    
    <div class="line"></div>

    <!-- Pelanggan Info -->
    <div>
        <div class="bold">Pelanggan:</div>
        <div>{{ $transaksi->nama_pelanggan }}</div>
        <div>{{ $transaksi->telepon }}</div>
    </div>

    <div class="line"></div>

    <!-- Detail Layanan -->
    <div>
        <div class="bold">Detail Layanan:</div>
        @foreach($transaksi->detailTransaksi as $detail)
        <div>{{ $detail->layanan }} ({{ $detail->jumlah }}x)</div>
        <div class="right">Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</div>
        @endforeach
    </div>

    <div class="line"></div>

    <!-- Total Pembayaran -->
    <div>
        <div>Total:</div>
        <div class="right bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
        
        @if($transaksi->diskon > 0)
        <div>Diskon:</div>
        <div class="right">-Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</div>
        @endif
        
        <div class="line"></div>
        
        <div class="bold">Total Bayar:</div>
        <div class="right bold">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</div>
        
        <div>Bayar:</div>
        <div class="right">Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</div>
        
        <div>Kembali:</div>
        <div class="right">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</div>
    </div>

    <div class="line"></div>

    <!-- Footer -->
    <div class="footer center">
        <div>Terima Kasih</div>
        <div>Barang Siap Diambil:</div>
        <div class="bold">{{ $transaksi->tanggal_selesai->format('d/m/Y') }}</div>
        <div class="line"></div>
        <div>*Simpan struk untuk klaim garansi</div>
    </div>
</body>
</html>