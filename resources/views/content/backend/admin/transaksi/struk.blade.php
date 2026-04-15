<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Laundry - {{ $transaksi->order_id }}</title>
    <style>
        /* Reset & Base Styling */
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        body {
            font-family: 'Courier New', Courier, monospace; /* Font monospace paling aman untuk thermal */
            font-size: 11px; /* Sedikit lebih kecil agar muat banyak info */
            line-height: 1.2;
            width: 58mm;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .container {
            width: 100%;
            padding: 2mm; /* Padding minimal agar tidak mepet ke tepi fisik kertas */
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .upper { text-transform: uppercase; }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
            width: 100%;
        }

        /* Table untuk struk yang rapi */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td { vertical-align: top; }

        .footer {
            margin-top: 10px;
            font-size: 9px;
            line-height: 1.1;
        }

        /* Print Settings */
        @media print {
            @page {
                size: 58mm auto; /* Biarkan tinggi otomatis mengikuti konten */
                margin: 0;
            }
            body {
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="center">
            <div class="bold upper" style="font-size: 14px;">{{ $profil->nama_perusahaan ?? 'LAUNDRYKU' }}</div>
            <div>{{ $profil->alamat ?? 'Jl. Contoh No. 123' }}</div>
            <div>Telp: {{ $profil->no_hp ?? ($profil->telepon ?? '0812-3456-7890') }}</div>
        </div>

        <div class="line"></div>

        <table>
            <tr>
                <td>Tgl: {{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>No: #{{ $transaksi->order_id }}</td>
            </tr>
            <tr>
                <td>Kasir: {{ auth()->user()->name }}</td>
            </tr>
        </table>

        <div class="line"></div>

        <div>
            <span class="bold">Pelanggan:</span><br>
            @if ($transaksi->pelanggan)
                {{ $transaksi->pelanggan->user->name }} ({{ $transaksi->pelanggan->no_hp ?? '-' }})
            @elseif($transaksi->nama_guest)
                {{ $transaksi->nama_guest }} ({{ $transaksi->no_hp_guest ?? '-' }})
            @else
                Guest
            @endif
        </div>

        <div class="line"></div>

        <table style="margin-bottom: 5px;">
            <tr>
                <td colspan="2" class="bold">{{ $transaksi->layanan->nama_layanan }}</td>
            </tr>
            <tr>
                <td>
                    {{ $transaksi->berat_aktual ?? ($transaksi->estimasi_berat ?? $transaksi->berat) }}kg x 
                    {{ number_format($transaksi->layanan->harga_perkilo ?? $transaksi->layanan->harga, 0, ',', '.') }}
                </td>
                <td class="right">
                    {{ number_format($transaksi->harga_estimasi ?? $transaksi->harga_total, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        @if ($transaksi->diskon)
        <div class="line"></div>
        <table>
            <tr>
                <td>Subtotal</td>
                <td class="right">{{ number_format($transaksi->harga_estimasi ?? $transaksi->harga_total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Disc ({{ $transaksi->diskon->nama_diskon }})</td>
                <td class="right">-{{ number_format(($transaksi->harga_estimasi ?? $transaksi->harga_total) - ($transaksi->harga_final ?? $transaksi->harga_setelah_diskon), 0, ',', '.') }}</td>
            </tr>
        </table>
        @endif

        <div class="line"></div>
        <table>
            <tr>
                <td class="bold" style="font-size: 13px;">TOTAL</td>
                <td class="right bold" style="font-size: 13px;">
                    Rp {{ number_format($transaksi->harga_final ?? ($transaksi->harga_setelah_diskon ?? $transaksi->harga_total), 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <div style="margin-top: 5px">
            Metode: <span class="upper">{{ $transaksi->metode_pembayaran ?? 'Tunai' }}</span><br>
            Status: <span class="upper">{{ $transaksi->status }}</span>
        </div>

        <div class="line"></div>

        <div class="footer center">
            <div class="bold upper">Terima Kasih</div>
            @if ($transaksi->tanggal_selesai)
                <div>Estimasi Selesai:</div>
                <div class="bold">{{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d/m/Y') }}</div>
            @else
                <div class="bold" style="font-style: italic;">Sedang Dalam Proses</div>
            @endif
            <div style="margin-top: 8px;">
                * Barang yang tidak diambil >30 hari<br>di luar tanggung jawab kami.
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        }
    </script>
</body>
</html>