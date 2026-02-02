<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\ProfilPerusahaan;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    public function index()
    {
        // Mengambil data dengan relasi, diurutkan dari yang terbaru
        $transaksis = Transaksi::with(['pelanggan.user', 'layanan'])->latest()->get();

        return view('content.backend.admin.transaksi.index', compact('transaksis'));
    }

    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function updateStatus($id, $status)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Daftar status yang valid sesuai dengan enum di database Anda
        $validStatus = ['menunggu pembayaran', 'diproses', 'selesai', 'dibatalkan'];

        if (in_array($status, $validStatus)) {
            $transaksi->status = $status;
            
            // Logika tanggal selesai
            if ($status === 'selesai') {
                $transaksi->tanggal_selesai = now();
            } else {
                $transaksi->tanggal_selesai = null;
            }
            
            $transaksi->save();
            return redirect()->back()->with('success', "Status transaksi #{$transaksi->order_id} diperbarui menjadi {$status}!");
        }

        return redirect()->back()->with('error', 'Status tidak valid!');
    }

    /**
     * Display the specified resource.
     * Halaman Detail Transaksi di Dashboard
     */
    public function show($id)
{
    $transaksi = Transaksi::with(['pelanggan.user', 'layanan', 'diskon'])->findOrFail($id);
    // Ambil data profil perusahaan pertama
    $profil = ProfilPerusahaan::first(); 

    return view('content.backend.admin.transaksi.struk', compact('transaksi', 'profil'));
}

    /**
     * Cetak Struk format Thermal
     */
    public function cetakStruk($id)
    {
        $transaksi = Transaksi::with(['pelanggan.user', 'layanan', 'diskon'])->findOrFail($id);
        
        // Arahkan ke view struk yang minimalis
        return view('content.backend.admin.transaksi.struk', compact('transaksi'));
    }
}