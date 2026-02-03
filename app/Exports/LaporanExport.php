<?php
namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\{
    FromCollection, WithHeadings, WithMapping, ShouldAutoSize
};

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        // Menggunakan relasi sesuai migration (pelanggan & layanan)
        $query = Transaksi::with(['pelanggan', 'layanan']);

        // Filter menggunakan created_at
        if ($this->request->from && $this->request->to) {
            $query->whereBetween('created_at', [
                $this->request->from . ' 00:00:00',
                $this->request->to . ' 23:59:59'
            ]);
        }

        if ($this->request->status) {
            $query->where('status', $this->request->status);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID Order',
            'Tanggal Masuk',
            'Nama Pelanggan',
            'Layanan',
            'Status',
            'Cara Serah',
            'Berat (kg)',
            'Total (Rp)',
            'Keterangan Harga',
            'Catatan'
        ];
    }

    public function map($item): array
    {
        // Logika penentuan harga dan label
        $isFinal = !is_null($item->harga_final);
        $harga = $isFinal ? $item->harga_final : $item->harga_estimasi;
        $berat = $item->berat_aktual ?? $item->estimasi_berat;

        return [
            $item->order_id,
            $item->created_at->format('d-m-Y H:i'),
            $item->pelanggan->nama ?? 'Guest',
            $item->layanan?->nama_layanan ?? '-',
            strtoupper($item->status),
            ucfirst($item->cara_serah),
            $berat,
            $harga,
            $isFinal ? 'FINAL' : 'ESTIMASI',
            $item->catatan ?? '-',
        ];
    }
}