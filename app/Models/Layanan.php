<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
     protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'harga_perkilo'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'layanan_id');
    }
}
