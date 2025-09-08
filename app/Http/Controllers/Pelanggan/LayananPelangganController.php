<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\Diskon;

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
        $diskon = Diskon::all();
        $transaksi = null;
        return view('content.pelanggan.layanan.form', compact('pelanggan', 'layanan','transaksi','diskon'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'layanan_id' => 'required|exists:layanan,id',
            'berat' => 'required|numeric|min:0.1',
            'diskon_id' => 'nullable|exists:diskon,id',
            'metode_pembayaran' => 'nullable|string|in:tunai,qris',
            'catatan' => 'nullable|string',
        ]);
    
        $layanan = Layanan::findOrFail($request->layanan_id);
        $hargaLayanan = $layanan->harga_perkilo * $request->berat;
    
        $diskon = 0;
        if ($request->diskon_id) {
            $diskonModel = Diskon::find($request->diskon_id);
            if ($diskonModel) {
                if ($diskonModel->tipe === 'persentase') {
                    $diskon = ($hargaLayanan * $diskonModel->nilai) / 100;
                } else {
                    $diskon = $diskonModel->nilai;
                }
            }
        }
    
        $hargaFinal = $hargaLayanan - $diskon;
    
        $transaksi = Transaksi::create([
            'pelanggan_id' => $request->pelanggan_id,
            'layanan_id' => $request->layanan_id,
            'diskon_id' => $request->diskon_id,
            'tanggal_masuk' => now(),
            'berat' => $request->berat,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'proses',
            'catatan' => $request->catatan,
            'harga_total' => $hargaLayanan,
            'harga_setelah_diskon' => $hargaFinal, // ⬅️ simpan langsung
        ]);
    
        return redirect()->route('pelanggan.layanan.detail', $transaksi->id)
                         ->with('success', 'Transaksi berhasil dibuat. Silakan lanjut ke detail untuk pembayaran.');
    }



    public function detail($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'layanan'])->findOrFail($id);
    
        $hargaLayanan = $transaksi->layanan->harga_perkilo * $transaksi->berat;
    
        $diskon = 0;
        if ($transaksi->diskon) {
            if ($transaksi->diskon->tipe === 'persentase') {
                $diskon = ($hargaLayanan * $transaksi->diskon->nilai) / 100;
            } else {
                $diskon = $transaksi->diskon->nilai;
            }
        }
    
        $hargaFinal = $hargaLayanan - $diskon;
    
        return view('content.pelanggan.layanan.detail', compact(
            'transaksi', 'hargaLayanan', 'diskon', 'hargaFinal'
        ));
    }


    public function bayar(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        // simpan bukti bayar
        $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        $transaksi->bukti_bayar = $path;
        $transaksi->status = 'menunggu konfirmasi';
        $transaksi->save();

        return redirect()->route('pelanggan.layanan.detail', $id)
            ->with('success', 'Bukti pembayaran berhasil diupload, menunggu konfirmasi admin.');
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
