<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'role' => 0, // Admin
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily@example.com',
                'role' => 1,
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Sophia Taylor',
                'email' => 'sophia@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Daniel Anderson',
                'email' => 'daniel@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Olivia Thomas',
                'email' => 'olivia@example.com',
                'role' => 1,
            ],
            [
                'name' => 'James Jackson',
                'email' => 'james@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Lucas White',
                'email' => 'lucas@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Mia Harris',
                'email' => 'mia@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Ethan Martin',
                'email' => 'ethan@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Isabella Thompson',
                'email' => 'isabella@example.com',
                'role' => 1,
            ],
            [
                'name' => 'Noah Garcia',
                'email' => 'noah@example.com',
                'role' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'phone' => '01' . rand(300000000, 999999999),
                'role' => $user['role'],
                'email_verified_at' => now(),
                'password' => Hash::make('asdfg@1234'),
                'remember_token' => Str::random(10),
                'otp' => rand(100000, 999999),
                'otp_expires_at' => Carbon::now()->addMinutes(10),
            ]);
        }
    }
}