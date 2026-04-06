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
            ->where(function($query) use ($user) {
                // Yang masih nunggu (siapa aja driver bisa ambil)
                $query->where('status', 'menunggu penjemputan')
                      ->whereNull('driver_id');
                
                // ATAU yang sedang diproses oleh driver ini
                $query->orWhere(function($q) use ($user) {
                    $q->whereIn('status', ['menuju lokasi penjemputan', 'diambil driver'])
                      ->where('driver_id', $user->karyawan->id);
                });
            })
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
            'status' => 'menuju lokasi penjemputan',
            'driver_id' => $karyawan->id, 
        ]);

        return redirect()
            ->route('karyawan.driver.penjemputan')
            ->with('success', 'Penjemputan dimulai, sedang menuju lokasi pelanggan');
    }

    /**
     * Driver sampai di lokasi pelanggan
     */
    public function sampai(Transaksi $transaksi)
    {
        $karyawan = auth()->user()->karyawan;

        if ($transaksi->driver_id !== $karyawan->id) {
            abort(403, 'Akses ditolak');
        }

        if ($transaksi->status !== 'menuju lokasi penjemputan') {
            return back()->with('error', 'Status tidak valid');
        }

        $transaksi->update([
            'status' => 'diambil driver'
        ]);

        return back()->with('success', 'Berhasil sampai di lokasi, silakan ambil pakaian');
    }

    /**
     * Dedicated navigation view for drivers
     */
    public function peta(Transaksi $transaksi)
    {
        $karyawan = auth()->user()->karyawan;

        if ($transaksi->driver_id !== $karyawan->id) {
            abort(403, 'Akses ditolak');
        }

        return view('content.backend.karyawan.driver.peta', compact('transaksi'));
    }

    /**
     * Update lokasi driver secara real-time
     */
    public function updateLokasi(Request $request, Transaksi $transaksi)
    {
        $karyawan = auth()->user()->karyawan;

        if ($transaksi->driver_id !== $karyawan->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $transaksi->update([
            'driver_latitude' => $request->latitude,
            'driver_longitude' => $request->longitude,
        ]);

        return response()->json(['message' => 'Location updated']);
    }

    /**
     * Driver sampai di outlet dan pakaian diterima kasir
     */
    public function terimaKasir(Transaksi $transaksi)
    {
        $karyawan = auth()->user()->karyawan;

        if ($transaksi->driver_id !== $karyawan->id) {
            abort(403, 'Akses ditolak');
        }

        if ($transaksi->status !== 'diambil driver') {
            return back()->with('error', 'Status tidak valid');
        }

        $transaksi->update([
            'status' => 'diterima kasir'
        ]);

        return redirect()
            ->route('karyawan.driver.penjemputan')
            ->with('success', 'Pakaian telah diserahkan ke kasir');
    }

    /**
     * Halaman Pengantaran (tugas driver sendiri)
     */
    public function pengantaran()
{
    $karyawan = auth()->user()->karyawan;

    $tugasAntar = Transaksi::with(['pelanggan.user'])
        ->where('driver_id', $karyawan->id)
        ->where('status', 'menunggu diantar')
        ->latest()
        ->get(); // JANGAN tambahkan ->toArray() di sini

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
