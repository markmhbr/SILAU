<?php

namespace App\Http\Controllers\Backend\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Layanan;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ================= HARI INI =================
        $omzetHariIni = Transaksi::whereDate('tanggal_masuk', today())
            ->where('status', 'selesai')
            ->sum('harga_setelah_diskon');

        $totalTransaksiHariIni = Transaksi::whereDate('tanggal_masuk', today())
            ->count();

        // ================= BULAN INI =================
        $totalTransaksiBulanIni = Transaksi::whereMonth('tanggal_masuk', now()->month)
            ->whereYear('tanggal_masuk', now()->year)
            ->count();

        $omzetBulanIni = Transaksi::whereMonth('tanggal_masuk', now()->month)
            ->whereYear('tanggal_masuk', now()->year)
            ->where('status', 'selesai')
            ->sum('harga_setelah_diskon');

        // ================= ORDER BELUM SELESAI =================
        $orderBelumSelesai = Transaksi::where('status', '!=', 'selesai')->count();

        // ================= LAYANAN TERLARIS =================
        $layananTerlaris = Layanan::withCount('transaksi')
            ->orderByDesc('transaksi_count')
            ->first();

        // ================= TRANSAKSI TERBARU =================
        $transaksiTerbaru = Transaksi::with(['pelanggan', 'layanan'])
            ->orderByDesc('tanggal_masuk')
            ->limit(5)
            ->get();

        return view('content.backend.owner.dashboard', compact(
            'omzetHariIni',
            'totalTransaksiHariIni',
            'totalTransaksiBulanIni',
            'omzetBulanIni',
            'orderBelumSelesai',
            'layananTerlaris',
            'transaksiTerbaru'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
