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
    /**
     * Data Transaksi (SEMUA)
     */
    public function transaksi(Request $request)
    {
        $query = Transaksi::with([
            'pelanggan.user',
            'karyawan.user',
            'layanan',
            'diskon'
        ]);
    
        // ================= FILTER =================
        if ($request->status) {
            $query->where('status', $request->status);
        }
    
        if ($request->from) {
            $query->whereDate('tanggal_masuk', '>=', $request->from);
        }
    
        if ($request->to) {
            $query->whereDate('tanggal_masuk', '<=', $request->to);
        }
    
        // ================= DATA TABEL =================
        $transaksi = $query->latest()->paginate(10);
    
        // ================= SUMMARY =================
        $totalOmzet = (clone $query)->get()->sum(function ($item) {
            return $item->hargaSetelahDiskon();
        });
    
        $proses = (clone $query)->where('status', 'proses')->count();
        $selesai = (clone $query)->where('status', 'selesai')->count();
    
        return view('content.backend.owner.transaksi.index', compact(
            'transaksi',
            'totalOmzet',
            'proses',
            'selesai'
        ));
    }

    public function transaksiDetail($id)
    {
        $transaksi = Transaksi::with([
            'pelanggan.user',
            'karyawan.user',
            'layanan',
            'diskon'
        ])->findOrFail($id);

        return response()->json([
            'tanggal'   => $transaksi->tanggal_masuk?->format('d M Y'),
            'pelanggan' => $transaksi->pelanggan->user->name ?? 'Guest',
            'karyawan'  => $transaksi->karyawan->user->name ?? '-',
            'layanan'   => $transaksi->layanan->nama_layanan ?? '-',
            'status'    => $transaksi->status,
            'berat'     => $transaksi->berat,
            'total'     => number_format($transaksi->harga_total, 0, ',', '.'),
            'final'     => number_format($transaksi->hargaSetelahDiskon(), 0, ',', '.'),
            'catatan'   => $transaksi->catatan ?? '-',
        ]);
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new TransaksiExport(
                $request->from,
                $request->to,
                $request->status
            ),
            'transaksi-owner.xlsx'
        );
    }

    public function exportPdf()
    {
        $transaksi = Transaksi::latest()->get();
    
        $pdf = Pdf::loadView('content.backend.owner.transaksi.pdf', compact('transaksi'));
        return $pdf->download('transaksi-owner.pdf');
    }


    /**
 * Laporan
 */
public function laporan(Request $request)
{
    $query = Transaksi::with(['pelanggan.user', 'layanan']);
    $guestCount = Transaksi::whereNull('pelanggan_id')->count();
$memberCount = Transaksi::whereNotNull('pelanggan_id')->count();

    // filter tanggal
    if ($request->from && $request->to) {
        $query->whereBetween('tanggal_masuk', [
            $request->from,
            $request->to
        ]);
    }

    // filter status
    if ($request->status) {
        $query->where('status', $request->status);
    }

    $laporan = $query->latest()->get();

    // ================= RINGKASAN =================
    $totalTransaksi = $laporan->count();

    $totalOmzet = $laporan->sum(function ($item) {
        return $item->hargaSetelahDiskon();
    });

    $totalProses = $laporan->where('status', 'proses')->count();
    $totalSelesai = $laporan->where('status', 'selesai')->count();

    return view('content.backend.owner.laporan.index', compact(
        'laporan',
        'totalTransaksi',
        'totalOmzet',
        'totalProses',
        'totalSelesai',
    'guestCount',
    'memberCount'
    ));
}

    public function exportLaporanExcel(Request $request)
{
    return Excel::download(
        new LaporanExport($request),
        'laporan-transaksi.xlsx'
    );
}

public function exportLaporanPdf(Request $request)
{
    $query = Transaksi::with(['pelanggan.user', 'layanan']);

    if ($request->from && $request->to) {
        $query->whereBetween('tanggal_masuk', [
            $request->from,
            $request->to
        ]);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $laporan = $query->latest()->get();

    $pdf = Pdf::loadView('content.backend.owner.laporan.pdf', compact('laporan'))
        ->setPaper('a4', 'portrait');

    return $pdf->download('laporan-transaksi.pdf');
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
        $profil = ProfilPerusahaan::firstOrCreate([]);

        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'email'           => 'nullable|email',
            'no_wa'           => 'nullable|string|max:20',
            'logo'            => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $data = $request->only([
            'nama_perusahaan',
            'deskripsi',
            'alamat',
            'no_wa',
            'email',
            'instagram',
            'facebook',
            'tiktok',
            'youtube',
            'service_hours',
            'fast_response',
            'tentang_kami',
        ]);

        // ================= LOGO UPLOAD =================
        if ($request->hasFile('logo')) {

            // hapus logo lama
            if ($profil->logo && Storage::disk('public')->exists($profil->logo)) {
                Storage::disk('public')->delete($profil->logo);
            }

            $data['logo'] = $request->file('logo')->store('logo', 'public');
        }

        $profil->update($data);

        return redirect()
            ->back()
            ->with('success', 'Pengaturan perusahaan berhasil diperbarui');
    }
}
