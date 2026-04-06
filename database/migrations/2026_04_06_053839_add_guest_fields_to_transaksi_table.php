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
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('nama_guest')->nullable()->after('pelanggan_id');
            $table->string('no_hp_guest')->nullable()->after('nama_guest');
            $table->string('waktu_ambil')->nullable()->after('no_hp_guest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['nama_guest', 'no_hp_guest', 'waktu_ambil']);
        });
    }
};
