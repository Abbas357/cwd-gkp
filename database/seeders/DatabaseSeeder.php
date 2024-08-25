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
        User::factory()->create([
            'name' => 'Abbas Khan',
            'email' => 'abbaskhan357@gmail.com',
            'password' => bcrypt('password'),
        ]);

        User::factory(1000)->create();
    }
}
