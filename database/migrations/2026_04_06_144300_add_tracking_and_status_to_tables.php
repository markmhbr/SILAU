<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->decimal('driver_latitude', 10, 7)->nullable()->after('driver_id');
            $table->decimal('driver_longitude', 10, 7)->nullable()->after('driver_latitude');
        });

        // Update enum status menggunakan DB statement
        DB::statement("ALTER TABLE transaksi MODIFY COLUMN status ENUM(
            'menunggu penjemputan',
            'menuju lokasi penjemputan',
            'menunggu diantar',
            'diambil driver',
            'diterima kasir',
            'ditimbang',
            'menunggu pembayaran',
            'dibayar',
            'diproses',
            'selesai',
            'dibatalkan'
        ) DEFAULT 'menunggu penjemputan'");

        Schema::table('profil_perusahaan', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('alamat');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['driver_latitude', 'driver_longitude']);
        });

        DB::statement("ALTER TABLE transaksi MODIFY COLUMN status ENUM(
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
        ) DEFAULT 'menunggu penjemputan'");

        Schema::table('profil_perusahaan', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
