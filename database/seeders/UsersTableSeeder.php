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
                'password' => Hash::make('Hhsni29'),
                'alamat' => 'Jalan Pahlawan No. 123',
                'nomor_telpon' => '08123456789',
                'roles' => 'admin',
                'jenis_kelamin' => 'L',
                // 'photo_profile' => 'default.jpg', // Anda bisa menambahkan ini jika perlu
            ],
            // Tambahkan data pengguna lainnya sesuai kebutuhan
        ];

        // Looping untuk memasukkan data ke dalam database
        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
