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
        Schema::create('diskon', function (Blueprint $table) {
            $table->id();
            $table->string('nama_diskon'); // contoh: Diskon Member, Promo Lebaran
            $table->enum('tipe', ['persentase', 'nominal']); // tipe diskon
            $table->decimal('nilai', 10, 2); // nilai diskon (misal: 10 = 10% atau 5000 = Rp 5000)
            $table->decimal('minimal_transaksi', 15, 2)->nullable(); // syarat minimal belanja
            $table->boolean('aktif')->default(true); // apakah diskon masih aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskon');
    }
};
