<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JamKerja;

class JamKerjaController extends Controller
{
    public function index()
    {
        $jamKerja = JamKerja::first() ?? new JamKerja(['jam_masuk' => '08:00', 'jam_keluar' => '17:00']);
        return view('content.backend.admin.jam-kerja.index', compact('jamKerja'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i',
        ]);

        $jamKerja = JamKerja::first();
        if ($jamKerja) {
            $jamKerja->update([
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
            ]);
        } else {
            JamKerja::create([
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
            ]);
        }

        return redirect()->back()->with('success', 'Jam Kerja berhasil diperbarui!');
    }
}
