<?php

        namespace App\Modules\DashboardManagement\Database\Seeders;

        use Illuminate\Database\Seeder;
        use App\Modules\DashboardManagement\Database\Seeders\DashboardManagementSeeder;

        class DatabaseSeeder extends Seeder
        {
            public function run(): void
            {
                $this->call([
                    DashboardManagementSeeder::class,
                ]);
            }
        }