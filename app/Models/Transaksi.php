<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    
    protected $table = 'transaksi';

    protected $fillable = [
        'pelanggan_id',
        'layanan_id',
        'tanggal_masuk',
        'tanggal_selesai',
        'status',
        'berat',
        'harga_total',
        'metode_pembayaran',
        'bukti_bayar',
        'catatan'
    ];

    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi ke layanan (opsional)
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
