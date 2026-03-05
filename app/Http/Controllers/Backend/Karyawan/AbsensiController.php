<?php

namespace App\Http\Controllers\Backend\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $karyawan = Auth::user()->karyawan;
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $tanggal_hari_ini = Carbon::today()->toDateString();

        // Cek absensi hari ini
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
            ->where('tanggal', $tanggal_hari_ini)
            ->first();

        // Riwayat absensi 30 hari terakhir
        $riwayatAbsensi = Absensi::where('karyawan_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->limit(30)
            ->get();

        return view('backend.karyawan.absensi.index', compact('absensiHariIni', 'riwayatAbsensi'));
    }

    public function masuk(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $tanggal_hari_ini = Carbon::today()->toDateString();
        $waktu_sekarang = Carbon::now()->toTimeString();

        // Cek jika sudah absen hari ini
        $cekAbsen = Absensi::where('karyawan_id', $karyawan->id)
            ->where('tanggal', $tanggal_hari_ini)
            ->exists();

        if ($cekAbsen) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }

        $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Absensi::create([
            'karyawan_id' => $karyawan->id,
            'tanggal' => $tanggal_hari_ini,
            'waktu_masuk' => $waktu_sekarang,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'hadir',
        ]);

        return redirect()->back()->with('success', 'Berhasil melakukan absen masuk.');
    }

    public function keluar(Request $request)
    {
        $karyawan = Auth::user()->karyawan;

        $tanggal_hari_ini = Carbon::today()->toDateString();
        $waktu_sekarang = Carbon::now()->toTimeString();

        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->where('tanggal', $tanggal_hari_ini)
            ->first();

        if (!$absensi) {
            return redirect()->back()->with('error', 'Anda belum melakukan absen masuk hari ini.');
        }

        if ($absensi->waktu_keluar) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen keluar hari ini.');
        }

        $absensi->update([
            'waktu_keluar' => $waktu_sekarang,
        ]);

        return redirect()->back()->with('success', 'Berhasil melakukan absen keluar.');
    }
}
