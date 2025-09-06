<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
                
            // Relasi ke tabel pelanggan
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
                
            // Relasi ke tabel layanan
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');

            // Relasi ke tabel diskon (opsional)
            $table->foreignId('diskon_id')->nullable()->constrained('diskon')->onDelete('set null');
                
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai')->nullable();
            $table->string('status'); // proses, selesai, batal
                
            $table->decimal('berat', 5, 2);              // berat cucian dalam kg
            $table->decimal('harga_total', 10, 2);       // total harga = berat * harga_per_kilo
            $table->decimal('harga_setelah_diskon', 10, 2)->nullable(); // harga setelah diskon

            $table->string('metode_pembayaran')->nullable(); // tunai, transfer, e-wallet
            $table->string('bukti_bayar')->nullable();       // nama file bukti bayar
            $table->string('catatan')->nullable();           // catatan khusus
                
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
