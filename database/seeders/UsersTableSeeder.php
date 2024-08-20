<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'COD_PERSONAS' => 18,
            'COD_ROL' => 1,
            'name' => 'SuperAdmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('SuperA_24'),
            'is_superuser' => true,
            'email_verified_at' => now(),
        ]);
    }
}
