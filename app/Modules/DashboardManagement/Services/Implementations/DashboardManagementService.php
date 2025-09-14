<?php

        namespace App\Modules\DashboardManagement\Services\Implementations;

        use App\Modules\DashboardManagement\Services\Interfaces\DashboardManagementServiceInterface;
        use App\Modules\DashboardManagement\Repositories\Interfaces\DashboardManagementRepositoryInterface;

        class DashboardManagementService implements DashboardManagementServiceInterface
        {
            protected $repo;

            public function __construct(DashboardManagementRepositoryInterface $repo)
            {
                $this->repo = $repo;
            }

            public function getAll()
            {
                return $this->repo->getAll();
            }
        }