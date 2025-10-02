<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanans = [
            [
                'nama_layanan' => 'Cuci Biasa',
                'deskripsi'     =>  'Cuci Bersih dan Wangi',
                'harga_perkilo' => 5000,
            ],
            [
                'nama_layanan' => 'Cuci Regular',
                'deskripsi'     =>  'Cuci bersih dengan deterjen premium dan pengeringan sempurna',
                'harga_perkilo' => 7000,
            ],
            [
                'nama_layanan' => 'Cuci Express',
                'deskripsi'     =>  'Selesai dalam 6 jam dengan prioritas khusus',
                'harga_perkilo' => 10000,
            ],
            [
                'nama_layanan' => 'Setrikas Saja',
                'deskripsi'     =>  'Setrika rapi dan profesional untuk pakaian Anda',
                'harga_perkilo' => 4000,
            ],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create(array_merge($layanan, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

}
