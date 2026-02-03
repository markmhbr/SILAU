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

    // Relasi ke Pelanggan
    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    // Relasi ke Layanan
    public function layanan() {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    // Relasi ke Diskon
    public function diskon() {
        return $this->belongsTo(Diskon::class, 'diskon_id');
    }

    // Relasi Spesifik Karyawan
    public function driver() {
        return $this->belongsTo(Karyawan::class, 'driver_id');
    }

    public function kasir() {
        return $this->belongsTo(Karyawan::class, 'kasir_id');
    }

    // Method untuk menghitung harga setelah diskon
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
