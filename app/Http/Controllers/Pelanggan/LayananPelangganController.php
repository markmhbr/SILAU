<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Layanan;

class LayananPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil pelanggan yang login
        $pelanggan = Pelanggan::where('user_id', auth()->id())->first();

        // Ambil semua transaksi milik pelanggan itu saja, sekaligus eager load layanan
        $transaksis = Transaksi::with('layanan')
                        ->where('pelanggan_id', $pelanggan->id)
                        ->get();
        return view('content.pelanggan.layanan.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $pelanggan = Pelanggan::where('user_id', auth()->id())->first();
        // dd($pelanggan->toArray());
        $layanan = Layanan::all();
        $transaksi = null;
        return view('content.pelanggan.layanan.form', compact('pelanggan', 'layanan','transaksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {    
            $request->validate([
                'pelanggan_id' => 'required|exists:pelanggan,id',
                'layanan_id' => 'required|exists:layanan,id',
                'berat' => 'required|numeric|min:0.1',
                'harga_total' => 'required|numeric|min:0',
                'metode_pembayaran' => 'nullable|string|in:tunai,transfer,e-wallet',
                'bukti_bayar' => 'nullable|file|mimes:jpg,png,jpeg,pdf',
                'catatan' => 'nullable|string',
            ]);
            // dd($request->all());
            
            Transaksi::create([
                'pelanggan_id' => $request->pelanggan_id,
                'layanan_id' => $request->layanan_id,
                'tanggal_masuk' => now(),
                'berat' => $request->berat,
                'harga_total' => $request->harga_total,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bukti_bayar' => $request->bukti_bayar ? $request->file('bukti_bayar')->store('bukti_bayar', 'public') : null,
                'catatan' => $request->catatan,
                'status' => 'proses', // default status
            ]);

            return redirect()->route('pelanggan.layanan.index')->with('success', 'Data transaksi berhasil ditambahkan.');
        } catch (\Throwable $th) {
            throw $th;
        }
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
