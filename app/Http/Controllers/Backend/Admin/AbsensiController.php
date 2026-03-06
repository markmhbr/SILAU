<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with(['karyawan.user', 'karyawan.jabatan'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_masuk', 'desc');

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        $absensis = $query->get();
        $selectedDate = $request->query('tanggal');

        return view('backend.admin.absensi.index', compact('absensis', 'selectedDate'));
    }

    public function kiosk()
    {
        $tanggal_hari_ini = Carbon::today()->toDateString();

        // Ambil absensi hari ini beserta karyawan (untuk waktu masuk/keluar)
        $absensiHariIni = Absensi::with(['karyawan.user', 'karyawan.jabatan'])
            ->where('tanggal', $tanggal_hari_ini)
            ->get();

        $sudahAbsenIds = $absensiHariIni->pluck('karyawan_id')->toArray();

        $sudahAbsen = $absensiHariIni; // Koleksi absensi (karyawan ada di dalamnya)
        $belumAbsen = Karyawan::with(['user', 'jabatan'])
            ->whereNotIn('id', $sudahAbsenIds)
            ->get();

        return view('backend.admin.absensi.kiosk', compact('sudahAbsen', 'belumAbsen'));
    }

    public function create()
    {
        // Fitur tambah absensi manual (misal izin/sakit) jika diperlukan.
    }

    public function store(Request $request)
    {
        // Logika simpan absensi manual
    }

    public function show($id)
    {
        // Detail absensi
    }

    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        return view('backend.admin.absensi.edit', compact('absensi'));
    }

    public function update(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);

        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|string'
        ]);

        $absensi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('admin.absensi.index')->with('success', 'Berhasil mengupdate status absensi.');
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('admin.absensi.index')->with('success', 'Data absensi berhasil dihapus.');
    }

    public function scanBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string'
        ]);

        $karyawan = Karyawan::with('user')->where('barcode', $request->barcode)->first();

        if (!$karyawan) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Barcode tidak dikenali atau karyawan tidak ditemukan.']);
            }
            return redirect()->back()->with('error', 'Barcode tidak dikenali atau karyawan tidak ditemukan.');
        }

        $tanggal_hari_ini = Carbon::today()->toDateString();
        $waktu_sekarang = Carbon::now()->toTimeString();

        // Cari absensi hari ini untuk karyawan tsb
        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->where('tanggal', $tanggal_hari_ini)
            ->first();

        if (!$absensi) {
            // Clock In (Absen Masuk)
            Absensi::create([
                'karyawan_id' => $karyawan->id,
                'tanggal' => $tanggal_hari_ini,
                'waktu_masuk' => $waktu_sekarang,
                'status' => 'hadir'
            ]);
            $tipe = 'Masuk';
        } else {
            // Cek apakah sudah absen keluar
            if ($absensi->waktu_keluar) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => "Karyawan {$karyawan->user->name} sudah melakukan Absen Keluar hari ini."]);
                }
                return redirect()->back()->with('error', "Karyawan {$karyawan->user->name} sudah melakukan Absen Keluar hari ini.");
            }

            // Clock Out (Absen Keluar)
            $absensi->update([
                'waktu_keluar' => $waktu_sekarang
            ]);
            $tipe = 'Keluar';
        }

        $message = "Berhasil! {$karyawan->user->name} telah Absen {$tipe} pada {$waktu_sekarang}.";

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'karyawan_id' => $karyawan->id,
                    'nama' => $karyawan->user->name,
                    'jabatan' => $karyawan->jabatan->nama_jabatan ?? '-',
                    'tipe' => $tipe,
                    'waktu' => Carbon::parse($waktu_sekarang)->format('H:i'),
                    'avatar_initial' => substr($karyawan->user->name, 0, 1)
                ]
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
