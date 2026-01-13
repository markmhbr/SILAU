<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    
    protected $table = 'transaksi';

    protected $fillable = [
        'diskon_id',
        'pelanggan_id',
        'layanan_id',
        'tanggal_masuk',
        'tanggal_selesai',
        'status',
        'berat',
        'harga_total',
        'harga_setelah_diskon',
        'metode_pembayaran',
        'bukti_bayar',
        'catatan'
    ];

    // Tambahkan ini agar tanggal bisa di-format
    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_selesai' => 'datetime',
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

    // Relasi ke diskon (opsional)
    public function diskon()
    {
        return $this->belongsTo(Diskon::class);
    }

    public function hargaSetelahDiskon()
    {
        if ($this->diskon) {
            if ($this->diskon->tipe === 'persen') {
                return $this->harga_total - ($this->harga_total * $this->diskon->nilai / 100);
            } elseif ($this->diskon->tipe === 'nominal') {
                return max(0, $this->harga_total - $this->diskon->nilai);
            }
        }
        return $this->harga_total;
    }

}
