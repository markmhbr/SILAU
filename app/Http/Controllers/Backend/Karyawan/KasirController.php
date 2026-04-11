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
            'berat_aktual' => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:tunai,qris',
            'pelanggan_tipe' => 'required|in:member,guest',
            'email' => 'required_if:pelanggan_tipe,member|nullable|email',
            'nama_guest' => 'required_if:pelanggan_tipe,guest|nullable|string',
            'no_hp_guest' => 'required_if:pelanggan_tipe,guest|nullable|string',
            'waktu_ambil' => 'required_if:pelanggan_tipe,guest|nullable|string',
            'diskon_id' => 'nullable|exists:diskon,id',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $kasir = Karyawan::where('user_id', Auth::id())->firstOrFail();

            // pelanggan (member / guest)
            $pelanggan = null;
            $namaGuest = null;
            $hpGuest = null;
            $waktuAmbil = null;

            if ($request->pelanggan_tipe === 'member' && $request->filled('email')) {
                $user = User::where('email', $request->email)->first();
                if ($user && $user->pelanggan) {
                    $pelanggan = $user->pelanggan;
                }
            } else {
                $namaGuest = $request->nama_guest;
                $hpGuest = $request->no_hp_guest;
                $waktuAmbil = $request->waktu_ambil;
            }

            $layanan = Layanan::findOrFail($request->layanan_id);

            // hitung harga final langsung dari berat_aktual
            $hargaLayanan = $layanan->harga_perkilo * $request->berat_aktual;

            $diskonNominal = 0;
            if ($request->diskon_id) {
                $diskon = Diskon::find($request->diskon_id);
                if ($diskon && $hargaLayanan >= $diskon->minimal_transaksi) {
                    $diskonNominal = $diskon->tipe === 'persentase'
                        ? ($hargaLayanan * $diskon->nilai / 100)
                        : $diskon->nilai;
                }
            }

            $hargaFinal = max(0, $hargaLayanan - $diskonNominal);

            // Tentukan status awal berdasarkan metode pembayaran
            $statusAwal = 'diterima kasir';
            $paidAt = null;

            if ($request->metode_pembayaran === 'tunai') {
                $statusAwal = 'dibayar';
                $paidAt = now();
            } elseif ($request->metode_pembayaran === 'qris') {
                $statusAwal = 'menunggu pembayaran';
            }

            $transaksi = Transaksi::create([
                'order_id'         => 'TRX-' . time(),
                'kasir_id'         => $kasir->id,
                'pelanggan_id'     => $pelanggan?->id,
                'nama_guest'       => $namaGuest,
                'no_hp_guest'      => $hpGuest,
                'waktu_ambil'      => $waktuAmbil,
                'layanan_id'       => $layanan->id,
                'diskon_id'        => $request->diskon_id,
                'cara_serah'       => 'antar',

                'estimasi_berat'   => $request->berat_aktual,
                'harga_estimasi'   => $hargaFinal,

                'berat_aktual'     => $request->berat_aktual,
                'harga_final'      => $hargaFinal,

                'metode_pembayaran' => $request->metode_pembayaran,
                'status'           => $statusAwal,
                'paid_at'          => $paidAt,
                'catatan'          => $request->catatan,
            ]);

            // Jika QRIS, langsung buat token Midtrans
            if ($request->metode_pembayaran === 'qris') {
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $transaksi->order_id,
                        'gross_amount' => $transaksi->harga_final,
                    ],
                    'customer_details' => [
                        'first_name' => $transaksi->pelanggan ? $transaksi->pelanggan->user->name : ($transaksi->nama_guest ?? 'Guest'),
                        'email' => $transaksi->pelanggan ? $transaksi->pelanggan->user->email : 'guest@example.com',
                        'phone' => $transaksi->pelanggan ? $transaksi->pelanggan->no_hp : $transaksi->no_hp_guest,
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $transaksi->snap_token = $snapToken;
                $transaksi->save();
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

    public function pelangganIndex()
    {
        $pelanggan = Pelanggan::with('user')
            ->withCount('transaksi')
            ->when(request('q'), function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . request('q') . '%')
                        ->orWhere('email', 'like', '%' . request('q') . '%');
                })->orWhere('no_hp', 'like', '%' . request('q') . '%');
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
            'transaksi' => function ($query) {
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

        return back()->with('success', 'Berat aktual & harga final diperbarui, silahkan lanjutkan pembayaran!');
    }

    public function bayar(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if (!$transaksi->harga_final) {
            return back()->with('error', 'Berat aktual belum ditimbang, tidak dapat melanjutkan pembayaran.');
        }

        // Kalau Tunai = Langsung Lunas
        if ($transaksi->metode_pembayaran === 'tunai') {
            $transaksi->update([
                'status'  => 'dibayar',
                'paid_at' => now(),
            ]);
            return back()->with('success', 'Pembayaran tunai berhasil diselesaikan!');
        }

        // Kalau QRIS = Buat Token Midtrans
        if ($transaksi->metode_pembayaran === 'qris') {
            if (!$transaksi->snap_token) {
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $transaksi->order_id,
                        'gross_amount' => $transaksi->harga_final,
                    ],
                    'customer_details' => [
                        'first_name' => $transaksi->pelanggan ? $transaksi->pelanggan->user->name : ($transaksi->nama_guest ?? 'Guest'),
                        'email' => $transaksi->pelanggan ? $transaksi->pelanggan->user->email : 'guest@example.com',
                        'phone' => $transaksi->pelanggan ? $transaksi->pelanggan->no_hp : $transaksi->no_hp_guest,
                    ],
                ];

                try {
                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    $transaksi->snap_token = $snapToken;
                    $transaksi->status = 'menunggu pembayaran';
                    $transaksi->save();
                } catch (\Exception $e) {
                    return back()->with('error', 'Gagal memanggil Midtrans: ' . $e->getMessage());
                }
            } else {
                // Jika kasir menekan tombol saat snap_token sudah ada: update jika QRIS berhasil (dikirim via AJAX param sukses)
                if ($request->has('qris_success')) {
                    $transaksi->update([
                        'status'  => 'dibayar',
                        'paid_at' => now(),
                    ]);
                    return response()->json(['success' => true]);
                }
            }

            return back()->with('success', 'Token QRIS berhasil dibuat, klik Bayar QRIS untuk memunculkan barcode!');
        }

        return back()->with('error', 'Metode pembayaran tidak valid.');
    }

    /**
     * Cetak Struk format Thermal (Karyawan)
     */
    public function cetakStruk($id)
    {
        $transaksi = Transaksi::with(['pelanggan.user', 'layanan', 'diskon'])->findOrFail($id);
        $profil = \App\Models\ProfilPerusahaan::first();

        return view('content.backend.admin.transaksi.struk', compact('transaksi', 'profil'));
    }

    /**
     * Halaman Monitoring Driver (Real-time dari Kasir)
     */
    public function monitoring()
    {
        $activeDrivers = Transaksi::with(['driver.user', 'pelanggan.user'])
            ->whereIn('status', ['menuju lokasi penjemputan', 'diambil driver'])
            ->latest()
            ->get();

        $outlet = \App\Models\ProfilPerusahaan::first();

        return view('content.backend.karyawan.kasir.monitoring', compact('activeDrivers', 'outlet'));
    }
}
