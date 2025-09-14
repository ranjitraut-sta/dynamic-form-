<?php

namespace App\Modules\AuthManagement\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Modules\AuthManagement\Repositories\Interfaces\LoginRepositoryInterface;
use App\Modules\AuthManagement\Services\Interfaces\LoginServiceInterface;
use App\Modules\UserManagement\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class LoginService extends BaseService implements LoginServiceInterface
{
    protected $userRepository;
    public function __construct(LoginRepositoryInterface $repository, UserRepositoryInterface $userRepository)
    {
        parent::__construct($repository);
        $this->userRepository = $userRepository;
    }

    public function checkLoginCredential($request,$type)
    {
        return $this->handleLoginCheck($request, $type); // false = not an app user
    }

    private function handleLoginCheck($request, bool $expectedAppUser)
    {
        $result = $this->repository->checkLoginCredential($request);

        if ($result['status'] === 'fail') {
            return [
                'status' => 'fail',
                'message' => 'Credentials do not match.'
            ];
        }

        // Check if user type matches the expected type
        if ((bool) $result['is_app_user'] !== $expectedAppUser) {
            Auth::logout();

            return [
                'status' => 'fail',
                'message' => 'You are not authorized to log in via this platform.'
            ];
        }

        // Store last login time
        if (!empty($result['id'])) {
            $this->userRepository->keepLastLogin($result['id']);
        }

        return [
            'status' => 'success',
            'message' => 'Welcome to the system.'
        ];
    }

}
