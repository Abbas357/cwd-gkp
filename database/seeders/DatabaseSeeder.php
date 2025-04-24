<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Abbas Khan',
            'username' => 'abbas',
            'email' => 'abbaskhan357@gmail.com',
            'password' => bcrypt('password'),
            'mobile_number' => '0313-0535333',
            'contact_number' => '0944-880250',
            'designation' => 'Assistant Director IT',
            'cnic' => '15701-2490811-7',
            'office' => 'IT',
            'status' => 'Active',
            'password_updated_at' => fake()->dateTime,
            'password' => bcrypt('password'),
        ]);

        Setting::factory()->create([
            'site_name' => 'Communication & Works Department, KP',
            'description' => 'Communications & Works Department was established in 1979. Since establishment the Department is working to promote safe, sustainable, cost effective and environment friendly road infrastructure leading to socio-economic development.',
            'email' => 'cwd.gkp@gmail.com',
            'maintenance_mode' => 0,
            'contact_phone' => '091-9214039',
            'contact_address' => 'Civil Secretariat, Peshawar',
            'whatsapp' => '03130535333',
            'facebook' => 'CWDKPGovt',
            'twitter' => 'CWDKPGovt',
            'youtube' => 'CWDKPGovt',
            'meta_description' => 'Communications & Works Department was established in 1979. Since establishment the Department is working to promote safe, sustainable, cost effective and environment friendly road infrastructure leading to socio-economic development.',
            'secret_key' => 'abbas',
        ]);
    }
}
