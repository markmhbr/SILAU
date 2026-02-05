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

            // Pastikan data pelanggan ada dulu
            if (!$pelanggan) {
                return redirect()->route('pelanggan.index')->with('error', 'Profil pelanggan tidak ditemukan.');
            }

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
            'pelanggan_id'      => 'required|exists:pelanggan,id',
            'layanan_id'        => 'required|exists:layanan,id',
            'cara_serah'        => 'required|in:jemput,antar',
            'estimasi_berat'    => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:tunai,qris',
            'diskon_id'         => 'nullable|exists:diskon,id',
            'catatan'           => 'nullable|string',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);

        // Harga masih ESTIMASI
        $harga_estimasi = $layanan->harga_perkilo * $request->estimasi_berat;

        // Tentukan status awal berdasarkan cara serah
        $status_awal = $request->cara_serah === 'jemput'
            ? 'menunggu penjemputan'
            : 'menunggu diantar';

        $transaksi = Transaksi::create([
            'order_id'         => 'TRX-' . time(),
            'pelanggan_id'      => $request->pelanggan_id,
            'layanan_id'        => $request->layanan_id,
            'diskon_id'         => $request->diskon_id,
            'cara_serah'        => $request->cara_serah,

            'estimasi_berat'    => $request->estimasi_berat,
            'harga_estimasi'    => $harga_estimasi,

            'metode_pembayaran' => $request->metode_pembayaran,
            'status'            => $status_awal,
            'catatan'           => $request->catatan,
        ]);

        return redirect()
            ->route('pelanggan.layanan.detail', $transaksi->id)
            ->with('success', 'Pesanan berhasil dibuat. Menunggu proses selanjutnya.');
    }



    public function detail($id)
{
    $transaksi = Transaksi::with(['pelanggan', 'layanan', 'diskon'])->findOrFail($id);

    $berat = $transaksi->berat_aktual ?? $transaksi->estimasi_berat;
    $hargaLayanan = $transaksi->layanan->harga_perkilo * $berat;

    $diskon = 0;
    if ($transaksi->diskon) {
        $minimal = $transaksi->diskon->minimal_transaksi ?? 0;
        if ($hargaLayanan >= $minimal) {
            if ($transaksi->diskon->tipe === 'persentase') {
                $diskon = ($hargaLayanan * $transaksi->diskon->nilai) / 100;
            } else {
                $diskon = $transaksi->diskon->nilai;
            }
        }
    }

    $hargaFinal = $transaksi->harga_final ?? ($hargaLayanan - $diskon);

    // --- LOGIC MIDTRANS MULAI DISINI ---
    // Jika metode QRIS, status menunggu pembayaran, dan belum punya snap_token
    if ($transaksi->metode_pembayaran == 'qris' && $transaksi->status == 'menunggu pembayaran' && !$transaksi->snap_token) {
        try {
            $params = [
                'transaction_details' => [
                    'order_id' => $transaksi->order_id,
                    'gross_amount' => (int) $hargaFinal, // Harus integer
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                // Opsional: Batasi metode pembayaran agar hanya muncul yang kamu mau
                'enabled_payments' => ['qris', 'gopay', 'shopeepay', 'bank_transfer'],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            // Simpan token ke database supaya tidak request ulang terus setiap refresh
            $transaksi->snap_token = $snapToken;
            $transaksi->save();
            
        } catch (\Exception $e) {
            // Jika error, kita log tapi tetap tampilkan halaman
            \Log::error('Midtrans Error: ' . $e->getMessage());
        }
    }
    // --- LOGIC MIDTRANS SELESAI ---

    return view('content.backend.pelanggan.layanan.detail', compact(
        'transaksi',
        'hargaLayanan',
        'diskon',
        'hargaFinal',
        'berat'
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
    
        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan.');
        }
    
        // Eager load layanan DAN diskon untuk menghindari N+1 query
        $transaksis = Transaksi::with(['layanan', 'diskon'])
            ->where('pelanggan_id', $pelanggan->id)
            ->orderBy('created_at', 'desc')
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
