<?php

namespace App\Core\Services\Implementation;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AccessService
{
    public function userHasPermission(User $user, string $controller, string $action): bool
    {
        $permission = DB::table('permissions')
            ->where('controller', $controller)
            ->where('action', $action)
            ->first();

        if (!$permission) {
            return false;
        }

        return DB::table('role_has_permission')
            ->where('role_id', $user->role_id)
            ->where('permission_id', $permission->id)
            ->exists();
    }
}
