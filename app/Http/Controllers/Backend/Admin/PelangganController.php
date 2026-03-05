<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('content.backend.admin.pelanggan.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.backend.admin.pelanggan.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|unique:users,email',
                'no_hp' => 'required|string|max:15',
                'alamat' => 'required|string',
            ]);

            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email ?? strtolower(str_replace(' ', '', $request->name)) . rand(100, 999) . '@laundry.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
            ]);

            Pelanggan::create([
                'user_id' => $user->id,
                'no_hp' => $request->no_hp,
                'alamat_lengkap' => $request->alamat,
            ]);

            return redirect()->route('admin.pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
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
        $pelanggan = Pelanggan::findOrFail($id);
        return view('content.backend.admin.pelanggan.form', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        if ($pelanggan->user) {
            $updateData = ['name' => $request->name];
            if ($request->email) {
                $updateData['email'] = $request->email;
                $request->validate(['email' => 'email|unique:users,email,' . $pelanggan->user_id]);
            }
            $pelanggan->user->update($updateData);
        }

        $pelanggan->update([
            'no_hp' => $request->no_hp,
            'alamat_lengkap' => $request->alamat,
        ]);

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data pelanggan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $userId = $pelanggan->user_id;
        $pelanggan->delete();

        if ($userId) {
            \App\Models\User::find($userId)?->delete();
        }

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data berhasil dihapus!');
    }
}
