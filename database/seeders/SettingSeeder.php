<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Create an admin user
        Setting::create([
            'site_name' => 'Software House',
            'email' => 'superadmin@gmail.com',
            'phone' => '9810203040',
            'address' => 'Kathamandu Nepal',
        ]);
    }
}
