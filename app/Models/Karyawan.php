<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Karyawan extends Model
{
    use HasFactory;

    // Nama tabel secara default adalah 'karyawans' (jamak), 
    // namun jika kamu ingin eksplisit, bisa aktifkan baris di bawah:
    // protected $table = 'karyawans';

    protected $fillable = [
        'user_id',
        'jabatan_id',
        'foto',
        'no_hp',
        'provinsi',
        'kota',
        'kecamatan',
        'desa',
        'alamat_lengkap',
        'no_rumah',
        'kode_pos',
        'patokan',
        'latitude',
        'longitude',
        'tanggal_masuk',
        'status_kerja',
    ];

    /**
     * Casting tipe data agar lebih mudah dikelola.
     */
    protected $casts = [
        'tanggal_masuk' => 'date',
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Jabatan
     */
    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class);
    }

    /**
     * Accessor untuk mendapatkan URL foto profil
     * Panggil di Blade: $karyawan->foto_url
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        
        return asset('images/default-avatar.png');
    }

    /**
     * Accessor untuk mendapatkan alamat lengkap yang rapi
     * Panggil di Blade: $karyawan->alamat_gabungan
     */
    public function getAlamatGabunganAttribute()
    {
        $alamat = $this->alamat_lengkap;
        
        if ($this->no_rumah) $alamat .= " No. " . $this->no_rumah;
        if ($this->desa) $alamat .= ", Desa/Kel. " . $this->desa;
        if ($this->kecamatan) $alamat .= ", Kec. " . $this->kecamatan;
        if ($this->kota) $alamat .= ", " . $this->kota;
        if ($this->provinsi) $alamat .= ", " . $this->provinsi;
        if ($this->kode_pos) $alamat .= " (" . $this->kode_pos . ")";

        return $alamat;
    }

    // Rencana Relasi ke Absensi ke depannya
    /*
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
    */
}