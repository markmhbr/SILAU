<?php

namespace App\Http\Controllers\Backend\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\Diskon;
use Midtrans\Config;
use Midtrans\Snap;

class LayananPelangganController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }
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
        return view('content.backend.pelanggan.layanan.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggan = Pelanggan::where('user_id', auth()->id())->first();

        // CEK KONDISI: Jika koordinat atau alamat belum diisi
        if (!$pelanggan->latitude || !$pelanggan->alamat_lengkap) {
            return redirect()->route('pelanggan.alamat')
                ->with('error', 'Silahkan lengkapi alamat penjemputan Anda terlebih dahulu sebelum membuat pesanan.');
        }

        $layanan = Layanan::all();
        $diskon = Diskon::all();
        $transaksi = null;

        return view('content.backend.pelanggan.layanan.form', compact('pelanggan', 'layanan', 'transaksi', 'diskon'));
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
            'metode_pembayaran' => 'required|string|in:tunai,qris',
            'catatan' => 'nullable|string',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $hargaLayanan = $layanan->harga_perkilo * $request->berat;

        // Hitung Diskon
        $diskon = 0;
        if ($request->diskon_id) {
            $diskonModel = Diskon::find($request->diskon_id);
            if ($diskonModel && $hargaLayanan >= $diskonModel->minimal_transaksi) {
                $diskon = ($diskonModel->tipe === 'persentase') 
                    ? ($hargaLayanan * $diskonModel->nilai) / 100 
                    : $diskonModel->nilai;
            }
        }

        $hargaFinal = $hargaLayanan - $diskon;
        $statusTransaksi = ($request->metode_pembayaran === 'tunai') ? 'proses' : 'pending';

        // Buat Transaksi di Database
        $transaksi = Transaksi::create([
            'pelanggan_id' => $request->pelanggan_id,
            'layanan_id' => $request->layanan_id,
            'diskon_id' => $request->diskon_id,
            'tanggal_masuk' => now(),
            'berat' => $request->berat,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => $statusTransaksi,
            'catatan' => $request->catatan,
            'harga_total' => $hargaLayanan,
            'harga_setelah_diskon' => $hargaFinal,
        ]);

        // LOGIKA MIDTRANS (Hanya jika memilih QRIS/Online)
        if ($request->metode_pembayaran === 'qris') {
            $params = [
                'transaction_details' => [
                    'order_id' => 'TRX-' . $transaksi->id . '-' . time(),
                    'gross_amount' => (int) $hargaFinal,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                'item_details' => [
                    [
                        'id' => $layanan->id,
                        'price' => (int) ($hargaFinal / $request->berat), // Harga rata-rata per kg setelah diskon
                        'quantity' => $request->berat,
                        'name' => $layanan->nama_layanan,
                    ]
                ]
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $transaksi->snap_token = $snapToken;
                $transaksi->save();
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal terhubung ke Midtrans: ' . $e->getMessage());
            }
        }

        // Update poin pelanggan
        $pelanggan = Pelanggan::find($request->pelanggan_id);
        $pelanggan->poin += ($hargaFinal / 10);
        $pelanggan->save();

        return redirect()->route('pelanggan.layanan.detail', $transaksi->id)
            ->with('success', 'Pesanan berhasil dibuat!');
    }


    public function detail($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'layanan'])->findOrFail($id);

        $hargaLayanan = $transaksi->layanan->harga_perkilo * $transaksi->berat;

        $diskon = 0;
        if ($transaksi->diskon) {
            // cek minimal transaksi dulu
            if ($hargaLayanan >= $transaksi->diskon->minimal_transaksi) {
                if ($transaksi->diskon->tipe === 'persentase') {
                    $diskon = ($hargaLayanan * $transaksi->diskon->nilai) / 100;
                } else {
                    $diskon = $transaksi->diskon->nilai;
                }
            }
        }


        $hargaFinal = $hargaLayanan - $diskon;

        return view('content.backend.pelanggan.layanan.detail', compact(
            'transaksi',
            'hargaLayanan',
            'diskon',
            'hargaFinal'
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

    public function pesanan()
    {
        // Ambil pelanggan yang login
        $pelanggan = Pelanggan::where('user_id', auth()->id())->first();

        // Ambil semua transaksi milik pelanggan itu saja, sekaligus eager load layanan
        $transaksis = Transaksi::with('layanan')
            ->where('pelanggan_id', $pelanggan->id)
            ->get();
        return view('content.backend.pelanggan.layanan.pesanan', compact('transaksis'));
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
