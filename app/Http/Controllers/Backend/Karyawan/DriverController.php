<?php

namespace App\Http\Controllers\Backend\Karyawan;

use App\Http\Controllers\Controller;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    /**
     * Halaman Penjemputan
     */
    public function penjemputan()
    {
        $user = Auth::user();

        // Pastikan memang driver
        $jabatan = strtolower($user->karyawan->jabatan->nama_jabatan ?? '');
        if (!str_contains($jabatan, 'driver')) {
            abort(403, 'Akses ditolak');
        }

        $antreanTugas = Transaksi::with(['pelanggan.user'])
            ->where('status', 'pending')
            ->whereHas('pelanggan', function ($q) {
                $q->whereNotNull('latitude')
                  ->whereNotNull('longitude');
            })
            ->latest()
            ->get();

        return view('content.backend.karyawan.driver.penjemputan', compact('antreanTugas'));
    }

    /**
     * Driver mulai jemput
     */
    public function jemput(Transaksi $transaksi)
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        // Validasi jabatan
        $jabatan = strtolower($karyawan->jabatan->nama_jabatan ?? '');
        if (!str_contains($jabatan, 'driver')) {
            return back()->with('error', 'Anda bukan driver');
        }

        // Validasi status
        if ($transaksi->status !== 'pending') {
            return back()->with('error', 'Tugas ini sudah diproses');
        }

        // LOCK: jangan bisa diambil driver lain
        if ($transaksi->id_karyawan !== null) {
            return back()->with('error', 'Tugas ini sudah diambil driver lain');
        }

        $transaksi->update([
            'status' => 'dijemput',
            'id_karyawan' => $karyawan->id,
        ]);

        return redirect()
            ->route('karyawan.driver.penjemputan')
            ->with('success', 'Penjemputan dimulai');
    }

    /**
     * Halaman Pengantaran (tugas driver sendiri)
     */
    public function pengantaran()
    {
        $karyawan = auth()->user()->karyawan;

        $tugasAntar = Transaksi::with(['pelanggan.user'])
            ->where('status', 'selesai')
            ->latest()
            ->get();

        return view('content.backend.karyawan.driver.pengantaran', compact('tugasAntar'));
    }

    /**
     * Mulai antar / update status → dikirim
     */
    public function antar(Transaksi $transaksi)
    {
        $karyawan = auth()->user()->karyawan;
        if ($transaksi->id_karyawan !== $karyawan->id) {
            abort(403);
        }

        if ($transaksi->status !== 'selesai') {
            return back()->with('error', 'Pesanan belum siap diantar');
        }

        $transaksi->update([
            'status' => 'dikirim'
        ]);

        return back()->with('success', 'Pengantaran dimulai');
    }


}
