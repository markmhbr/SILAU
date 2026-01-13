<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jabatan',
        'deskripsi',
    ];

    // Relasi ke karyawan
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}
