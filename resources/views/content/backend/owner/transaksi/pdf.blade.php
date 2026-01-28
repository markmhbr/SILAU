<h2>Data Transaksi</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $item)
            <tr>
                <td>{{ $item->tanggal_masuk?->format('d M Y') }}</td>
                <td>{{ $item->status }}</td>
                <td>Rp {{ number_format($item->harga_total,0,',','.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
