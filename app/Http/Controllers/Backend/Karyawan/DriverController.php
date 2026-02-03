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
            ->where('status', 'menunggu penjemputan')
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
        if ($transaksi->status !== 'menunggu penjemputan') {
            return back()->with('error', 'Tugas ini sudah diproses');
        }

        // LOCK: jangan bisa diambil driver lain
        if ($transaksi->id_karyawan !== null) {
            return back()->with('error', 'Tugas ini sudah diambil driver lain');
        }

        $transaksi->update([
            'status' => 'diambil driver',
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

    // Menampilkan transaksi yang statusnya 'menunggu diantar' 
    // dan ditugaskan ke driver yang sedang login
    $tugasAntar = Transaksi::with(['pelanggan.user'])
        ->where('driver_id', $karyawan->id)
        ->where('status', 'menunggu diantar') // Sesuai enum di migration
        ->latest()
        ->get();

    return view('content.backend.karyawan.driver.pengantaran', compact('tugasAntar'));
}

/**
 * Mulai antar / update status
 */
public function antar(Transaksi $transaksi)
{
    $karyawan = auth()->user()->karyawan;

    // Pastikan ini memang tugas si driver tersebut
    if ($transaksi->driver_id !== $karyawan->id) {
        abort(403, 'Ini bukan tugas pengantaran Anda.');
    }

    // Cek apakah statusnya valid untuk diantar
    if ($transaksi->status !== 'menunggu diantar') {
        return back()->with('error', 'Pesanan belum siap atau sudah diantar');
    }

    // Karena di migration enum tidak ada 'dikirim', kita update ke 'selesai' 
    // atau jika Anda ingin 'diproses' (tergantung alur laundry Anda)
    // Di sini saya asumsikan 'selesai' berarti sudah sampai ke pelanggan.
    $transaksi->update([
        'status' => 'selesai' 
    ]);

    return back()->with('success', 'Status pesanan berhasil diperbarui menjadi Selesai');
}


}
