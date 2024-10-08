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
            'mobile_number' => '0313-0535333',
            'landline_number' => '0944-880250',
            'designation' => 'Assistant Director IT',
            'cnic' => '15701-2490811-7',
            'office' => 'IT',
            'is_active' => 1,
            'is_suspended' => 0,
            'email_verified_at' => fake()->dateTime,
            'password_updated_at' => fake()->dateTime,
            'password' => bcrypt('password'),
        ]);

        User::factory(100)->create();
    }
}
