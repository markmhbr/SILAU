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

    // Mengambil 5 transaksi terbaru dengan relasi pelanggan dan layanan
    $transaksiTerbaru = Transaksi::with(['pelanggan.user', 'layanan'])
                            ->latest()
                            ->limit(5)
                            ->get();

    // Total omzet menggunakan harga_final (jika null, gunakan harga_estimasi)
    // Coalesce memastikan transaksi yang baru masuk tetap terhitung omzetnya
    $omzet = Transaksi::sum(\DB::raw('COALESCE(harga_final, harga_estimasi)'));

    return view('content.backend.admin.dashboard', compact(
        'jumlahPelanggan',
        'jumlahLayanan',
        'jumlahTransaksi',
        'omzet',
        'transaksiTerbaru'
    ));
}
}