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
                'nama_perusahaan' => 'Nama Usaha Demo',
                'deskripsi' => 'Deskripsi singkat tentang usaha demo.',
                'tentang_kami' => 'Tentang kami demo.',
                'alamat' => 'Jl. Contoh No. 123, Kota Demo',
                'no_wa' => '628123456789',
                'service_hours' => 'Senin - Sabtu, 08:00 - 17:00',
                'fast_response' => '1-2 jam',
                'email' => 'demo@email.com',
                'instagram' => 'demo_ig',
                'facebook' => 'demo_fb',
                'tiktok' => 'demo_tt',
                'youtube' => 'https://youtube.com/demo',
                'logo' => null,
            ]
        );
    }
}
