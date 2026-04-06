<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Karyawan;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Super Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );

        // 2. Create Owner
        User::updateOrCreate(
            ['email' => 'owner@gmail.com'],
            [
                'name' => 'Owner',
                'password' => Hash::make('12345678'),
                'role' => 'owner',
            ]
        );

        // 3. Create Jabatan
        $jabatanKasir = Jabatan::updateOrCreate(
            ['nama_jabatan' => 'Kasir'],
            ['deskripsi' => 'Pengelola transaksi dan keuangan di outlet.']
        );

        $jabatanDriver = Jabatan::updateOrCreate(
            ['nama_jabatan' => 'Driver'],
            ['deskripsi' => 'Petugas layanan antar-jemput cucian pelanggan.']
        );

        
    }
}
