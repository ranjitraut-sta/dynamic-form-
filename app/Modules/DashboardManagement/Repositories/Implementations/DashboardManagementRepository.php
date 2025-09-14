<?php

        namespace App\Modules\DashboardManagement\Repositories\Implementations;

        use App\Modules\DashboardManagement\Repositories\Interfaces\DashboardManagementRepositoryInterface;

        class DashboardManagementRepository implements DashboardManagementRepositoryInterface
        {
            public function getAll()
            {
                return []; // return model::all() later
            }
        }