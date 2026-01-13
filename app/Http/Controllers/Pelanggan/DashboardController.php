<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Ambil data user beserta data pelanggannya
        $user = Auth::user();

        // Pastikan kita ambil ID dari tabel pelanggan, bukan tabel users
        // Asumsi: User hasOne Pelanggan
        $pelanggan = \App\Models\Pelanggan::where('user_id', $user->id)->first();

        if (!$pelanggan) {
            return "Data profil pelanggan belum dibuat.";
        }

        $pelangganId = $pelanggan->id;

        // Hitung Statistik berdasarkan pelanggan_id yang benar
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

        return view('content.backend.pelanggan.dashboard', compact('user', 'totalProses', 'totalSelesai', 'transaksiAktif'));
    }
}
