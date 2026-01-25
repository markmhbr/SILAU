<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPerusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilPerusahaanController extends Controller
{
    public function index()
    {
        
        $profil = ProfilPerusahaan::first() ?? new ProfilPerusahaan;
        return view('content.backend.admin.profile.index', compact('profil'));
    }

     public function update(Request $request)
    {
        // 1. Validasi yang lebih lengkap
        $validatedData = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_wa' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'youtube' => 'nullable|url|max:255',
            'service_hours' => 'nullable|string|max:255',
            'fast_response' => 'nullable|string|max:255',
            'tentang_kami' => 'nullable|string',
            'video_profil' => 'nullable|string|max:255',
        ]);

        // Mengambil data profil atau membuat baru jika belum ada
        $profil = ProfilPerusahaan::firstOrNew();

        // 2. Logika upload logo (tetap sama, sudah bagus)
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($profil->logo && file_exists(public_path('logo/' . $profil->logo))) {
                unlink(public_path('logo/' . $profil->logo));
            }
        
            // Upload baru
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('logo'), $filename);
            $validatedData['logo'] = $filename;
        }



        // 3. Menggunakan Mass Assignment (lebih bersih dan efisien)
        // Cukup isi model dengan semua data yang sudah tervalidasi
        $profil->fill($validatedData);
        
        // 4. Simpan ke database
        $profil->save();

        return redirect()->back()->with('success', 'Profil usaha berhasil diperbarui.');
    }
}
