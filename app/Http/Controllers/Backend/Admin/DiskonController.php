<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $diskon = Diskon::all();
        return view('content.backend.admin.diskon.index', compact('diskon'));
    }

    public function create()
    {
        return view('content.backend.admin.diskon.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_diskon' => 'required|string',
            'tipe' => 'required|in:persentase,nominal',
            'nilai' => 'required|numeric|min:0',
            'minimal_transaksi' => 'required|numeric|min:0',
        ]);

        $validated['aktif'] = 0;

        // dd($request);
        Diskon::create($validated);
        return redirect()->route('admin.diskon.index')->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function edit(Diskon $diskon)
    {
        return view('content.backend.admin.diskon.form', compact('diskon'));
    }

    public function update(Request $request, Diskon $diskon)
    {
        $request->validate([
            'nama_diskon' => 'required|string',
            'tipe' => 'required|in:persentase,nominal',
            'nilai' => 'required|numeric|min:0',
            'minimal_transaksi' => 'required|numeric|min:0',
        ]);

        $diskon->update($request->all());
        return redirect()->route('admin.diskon.index')->with('success', 'Diskon berhasil diupdate.');
    }

    public function destroy(Diskon $diskon)
    {
        $diskon->delete();
        return redirect()->route('admin.diskon.index')->with('success', 'Diskon berhasil dihapus.');
    }

    public function toggleStatus($id)
{
    $diskon = Diskon::findOrFail($id);

    // Cast ke integer supaya aman
    $diskon->aktif = (int)$diskon->aktif === 0 ? 1 : 0;
    $diskon->save();

    return redirect()->back()->with('success', 'Status diskon berhasil diubah!');
}


}
