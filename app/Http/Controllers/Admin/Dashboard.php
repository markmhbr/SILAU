<?php

namespace App\Http\Controllers;

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

        // total omzet = jumlah semua harga_total
        $omzet = Transaksi::sum('harga_total');
        return view('content.admin.dashboard', compact('jumlahPelanggan','jumlahLayanan','jumlahTransaksi','omzet'));

    }
}
