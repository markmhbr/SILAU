<?php

namespace App\Http\Controllers\Backend\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\Diskon;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Carbon\Carbon;
use Exception;

class KasirController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index()
    {
        $transaksi = Transaksi::with(['pelanggan.user', 'layanan'])
            ->whereBetween('created_at', [
            Carbon::now()->subDays(6)->startOfDay(),
            Carbon::now()->endOfDay(),
        ])
            ->latest()
            ->paginate(10);
        return view('content.backend.karyawan.kasir.index', compact('transaksi'));
    }

    public function create()
    {
        $layanan = Layanan::all();
        $diskon = Diskon::where('aktif', 1)->get();
        return view('content.backend.karyawan.kasir.form', compact('layanan', 'diskon'));
    }

    public function cekMember(Request $request)
    {
        $user = User::where('email', $request->email)
            ->where('role', 'pelanggan')
            ->first();

        if ($user && $user->pelanggan) {
            return response()->json([
                'success' => true,
                'pelanggan_id' => $user->pelanggan->id,
                'nama' => $user->name,
                'poin' => $user->pelanggan->poin
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    public function store(Request $request)
{
    $request->validate([
        'layanan_id' => 'required|exists:layanan,id',
        'estimasi_berat' => 'required|numeric|min:0.1',
        'metode_pembayaran' => 'required|in:tunai,qris',
        'email' => 'nullable|email',
        'diskon_id' => 'nullable|exists:diskon,id',
        'catatan' => 'nullable|string',
    ]);

    DB::beginTransaction();
    try {
        $kasir = Karyawan::where('user_id', Auth::id())->firstOrFail();

        // pelanggan (member / guest)
        $pelanggan = null;
        if ($request->filled('email')) {
            $user = User::where('email', $request->email)->first();
            if ($user && $user->pelanggan) {
                $pelanggan = $user->pelanggan;
            }
        }

        $layanan = Layanan::findOrFail($request->layanan_id);

        // hitung estimasi
        $hargaEstimasi = $layanan->harga_perkilo * $request->estimasi_berat;

        $diskonNominal = 0;
        if ($request->diskon_id) {
            $diskon = Diskon::find($request->diskon_id);
            if ($diskon && $hargaEstimasi >= $diskon->minimal_transaksi) {
                $diskonNominal = $diskon->tipe === 'persentase'
                    ? ($hargaEstimasi * $diskon->nilai / 100)
                    : $diskon->nilai;
            }
        }

        $hargaEstimasiFinal = max(0, $hargaEstimasi - $diskonNominal);

        $transaksi = Transaksi::create([
            'order_id'         => 'TRX-' . time(),
            'kasir_id'         => $kasir->id,
            'pelanggan_id'     => $pelanggan?->id,
            'layanan_id'       => $layanan->id,
            'diskon_id'        => $request->diskon_id,
            'cara_serah'       => 'antar',

            'estimasi_berat'   => $request->estimasi_berat,
            'harga_estimasi'   => $hargaEstimasiFinal,

            'berat_aktual'     => null,
            'harga_final'      => null,

            'metode_pembayaran'=> $request->metode_pembayaran,
            'status'           => 'diterima kasir',
            'catatan'          => $request->catatan,
        ]);

        DB::commit();
        return redirect()
            ->route('karyawan.kasir.show', $transaksi->id)
            ->with('success', 'Transaksi berhasil dibuat');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}



    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan.user', 'layanan', 'diskon'])->findOrFail($id);

        return view('content.backend.karyawan.kasir.detail', [
            'transaksi'    => $transaksi,
            'hargaLayanan' => $transaksi->harga_total,
            'diskon'       => $transaksi->harga_total - $transaksi->harga_setelah_diskon,
            'hargaFinal'   => $transaksi->harga_setelah_diskon
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required']);

        $transaksi = Transaksi::findOrFail($id);
        $dataUpdate = ['status' => $request->status];

        // Jika status diubah ke 'selesai', set tanggal_selesai
        if ($request->status === 'selesai') {
            $dataUpdate['tanggal_selesai'] = now();
        }

        $transaksi->update($dataUpdate);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function pelangganIndex ()
    {
        $pelanggan = Pelanggan::with('user')
        ->withCount('transaksi')
        ->when(request('q'), function ($query) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%'.request('q').'%')
                  ->orWhere('email', 'like', '%'.request('q').'%');
            })->orWhere('no_hp', 'like', '%'.request('q').'%');
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();


        return view('content.backend.karyawan.kasir.pelanggan.index', compact('pelanggan'));
    }

    public function pelangganShow(Pelanggan $pelanggan)
{
    // Mengurutkan transaksi terbaru di atas
    $pelanggan->load([
        'user', 
        'transaksi' => function($query) {
            $query->latest(); // Transaksi terbaru muncul paling atas
        },
        'transaksi.layanan'
    ]);

    return view('content.backend.karyawan.kasir.pelanggan.show', compact('pelanggan'));
}

    public function updateBerat(Request $request, $id)
{
    $request->validate([
        'berat_aktual' => 'required|numeric|min:0.1',
    ]);

    $transaksi = Transaksi::with('layanan')->findOrFail($id);

    $hargaFinal = $transaksi->layanan->harga_perkilo * $request->berat_aktual;

    $transaksi->update([
        'berat_aktual' => $request->berat_aktual,
        'harga_final'  => $hargaFinal,
        'status'       => 'ditimbang',
    ]);

    return back()->with('success', 'Berat aktual & harga final diperbarui');
}


}
