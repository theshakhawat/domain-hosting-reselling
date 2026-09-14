<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@nexus.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'status' => true,
                'phone_number' => '+880 9610-NEXUS',
            ]
        );
    }
}
