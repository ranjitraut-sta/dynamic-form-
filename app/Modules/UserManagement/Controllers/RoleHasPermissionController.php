<?php

namespace App\Modules\UserManagement\Controllers;

use App\Core\Http\BaseController;
use App\Modules\UserManagement\Repositories\Implementations\RoleRepository;
use App\Modules\UserManagement\Repositories\Interfaces\RoleHasPermissionRepositoryInterface;
use Illuminate\Http\Request;

class RoleHasPermissionController extends BaseController
{
    private $view;
    protected $repo, $roleRepo;
    public function __construct(RoleHasPermissionRepositoryInterface $repo, RoleRepository $roleRepo)
    {
        $this->view = 'UserManagement::role_has_permission';
        $this->repo = $repo;
        $this->roleRepo = $roleRepo;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'nullable|array',
            'permission_id.*' => 'exists:permissions,id',
        ]);

        $role = $this->roleRepo->findById($validated['role_id']);

        $permissions = $validated['permission_id'] ?? [];  // If null, use empty array

        $role->permissions()->sync($permissions);

        return redirect()->route('role.index')->with('success', 'Permissions successfully assigned to role.');
    }

}
