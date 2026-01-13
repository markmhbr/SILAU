<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('content.backend.admin.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('content.backend.admin.jabatan.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Jabatan::create($validated);
        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function edit(Jabatan $jabatan)
    {
        return view('content.backend.admin.jabatan.form', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $jabatan->update($validated);
        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan berhasil diperbarui!');
    }

    public function destroy(Jabatan $jabatan)
    {
        // Opsional: Cek dulu apakah ada karyawan di jabatan ini sebelum hapus
        if ($jabatan->karyawans()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus jabatan yang masih memiliki karyawan!');
        }

        $jabatan->delete();
        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan berhasil dihapus!');
    }
}
