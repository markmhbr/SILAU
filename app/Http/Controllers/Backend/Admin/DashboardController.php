<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function dashboard() {
        $jumlahPelanggan = Pelanggan::count();
        $jumlahLayanan = Layanan::count();
        $jumlahTransaksi = Transaksi::count();

        // Mengambil 5 transaksi terbaru dengan relasi pelanggan
        $transaksiTerbaru = Transaksi::with(['pelanggan.user'])
                            ->latest()
                            ->limit(5)
                            ->get();

        // total omzet = jumlah semua harga_total
        $omzet = Transaksi::sum('harga_setelah_diskon');

        return view('content.backend.admin.dashboard', compact(
            'jumlahPelanggan',
            'jumlahLayanan',
            'jumlahTransaksi',
            'omzet',
            'transaksiTerbaru'
        ));
    }
}