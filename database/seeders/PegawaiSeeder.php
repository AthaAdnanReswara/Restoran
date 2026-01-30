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
        // create a staff account if email not already used (role set to admin)
        if (!User::where('email', 'pegawai@gmail.com')->exists()) {
            User::create([
                'name' => 'pegawai',
                'email' => 'pegawai@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
            ]);
        }
    }
}
