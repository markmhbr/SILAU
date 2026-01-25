<?php

namespace App\Http\Controllers\Backend\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $hariIni = Carbon::today();

        // Ambil Nama Jabatan (lowercase buat mempermudah pengecekan)
        $jabatan = strtolower($user->karyawan->jabatan->nama_jabatan ?? '');

        // --- DATA UNTUK KASIR ---
        $totalTugasHariIni = Transaksi::whereDate('tanggal_masuk', $hariIni)->count();
        $transaksiSelesaiHariIni = Transaksi::whereDate('tanggal_masuk', $hariIni)->where('status', 'selesai')->count();
        $pesananBaru = Transaksi::where('status', 'pending')->count();
        $sedangProses = Transaksi::where('status', 'proses')->count();
        $siapDiambil = Transaksi::where('status', 'selesai')->count();

        // --- DATA UNTUK DRIVER ---
        // (Asumsi lo ada kolom tipe di transaksi atau tabel jemputan, 
        // kalau belum ada, sementara kita tampilin antrean berdasarkan alamat)

        // --- QUERY UTAMA ---
        // Kita ambil alamat_lengkap dari model Pelanggan
        $antreanTugas = Transaksi::with(['pelanggan.user', 'layanan'])
    ->whereIn('status', ['pending', 'proses'])
    ->whereHas('pelanggan', function ($q) {
        $q->whereNotNull('latitude')
          ->whereNotNull('longitude');
    })
    ->latest()
    ->take(10)
    ->get();


        return view('content.backend.karyawan.dashboard', compact(
            'jabatan',
            'totalTugasHariIni',
            'transaksiSelesaiHariIni',
            'pesananBaru',
            'sedangProses',
            'siapDiambil',
            'antreanTugas'
        ));
    }
}
