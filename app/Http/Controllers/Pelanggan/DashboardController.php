<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        // Ambil data pelanggan beserta poinnya
        $pelanggan = Pelanggan::where('user_id', $user->id)->first();

        if (!$pelanggan) {
            return "Data profil pelanggan belum dibuat.";
        }

        $pelangganId = $pelanggan->id;

        $totalProses = Transaksi::where('pelanggan_id', $pelangganId)
            ->whereIn('status', ['pending', 'proses'])
            ->count();

        $totalSelesai = Transaksi::where('pelanggan_id', $pelangganId)
            ->where('status', 'selesai')
            ->count();

        $transaksiAktif = Transaksi::with('layanan')
            ->where('pelanggan_id', $pelangganId)
            ->latest()
            ->take(3)
            ->get();

        // Tambahkan $pelanggan ke compact
        return view('content.backend.pelanggan.dashboard', compact(
            'user',
            'pelanggan', // Data poin ada di sini
            'totalProses',
            'totalSelesai',
            'transaksiAktif'
        ));
    }
}
