<?php

// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call other seeders here
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            SettingSeeder::class,
            CountriesTableSeeder::class,
            ProvinceSeeder::class,
            DistrictSeeder::class,
            MunicipalitySeeder::class,
            WardSeeder::class
        ]);
    }
}
