<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    protected $table = 'diskon';

    protected $fillable = [
        'nama_diskon',
        'tipe',
        'nilai',
        'minimal_transaksi',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'diskon_id');
    }

    
}
