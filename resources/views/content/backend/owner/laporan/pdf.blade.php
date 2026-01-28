<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:6px; }
        th { background:#f3f4f6; }
    </style>
</head>
<body>

<h3>Laporan Transaksi</h3>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Layanan</th>
            <th>Status</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan as $item)
        <tr>
            <td>{{ $item->tanggal_masuk?->format('d-m-Y') }}</td>
            <td>{{ $item->pelanggan?->user?->name ?? 'Guest' }}</td>
            <td>{{ $item->layanan->nama_layanan ?? '-' }}</td>
            <td>{{ strtoupper($item->status) }}</td>
            <td>Rp {{ number_format($item->hargaSetelahDiskon(),0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
