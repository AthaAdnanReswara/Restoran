<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //cek apakah Pegawai sudah ada
        if (!User::where('role', 'pegawai')->exists()) {
            User::create([
                'name' => 'pegawai',
                'email' => 'pegawai@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'pegawai',
            ]);
        }
    }
}
