<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;


class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dari = $request->query('dari_tanggal');    
        $sampai = $request->query('sampai_tanggal');

        $transaksi = collect();

        if ($dari && $sampai) {
           $transaksi = Transaksi::whereBetween('tanggal_masuk', [$dari, $sampai])
            ->orderBy('tanggal_masuk', 'asc')
            ->get();
                
        }

        return view('content.backend.admin.laporan.index', compact('transaksi', 'dari', 'sampai'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
