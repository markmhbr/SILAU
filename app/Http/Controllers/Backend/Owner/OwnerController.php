<?php

namespace App\Http\Controllers\Backend\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\ProfilPerusahaan;
use App\Exports\TransaksiExport;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class OwnerController extends Controller
{
    public function laporan(Request $request)
    {
        // ================= QUERY UTAMA =================
        // Sesuai migrasi: Relasi ke pelanggan, lalu pelanggan ke user (jika ada)
        $query = Transaksi::with(['pelanggan', 'layanan']);

        // ================= FILTER TANGGAL (Menggunakan created_at) =================
        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59'
            ]);
        }

        // ================= FILTER STATUS =================
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $laporan = $query->latest()->get();

        // ================= RINGKASAN =================
        $totalTransaksi = $laporan->count();

        // Omzet hanya dihitung dari harga_final pada transaksi yang 'selesai' atau 'dibayar'
        $totalOmzet = $laporan->whereIn('status', ['selesai', 'dibayar', 'diproses'])->sum('harga_final');

        // Total Proses: Semua status kecuali selesai, dibatalkan, dan menunggu penjemputan
        $totalProses  = $laporan->whereNotIn('status', ['selesai', 'dibatalkan', 'menunggu penjemputan'])->count();
        $totalSelesai = $laporan->where('status', 'selesai')->count();

        // ================= GUEST vs MEMBER =================
        $guestCount  = Transaksi::whereNull('pelanggan_id')->count();
        $memberCount = Transaksi::whereNotNull('pelanggan_id')->count();

        // ================= STATUS LIST (Sesuai Enum di Migration) =================
        $statusList = [
            'menunggu penjemputan',
            'menunggu diantar',
            'diambil driver',
            'diterima kasir',
            'ditimbang',
            'menunggu pembayaran',
            'dibayar',
            'diproses',
            'selesai',
            'dibatalkan'
        ];

        return view('content.backend.owner.laporan.index', compact(
            'laporan',
            'totalTransaksi',
            'totalOmzet',
            'totalProses',
            'totalSelesai',
            'guestCount',
            'memberCount',
            'statusList'
        ));
    }


    public function exportLaporanExcel(Request $request)
    {
        $fileName = 'laporan-laundry-' . now()->format('Y-m-d-His') . '.xlsx';

        return Excel::download(
            new LaporanExport($request),
            $fileName
        );
    }

    public function exportLaporanPdf(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'layanan']);

        // Sesuaikan dengan kolom created_at sesuai migration
        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59'
            ]);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $laporan = $query->latest()->get();

        $pdf = Pdf::loadView('content.backend.owner.laporan.pdf', compact('laporan'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-transaksi-' . date('Y-m-d') . '.pdf');
    }


    /**
     * =========================
     * HALAMAN PENGATURAN
     * =========================
     */
    public function pengaturan()
    {
        $profil = ProfilPerusahaan::firstOrCreate([]);

        return view('content.backend.owner.pengaturan', compact('profil'));
    }

    /**
     * =========================
     * UPDATE PENGATURAN
     * =========================
     */
    public function updatePengaturan(Request $request)
{
    // 1. Validasi
    $validatedData = $request->validate([
        'nama_perusahaan' => 'required|string|max:255',
        'deskripsi'       => 'nullable|string',
        'alamat'          => 'nullable|string',
        'no_wa'           => 'nullable|string|max:20',
        'email'           => 'nullable|email|max:255',
        'instagram'       => 'nullable|string|max:255',
        'facebook'        => 'nullable|string|max:255',
        'tiktok'          => 'nullable|string|max:255',
        'youtube'         => 'nullable|string|max:255',
        'service_hours'   => 'nullable|string|max:255',
        'tentang_kami'    => 'nullable|string',
        'logo'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    // 2. Ambil data pertama atau buat objek baru
    $profil = ProfilPerusahaan::firstOrNew();

    // 3. Logika Logo
    if ($request->hasFile('logo')) {
        // Hapus logo lama jika ada
        if ($profil->logo && file_exists(public_path('logo/' . $profil->logo))) {
            unlink(public_path('logo/' . $profil->logo));
        }

        $file = $request->file('logo');
        $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('logo'), $filename);
        
        // Simpan nama file ke array data
        $validatedData['logo'] = $filename;
    }

    // 4. Update dan Simpan
    $profil->fill($validatedData);
    $profil->save();

    return redirect()->back()->with('success', 'Profil usaha berhasil diperbarui.');
}
}
