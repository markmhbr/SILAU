<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jabatan_id',
        'no_hp',
        'alamat',
        'tanggal_masuk',
        'status_kerja',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    // Relasi ke absensi (NANTI)
    // public function absensis()
    // {
    //     return $this->hasMany(Absensi::class);
    // }
}
