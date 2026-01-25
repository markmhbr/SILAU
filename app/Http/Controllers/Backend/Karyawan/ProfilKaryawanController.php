<?php

namespace App\Http\Controllers\Backend\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilKaryawanController extends Controller
{
    /**
     * Menampilkan profil karyawan yang sedang login.
     */
    public function index()
    {
        // Ambil data karyawan berdasarkan user_id yang sedang login
        // Eager load jabatan untuk menampilkan nama jabatan di view
        $karyawan = Karyawan::with('jabatan')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('content.backend.karyawan.profile', compact('karyawan'));
    }

    /**
     * Update profil karyawan (Nama, No HP, Alamat, Foto).
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        try {
            $karyawan = Karyawan::where('user_id', Auth::id())->firstOrFail();

            // Validasi input
            $validated = $request->validate([
                'nama'   => 'required|string|max:255',
                'no_hp'  => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'foto'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
            ]);

            // 1. Update Nama di tabel Users (via relasi)
            $karyawan->user->update([
                'name' => $validated['nama'],
            ]);

            // 2. Update Data di tabel Karyawans
            $karyawan->update([
                'no_hp'  => $validated['no_hp'] ?? "",
                'alamat' => $validated['alamat'] ?? "",
            ]);

            // 3. Handle Upload Foto
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada di storage
                if ($karyawan->foto) {
                    Storage::disk('public')->delete($karyawan->foto);
                }

                $file = $request->file('foto');
                $path = $file->store('foto_karyawan', 'public');
                
                $karyawan->update([
                    'foto' => $path
                ]);
            }

            return redirect()
                ->route('karyawan.profil.index')
                ->with('success', 'Profil Anda berhasil diperbarui!');

        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Menampilkan form untuk mengedit alamat karyawan.
     */
    public function alamat()
    {
        $karyawan = Karyawan::where('user_id', Auth::id())->firstOrFail();
        return view('content.backend.karyawan.alamat', compact('karyawan'));
    }
    /**
     * Memperbarui alamat karyawan.
     */
    public function updateAlamat(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'alamat_lengkap' => 'required',
        ]);

        $karyawan = Karyawan::where('user_id', Auth::id())->firstOrFail();

        $karyawan->update([
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'desa' => $request->desa,
            'alamat_lengkap' => $request->alamat_lengkap,
            'no_rumah' => $request->no_rumah,
            'kode_pos' => $request->kode_pos,
            'patokan' => $request->patokan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()
            ->route('karyawan.dashboard')
            ->with('success', 'Alamat berhasil disimpan');
    }
}