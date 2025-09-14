<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Province::create(['name' => 'Koshi Province']);
        Province::create(['name' => 'Madhesh Province']);
        Province::create(['name' => 'Bagmati Province']);
        Province::create(['name' => 'Gandaki Province']);
        Province::create(['name' => 'Lumbini Province']);
        Province::create(['name' => 'Karnali Province']);
        Province::create(['name' => 'Sudurpachhim Province']);
    }
}
