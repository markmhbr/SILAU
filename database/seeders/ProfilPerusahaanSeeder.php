<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilPerusahaan;

class ProfilPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfilPerusahaan::updateOrCreate(
            ['id' => 1], // pastikan cuma satu data
            [
                'nama_perusahaan' => 'Silau',
                'deskripsi' => 'Deskripsi singkat tentang usaha demo.',
                'tentang_kami' => 'Tentang kami ...',
                'alamat' => 'Smk Nurul Islam Affandiyah Cianjur',
                'no_wa' => '089639011628',
                'service_hours' => 'Senin - Sabtu, 08:00 - 17:00',
                'fast_response' => '1-2 jam',
                'email' => 'silau@email.com',
                'instagram' => 'demo_ig',
                'facebook' => 'demo_fb',
                'tiktok' => 'demo_tt',
                'youtube' => 'https://youtube.com/demo',
                'logo' => null,
            ]
        );
    }
}
