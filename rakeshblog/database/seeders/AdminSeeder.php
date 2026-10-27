<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@rakeshrajbhat.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('p@ssw0rdA123'),
                'is_active' => true,
            ],
        );

        // You can add more admins here
        // Admin::create([
        //     'name' => 'Editor',
        //     'email' => 'editor@rakeshrajbhat.com',
        //     'password' => Hash::make('editor123'),
        //     'is_active' => true,
        // ]);
    }
}