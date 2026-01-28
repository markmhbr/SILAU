<?php
namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\{
    FromCollection, WithHeadings, WithMapping
};

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Transaksi::with(['pelanggan.user', 'layanan']);

        if ($this->request->from && $this->request->to) {
            $query->whereBetween('tanggal_masuk', [
                $this->request->from,
                $this->request->to
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
            'Tanggal',
            'Pelanggan',
            'Layanan',
            'Status',
            'Total (Rp)',
            'Catatan'
        ];
    }

    public function map($item): array
    {
        return [
            $item->tanggal_masuk?->format('d-m-Y'),
            $item->pelanggan?->user?->name ?? 'Guest',
            $item->layanan?->nama_layanan ?? '-',
            strtoupper($item->status),
            $item->hargaSetelahDiskon(),
            $item->catatan ?? '-',
        ];
    }
}
