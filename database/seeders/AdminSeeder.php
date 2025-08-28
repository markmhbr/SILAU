<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->insert([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('123456'), // password default
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
