<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            
            // Kolom Audit Kasir: Nullable jika pelanggan pesan sendiri via apps
            $table->foreignId('id_karyawan')
                  ->nullable()
                  ->constrained('karyawans')
                  ->onDelete('set null');
                
            // Kolom Pelanggan: Nullable jika Guest (Tanpa Member)
            $table->foreignId('pelanggan_id')
                  ->nullable()
                  ->constrained('pelanggan')
                  ->onDelete('set null');
                
            // Relasi Layanan & Diskon
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->foreignId('diskon_id')->nullable()->constrained('diskon')->onDelete('set null');
                
            // Detail Waktu
            $table->dateTime('tanggal_masuk');
            $table->dateTime('tanggal_selesai')->nullable();
            
            // Status & Data Fisik
            $table->string('status')->default('pending'); // pending, proses, selesai, diambil, batal
            $table->decimal('berat', 8, 2);              // Max 999,99 kg
            
            // Keuangan
            $table->decimal('harga_total', 12, 2);       // Harga asli sebelum diskon
            $table->decimal('harga_setelah_diskon', 12, 2); // Harga final yang dibayar
            
            // Pembayaran & Metadata
            $table->string('metode_pembayaran');         // tunai, qris
            $table->string('snap_token')->nullable();    // Untuk integrasi Midtrans
            $table->text('catatan')->nullable();
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};