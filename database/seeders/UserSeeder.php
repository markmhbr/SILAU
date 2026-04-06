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

        // 4. Create Karyawan - KASIR
        $userKasir = User::updateOrCreate(
            ['email' => 'karyawan@gmail.com'],
            [
                'name' => 'Karyawan Kasir',
                'password' => Hash::make('12345678'),
                'role' => 'karyawan',
            ]
        );

        Karyawan::updateOrCreate(
            ['user_id' => $userKasir->id],
            [
                'jabatan_id' => $jabatanKasir->id,
                'tanggal_masuk' => now(),
                'status_kerja' => 'aktif',
                'no_hp' => '08123456789',
            ]
        );

        // 5. Create Karyawan - DRIVER
        $userDriver = User::updateOrCreate(
            ['email' => 'driver@gmail.com'],
            [
                'name' => 'Karyawan Driver',
                'password' => Hash::make('12345678'),
                'role' => 'karyawan',
            ]
        );

        Karyawan::updateOrCreate(
            ['user_id' => $userDriver->id],
            [
                'jabatan_id' => $jabatanDriver->id,
                'tanggal_masuk' => now(),
                'status_kerja' => 'aktif',
                'no_hp' => '08987654321',
            ]
        );
    }
}
