<?php

namespace App\Modules\DashboardManagement\Controllers;

use App\Core\Http\BaseController;
use App\Modules\DashboardManagement\Services\Interfaces\DashboardManagementServiceInterface;

class DashboardManagementController extends BaseController
{
    protected $service;

    public function __construct(DashboardManagementServiceInterface $service)
    {
        $this->service = $service;
    }

    public function AdminLayout()
    {
        $data = $this->prepareCommonData('Dashboard Management');

        return view('dashboardmanagement::index', ['data' => $data]);
    }
}
