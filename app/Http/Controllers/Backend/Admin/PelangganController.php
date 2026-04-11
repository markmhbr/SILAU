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
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ], [
                'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain!',
                'password.min' => 'Password minimal 6 karakter.',
            ]);

            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'pelanggan',
            ]);

            Pelanggan::create([
                'user_id' => $user->id,
            ]);

            return redirect()->route('admin.pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['error' => $th->getMessage()]);
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
        $pelanggan = Pelanggan::with('user')->findOrFail($id);
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
            'email' => 'required|email|unique:users,email,' . $pelanggan->user_id,
        ]);

        if ($pelanggan->user) {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email
            ];
            
            if ($request->filled('password')) {
                $request->validate(['password' => 'string|min:6']);
                $updateData['password'] = bcrypt($request->password);
            }
            
            $pelanggan->user->update($updateData);
        }

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
