<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();

            // Relasi ke users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Relasi ke jabatan
            $table->foreignId('jabatan_id')
                  ->constrained('jabatans');


            $table->string('foto')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();

            $table->text('alamat_lengkap')->nullable();

            $table->string('no_rumah')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('patokan')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->date('tanggal_masuk');

            $table->enum('status_kerja', [
                'aktif',
                'cuti',
                'resign'
            ])->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};

