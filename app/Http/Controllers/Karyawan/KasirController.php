<?php

namespace App\Http\Controllers\Karyawan;

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
            'berat' => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:tunai,qris',
            'email' => 'nullable|email', // cari pelanggan pakai email
            'diskon_id' => 'nullable|exists:diskon,id',
            'catatan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // ===============================
            // 1. AMBIL KARYAWAN LOGIN
            // ===============================
            $karyawan = Karyawan::where('user_id', Auth::id())->firstOrFail();

            // ===============================
            // 2. TENTUKAN PELANGGAN (MEMBER / GUEST)
            // ===============================
            $pelanggan = null;

            if ($request->filled('email')) {
                $user = User::where('email', $request->email)->first();

                if ($user && $user->pelanggan) {
                    $pelanggan = $user->pelanggan;
                }
            }

            // ===============================
            // 3. HITUNG HARGA LAYANAN
            // ===============================
            $layanan = Layanan::findOrFail($request->layanan_id);
            $hargaLayanan = $layanan->harga_perkilo * $request->berat;

            // ===============================
            // 4. HITUNG DISKON (JAGA LOGIKA)
            // ===============================
            $diskonNominal = 0;

            if ($request->diskon_id) {
                $diskonModel = Diskon::find($request->diskon_id);

                if (
                    $diskonModel &&
                    $hargaLayanan >= $diskonModel->minimal_transaksi
                ) {
                    $diskonNominal = ($diskonModel->tipe === 'persentase')
                        ? ($hargaLayanan * $diskonModel->nilai) / 100
                        : $diskonModel->nilai;
                }
            }

            if ($diskonNominal > $hargaLayanan) {
                throw new \Exception('Diskon melebihi harga transaksi.');
            }

            $hargaFinal = $hargaLayanan - $diskonNominal;

            // ===============================
            // 5. STATUS TRANSAKSI
            // ===============================
            $statusTransaksi = ($request->metode_pembayaran === 'tunai')
                ? 'proses'
                : 'pending';

            // ===============================
            // 6. SIMPAN TRANSAKSI
            // ===============================
            $transaksi = Transaksi::create([
                'id_karyawan'          => $karyawan->id,
                'pelanggan_id'         => $pelanggan?->id, // NULL = guest
                'layanan_id'           => $layanan->id,
                'diskon_id'            => $request->diskon_id,
                'tanggal_masuk'        => now(),
                'berat'                => $request->berat,
                'harga_total'          => $hargaLayanan,
                'harga_setelah_diskon' => $hargaFinal,
                'metode_pembayaran'    => $request->metode_pembayaran,
                'status'               => $statusTransaksi,
                'catatan'              => $request->catatan,
            ]);

            // ===============================
            // 7. MIDTRANS (QRIS)
            // ===============================
            if ($request->metode_pembayaran === 'qris') {
                $params = [
                    'transaction_details' => [
                        'order_id' => 'TRX-KSR-' . $transaksi->id . '-' . time(),
                        'gross_amount' => (int) $hargaFinal,
                    ],
                    'customer_details' => [
                        'first_name' => $pelanggan ? $pelanggan->user->name : 'Guest',
                        'email'      => $pelanggan ? $pelanggan->user->email : 'guest@laundry.com',

                    ],
                ];

                $snapToken = Snap::getSnapToken($params);
                $transaksi->update(['snap_token' => $snapToken]);
            }

            // ===============================
            // 8. POIN MEMBER (AMAN)
            // ===============================
            if ($pelanggan && $request->metode_pembayaran === 'tunai') {
                // Ambil langsung dari input hidden yang dikirim form
                $poinDidapat = $request->input('poin_didapat', 0);

                if ($poinDidapat > 0) {
                    $pelanggan->increment('poin', $poinDidapat);
                }
            }

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
}
