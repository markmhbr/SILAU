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

        return view('content.backend.owner.dashboard', compact(
            'omzetHariIni',
            'totalTransaksiHariIni',
            'totalTransaksiBulanIni',
            'omzetBulanIni',
            'orderBelumSelesai',
            'layananTerlaris',
            'transaksiTerbaru'
        ));
    }
}