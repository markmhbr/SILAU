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
            $table->string('order_id')->nullable()->unique();

            // Relasi utama
            $table->foreignId('pelanggan_id')->nullable()
                ->constrained('pelanggan')->onDelete('set null');

            $table->foreignId('driver_id')->nullable()
                ->constrained('karyawans')->onDelete('set null');

            $table->foreignId('kasir_id')->nullable()
                ->constrained('karyawans')->onDelete('set null');

            $table->foreignId('layanan_id')->constrained('layanan');
            $table->foreignId('diskon_id')->nullable()->constrained('diskon');

            // Cara serah
            $table->enum('cara_serah', ['jemput', 'antar']);

            // Berat
            $table->decimal('estimasi_berat', 8, 2);
            $table->decimal('berat_aktual', 8, 2)->nullable();

            // Harga
            $table->decimal('harga_estimasi', 12, 2);
            $table->decimal('harga_final', 12, 2)->nullable();

            // Pembayaran
            $table->enum('metode_pembayaran', ['tunai', 'qris']);
            $table->string('snap_token')->nullable();
            $table->timestamp('paid_at')->nullable();

            // Status workflow
            $table->enum('status', [
                'menunggu penjemputan',
                'menunggu diantar',
                'diambil driver',
                'diterima kasir',
                'ditimbang',
                'menunggu pembayaran',
                'dibayar',
                'diproses',
                'selesai',
                'dibatalkan'
            ])->default('menunggu penjemputan');

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
