<?php

namespace App\Modules\UserManagement\Controllers;

use App\Core\Http\BaseCrudController;
use App\Modules\UserManagement\DTOs\Role\RoleDto;
use App\Modules\UserManagement\Repositories\Implementations\PermissionRepository;
use App\Modules\UserManagement\Requests\role\create;
use App\Modules\UserManagement\Services\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class RoleController extends BaseCrudController
{
    protected string $viewPrefix = 'UserManagement::role.';
    protected string $routePrefix = 'role.';
    protected string $entityName = 'Role';
    protected string $dtoClass = RoleDto::class;
    protected $service, $permissionRepo;
    public function __construct(RoleServiceInterface $service, PermissionRepository $permissionRepo)
    {
        $this->service = $service;
        $this->permissionRepo = $permissionRepo;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('length') ?? config('usermanagement.role', 10);
        $searchTerm = $request->input('search');

        return parent::dataIndex($perPage, $searchTerm);
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

    public function updateOrder(Request $request)
    {
        return $this->updateOrderInternal($request, 'roles', 'id', 'display_order');
    }

    public function addPermission($id)
    {
        $data = $this->prepareCommonData('Add Permission');
        $data['RoleId'] = $id;

        $data['permissions'] = $this->permissionRepo->getAllPermission();

        $data['getRollName'] = $this->service->getRoleNameByRoleId($id); // Get the role name

        // Get the permission IDs and convert to an array
        $data['roleHasPermissions'] = $this->service->getPermissionIdsByRoleId($id);// Fetch permission IDs for the role

        return view($this->viewPrefix . '.add-permission', ['data' => $data]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }

}
