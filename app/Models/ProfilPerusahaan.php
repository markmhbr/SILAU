<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilPerusahaan extends Model
{

    // kasih tau ke Laravel nama tabelnya
    protected $table = 'profil_perusahaan';
    protected $fillable = [
        'nama_perusahaan',
        'deskripsi',
        'alamat',
        'no_wa',
        'email',
        'instagram',
        'facebook',
        'tiktok',
        'youtube',
        'logo',
        'service_hours',
        'fast_response',
        'tentang_kami',
    ];
}