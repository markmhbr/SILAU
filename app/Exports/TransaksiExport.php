<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $from;
    protected $to;
    protected $status;

    public function __construct($from = null, $to = null, $status = null)
    {
        $this->from   = $from;
        $this->to     = $to;
        $this->status = $status;
    }

    /**
     * DATA YANG DIEKSPORT
     */
    public function collection()
    {
        $query = Transaksi::with([
            'pelanggan.user',
            'karyawan.user',
            'layanan',
            'diskon'
        ]);

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->from) {
            $query->whereDate('tanggal_masuk', '>=', $this->from);
        }

        if ($this->to) {
            $query->whereDate('tanggal_masuk', '<=', $this->to);
        }

        return $query->latest()->get();
    }

    /**
     * HEADER EXCEL
     */
    public function headings(): array
    {
        return [
            'Tanggal Masuk',
            'Pelanggan',
            'Karyawan',
            'Layanan',
            'Berat (Kg)',
            'Status',
            'Total Awal',
            'Setelah Diskon',
            'Catatan'
        ];
    }

    /**
     * FORMAT SETIAP ROW
     */
    public function map($item): array
    {
        return [
            $item->tanggal_masuk?->format('d-m-Y'),
            $item->pelanggan->user->name ?? 'Guest',
            $item->karyawan->user->name ?? '-',
            $item->layanan->nama_layanan ?? '-',
            $item->berat,
            strtoupper($item->status),
            $item->harga_total,
            $item->hargaSetelahDiskon(),
            $item->catatan ?? '-',
        ];
    }
}
