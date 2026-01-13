<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Jabatan; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('user', 'jabatan')->get();
        // Ambil semua jabatan untuk isi dropdown di form
        $jabatans = Jabatan::all();

        return view('content.backend.admin.karyawan.index', compact('karyawans', 'jabatans'));
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        return view('content.backend.admin.karyawan.form', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'jabatan_id' => 'required|exists:jabatans,id', // Validasi jabatan
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'karyawan',
            ]);

            Karyawan::create([
                'user_id' => $user->id,
                'jabatan_id' => $validated['jabatan_id'], // Masukkan jabatan pilihan admin
                'status_kerja' => 'aktif', // Default status
                'tanggal_masuk' => now(), // Default tanggal masuk
            ]);

            return redirect()->back()->with('success', 'Akun karyawan berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
