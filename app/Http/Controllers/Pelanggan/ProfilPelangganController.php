<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;

class ProfilPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Ambil pelanggan yang login
        $pelanggan = Pelanggan::where('user_id', auth()->id())->first();

        return view('content.backend.pelanggan.profile', compact('pelanggan'));
    }

    public function alamat()
    {
        // Ambil pelanggan yang login
        $pelanggan = Pelanggan::where('user_id', auth()->id())->first();

        return view('content.backend.pelanggan.alamat', compact('pelanggan'));
    }

    public function updateAlamat(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'alamat_lengkap' => 'required',
        ]);

        $pelanggan = Pelanggan::where('user_id', Auth::id())->firstOrFail();

        $pelanggan->update([
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
            ->route('pelanggan.dashboard')
            ->with('success', 'Alamat berhasil disimpan');
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
    public function update(Request $request)
    {
        try {

            $pelanggan = Pelanggan::where('user_id', auth()->id())->first();

            // Validasi input
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'no_hp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
            ]);

            // Update user (nama)
            $pelanggan->user->update([
                'name' => $validated['nama'],
            ]);

            // Update pelanggan (no_hp dan alamat)
            $pelanggan->update([
                'no_hp' => $validated['no_hp'] ?? "",
                'alamat' => $validated['alamat'] ?? "",
            ]);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $path = $file->store('foto', 'public');

                // hapus foto lama jika ada
                if ($pelanggan->foto) {
                    Storage::disk('public')->delete($pelanggan->foto);
                }

                $pelanggan->foto = $path ?? "";
                $pelanggan->save();
            }

            return redirect()->route('pelanggan.profil.index')->with('success', 'Data berhasil diperbarui!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
