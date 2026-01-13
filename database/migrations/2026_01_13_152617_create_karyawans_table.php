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

            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
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

