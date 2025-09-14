<?php

namespace App\Modules\UserManagement\Controllers;

use App\Core\Http\BaseCrudController;
use App\Modules\UserManagement\DTOs\Permission\PermissionDto;
use App\Modules\UserManagement\Requests\permission\create;
use App\Modules\UserManagement\Services\Interfaces\PermissionServiceInterface;
use Illuminate\Http\Request;

class PermissionController extends BaseCrudController
{
    protected string $viewPrefix = 'UserManagement::permission.';
    protected string $routePrefix = "permission.";
    protected string $entityName = "Permission";
    protected string $dtoClass = PermissionDto::class;
    protected $service;
    public function __construct(PermissionServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->prepareCommonData('Permission List');
        $data['records'] = $this->service->getAllPermission();

        return view($this->viewPrefix . 'index', ['data' => $data]);
    }

    public function create()
    {
        return $this->dataCreate();
    }

    public function store(create $request)
    {
        return $this->dataStore($request);
    }

    public function edit($id)
    {
        return $this->dataEdit($id);
    }

    public function update(create $request, $id)
    {
        return $this->dataUpdate($request, $id);
    }

    public function delete($id)
    {
        return $this->dataDelete($id);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }
}
