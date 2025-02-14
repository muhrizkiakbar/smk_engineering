<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Test User',
            'username' => 'test',
            'email' => 'test@example.com',
            'password' => 'diskominfo'
        ]);

        User::create([
            'name' => 'Adaro',
            'username' => 'adaro',
            'email' => 'adaro@example.com',
            'password' => 'diskominfo',
            'type_user' => 'adaro'
        ]);
    }
}
