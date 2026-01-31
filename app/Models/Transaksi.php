<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{

    protected $table = 'transaksi';

    protected $fillable = [
        'order_id',
        'pelanggan_id',
        'driver_id',       // Di migration namanya driver_id, bukan id_karyawan
        'kasir_id',        // Di migration namanya kasir_id
        'layanan_id',
        'diskon_id',
        'cara_serah',      // Tambahkan ini karena ada di migration
        'estimasi_berat',  // Gunakan estimasi_berat, bukan berat
        'berat_aktual',
        'harga_estimasi',  // Gunakan ini untuk harga awal
        'harga_final',
        'metode_pembayaran',
        'snap_token',
        'paid_at',
        'status',
        'catatan'
    ];

    // Tambahkan ini agar tanggal bisa di-format
    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    // Relasi ke karyawan (opsional)
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
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
