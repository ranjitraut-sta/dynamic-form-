<?php

namespace App\Modules\AuthManagement\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Models\User;
use App\Modules\AuthManagement\Repositories\Interfaces\LoginRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginRepository extends BaseRepository implements LoginRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function checkLoginCredential($request): array
    {
        $status = 'fail';
        $credentials = $request->only('name', 'password', 'remember');
        $credentials['name'] = trim($credentials['name']);

        $fieldType = filter_var($credentials['name'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $remember = $request->has('remember') ? true : false;

        if (Auth::attempt([$fieldType => $credentials['name'], 'password' => $credentials['password'],'status'=> true],  $remember)) {

            $user = Auth::user();

            // Optional: You could eager-load role if using a relationship instead of DB query
            $role = DB::table('roles')->where('id', $user->role_id)->first();

            if ($user->role_id == $role->id ) {
                $status = 'success';
                return [
                    'status' => $status,
                    'is_app_user' => $user->is_app_user,
                    'id' => $user->id,
                    'route' => 'adminLayout',
                    'message' => 'Welcome To Admin Login'
                ];
            }
        }

        return [
            'status' => $status,
        ];
    }

}
