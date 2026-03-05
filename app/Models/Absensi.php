<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status',
        'keterangan',
        'foto_bukti',
        'latitude',
        'longitude',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
