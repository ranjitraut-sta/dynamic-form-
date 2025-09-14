<?php
namespace App\Modules\UserManagement\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\UserManagement\Models\Role;
use App\Modules\UserManagement\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    protected $model;
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getRoleNameByRoleId($id)
    {
        return $this->model->find($id)->name;
    }

    public function getPermissionIdsByRoleId($id)
    {
        $permissions = DB::table('role_has_permission')
            ->where('role_id', $id)
            ->pluck('permission_id'); // Get the permission IDs for the role
        return $permissions;
    }
}
