<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Contoh data dummy pengguna
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'alamat' => 'Jalan Pahlawan No. 123',
                'nomor_telpon' => '08123456789',
                'roles' => 'admin',
                'jenis_kelamin' => 'L',
            ],
        ];

        // Looping untuk memasukkan data ke dalam database
        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
