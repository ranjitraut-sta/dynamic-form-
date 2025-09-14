<?php

namespace App\Modules\UserManagement\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\UserManagement\Models\User;
use App\Modules\UserManagement\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUsers()
    {
        $users = DB::table('users')
        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->select('users.id','users.name','users.last_login','users.email','users.status','roles.name as role_name')
        ->get();
        return $users;
    }

    public function keepLastLogin($userId)
    {
        DB::table('users')->where('id', $userId)->update(['last_login' => now()]);
    }
}
