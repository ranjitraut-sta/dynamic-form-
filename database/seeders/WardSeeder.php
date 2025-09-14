<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardSeeder extends Seeder
{
    public function run()
    {
        $wards = [];

        // Let's assume 1 to 20 wards
        for ($i = 1; $i <= 40; $i++) {
            $wards[] = ['name' => 'Ward No. ' . $i];
        }

        DB::table('wards')->insert($wards);
    }
}
