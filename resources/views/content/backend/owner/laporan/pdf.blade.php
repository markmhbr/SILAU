<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .text-right { text-align: right; }
        .status-badge { font-weight: bold; font-size: 9px; }
        .label-estimasi { font-style: italic; color: #d97706; font-size: 9px; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
    </style>
</head>
<body>

<div class="header">
    <h2>Laporan Transaksi Laundry</h2>
    <p>Periode: {{ request('from') ?? 'Semua' }} s/d {{ request('to') ?? 'Sekarang' }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Order ID</th>
            <th>Pelanggan</th>
            <th>Layanan</th>
            <th>Status</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        @php $totalOmzet = 0; @endphp
        @foreach($laporan as $index => $item)
        @php 
            // Ambil harga final jika ada, jika tidak pakai estimasi
            $nominal = $item->harga_final ?? $item->harga_estimasi;
            $totalOmzet += $nominal;
        @endphp
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td>{{ $item->created_at->format('d/m/Y') }}</td>
            <td><strong>{{ $item->order_id }}</strong></td>
            <td>{{ $item->pelanggan->nama ?? 'Guest' }}</td>
            <td>{{ $item->layanan->nama_layanan ?? '-' }}</td>
            <td class="status-badge">{{ strtoupper($item->status) }}</td>
            <td class="text-right">
                Rp {{ number_format($nominal, 0, ',', '.') }}
                @if(!$item->harga_final)
                    <br><span class="label-estimasi">(Estimasi)</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background: #f9f9f9; font-weight: bold;">
            <td colspan="6" class="text-right">TOTAL KESELURUHAN</td>
            <td class="text-right">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>

<div class="footer">
    <p>Dicetak pada: {{ date('d M Y H:i') }}</p>
</div>

</body>
</html>