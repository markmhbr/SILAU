<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    protected $fillable = [
        'user_id',
        'foto',
        'no_hp',

        // Wilayah
        'provinsi',
        'kota',
        'kecamatan',
        'desa',

        // Alamat detail
        'alamat_lengkap',
        'no_rumah',
        'kode_pos',
        'patokan',

        // Koordinat
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id');
    }
}
