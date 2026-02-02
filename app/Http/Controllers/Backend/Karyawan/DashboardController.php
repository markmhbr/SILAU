<?php

namespace App\Http\Controllers\Backend\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $hariIni = Carbon::today();

        $jabatan = strtolower($user->karyawan->jabatan->nama_jabatan ?? '');

        /**
         * =========================
         * DATA UMUM (HARI INI)
         * =========================
         */
        $totalTugasHariIni = Transaksi::whereDate('created_at', $hariIni)->count();

        $transaksiSelesaiHariIni = Transaksi::whereDate('updated_at', $hariIni)
            ->where('status', 'selesai')
            ->count();

        /**
         * =========================
         * DATA UNTUK KASIR
         * =========================
         */
        $pesananBaru = Transaksi::whereIn('status', [
            'menunggu penjemputan',
            'menunggu diantar'
        ])->count();

        $sedangProses = Transaksi::whereIn('status', [
            'diterima_kasir',
            'ditimbang',
            'diproses'
        ])->count();

        $siapDiambil = Transaksi::where('status', 'selesai')->count();

        /**
         * =========================
         * DATA UNTUK DRIVER
         * =========================
         * Antrean jemput / antar
         */
        $antreanTugas = Transaksi::with(['pelanggan.user', 'layanan'])
            ->whereIn('status', [
                'menunggu penjemputan',
                'menunggu diantar'
            ])
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
