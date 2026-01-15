<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opsi 2: Menggunakan Insert (Lebih cepat untuk banyak data sekaligus)
        Jabatan::insert([
            ['nama_jabatan' => 'Kasir'],
            ['nama_jabatan' => 'Driver'],
        ]);
    }
}
