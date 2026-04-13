<?php

namespace App\Http\Controllers\Backend\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Layanan;

class DashboardController extends Controller
{
    public function index()
    {
        // ================= HARI INI =================
        // Menggunakan created_at dan harga_final sesuai migrasi
        $omzetHariIni = Transaksi::whereDate('created_at', today())
            ->where('status', 'selesai')
            ->sum('harga_final');

        $totalTransaksiHariIni = Transaksi::whereDate('created_at', today())
            ->count();

        // ================= BULAN INI =================
        $totalTransaksiBulanIni = Transaksi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $omzetBulanIni = Transaksi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'selesai')
            ->sum('harga_final');

        // ================= ORDER BELUM SELESAI =================
        // Mengambil semua status kecuali 'selesai' dan 'dibatalkan'
        $orderBelumSelesai = Transaksi::whereNotIn('status', ['selesai', 'dibatalkan'])->count();

        // ================= LAYANAN TERLARIS =================
        // Pastikan di model Layanan sudah ada relasi: public function transaksi()
        $layananTerlaris = Layanan::withCount('transaksi')
            ->orderByDesc('transaksi_count')
            ->first();

        // ================= TRANSAKSI TERBARU =================
        $transaksiTerbaru = Transaksi::with(['pelanggan', 'layanan'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // ================= DATA GRAFIK PENJUALAN (30 HARI TERAKHIR) =================
        $salesData = Transaksi::where('status', 'selesai')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(harga_final) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data untuk ApexCharts
        $chartLabels = [];
        $chartTotals = [];

        // Inisialisasi 30 hari terakhir dengan 0 jika tidak ada transaksi
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d M');
            
            $found = $salesData->firstWhere('date', $date);
            $chartTotals[] = $found ? (int)$found->total : 0;
        }

        return view('content.backend.owner.dashboard', compact(
            'omzetHariIni',
            'totalTransaksiHariIni',
            'totalTransaksiBulanIni',
            'omzetBulanIni',
            'orderBelumSelesai',
            'layananTerlaris',
            'transaksiTerbaru',
            'chartLabels',
            'chartTotals'
        ));
    }
}