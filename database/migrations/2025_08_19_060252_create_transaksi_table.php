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

            // Relasi ke tabel admin
            $table->foreignId('admin_id')->constrained('admin')->onDelete('cascade');

            // Relasi ke tabel layanan
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');

            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai')->nullable();
            $table->string('status')->default('proses'); // misal: proses, selesai, batal

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
