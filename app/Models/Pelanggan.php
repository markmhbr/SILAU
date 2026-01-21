<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'user_id',
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
    ];

    /**
     * Casting tipe data koordinat agar menjadi angka (float/double)
     */
    protected $casts = [
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
     * Relasi ke Transaksi
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id');
    }

    /**
     * Get Foto URL
     * Memudahkan pemanggilan foto di frontend/view
     * Contoh: $pelanggan->foto_url
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        
        // Return avatar default jika tidak ada foto
        return asset('images/default-pelanggan.png'); 
    }

    /**
     * Get Alamat Lengkap Terformat
     * Menggabungkan semua komponen alamat menjadi satu string rapi
     * Contoh: $pelanggan->alamat_gabungan
     */
    public function getAlamatGabunganAttribute()
    {
        $alamat = $this->alamat_lengkap;
        
        if ($this->no_rumah) $alamat .= " No. " . $this->no_rumah;
        if ($this->desa) $alamat .= ", Desa/Kel. " . $this->desa;
        if ($this->kecamatan) $alamat .= ", Kec. " . $this->kecamatan;
        if ($this->kota) $alamat .= ", Kab. " . $this->kota;
        if ($this->provinsi) $alamat .= ", Prov. " . $this->provinsi;
        if ($this->kode_pos) $alamat .= " (" . $this->kode_pos . ")";

        return $alamat;
    }
}