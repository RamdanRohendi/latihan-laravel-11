<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 1000000; $i++) {
            $user = new User();
            $user->name = 'User ' . $i;
            $user->email = 'user' . $i . '@example.com';
            $user->password = '12345';
            $user->save();
        }
    }
}
