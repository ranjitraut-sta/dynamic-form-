<?php

namespace App\Modules\AuthManagement\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Modules\AuthManagement\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function sendResetLink($email)
    {
        $user = $this->model->where('email', $email)->first();

        // Check if user exists
        if (!$user) {
            return false;
        }

        // Generate token
        $token = $this->generateToken();

        // Save token in password_resets table
        $this->updateInPasswordResetsTable($user, $token);

        // Check again before sending (optional but redundant here)
        if (!$user || !$token) {
            return false;
        }

        // Send the email
        $this->sendResetLinkEmail($user, $token);

        return true; // Final return
    }


    private function generateToken()
    {
        return Str::random(64);
    }

    private function sendResetLinkEmail($user, $token)
    {
        Mail::to($user->email)->send(new ResetPasswordMail($token, $user->email));
    }

    private function updateInPasswordResetsTable($user, $token)
    {
        //if already exist that user email cheked first
        // in password_resets tabble and that token is not expired then return false to means that token already sent
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );
    }
}
