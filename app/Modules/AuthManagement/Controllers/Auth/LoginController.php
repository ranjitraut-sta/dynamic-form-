<?php

namespace App\Modules\AuthManagement\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\AuthManagement\Requests\checkCredentail;
use App\Modules\AuthManagement\Services\Interfaces\LoginServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    protected $loginService;
    public function __construct(LoginServiceInterface $loginService)
    {
        $this->middleware('guest')->except('logout');
        $this->loginService = $loginService;
    }

    protected function authenticated(Request $request, $user)
    {
        $role = DB::table('roles')->where('id', $user->role_id)->first();
        if ($user->role_id == $role->id) {
            return redirect()->route('adminLayout')->with('success', 'Welcome To Admin Login');
        } else {
            return redirect('/')->with('status', 'Login Successful');
        }
    }

    public function showLoginForm()
    {
        $data['header_title'] = 'Login';
        return view('AuthManagement::auth.login', ['data' => $data]);
    }

    public function login(checkCredentail $request)
    {
        try {
            $type = false;// false  is for web user
            $result = $this->loginService->checkLoginCredential($request, $type);

            if ($result['status'] === 'success') {
                return redirect()->route('adminLayout')->with($result['message']);
            } else {
                return redirect()->back()
                    ->withInput() // this keeps old input like name and remember
                    ->withErrors(['name' => $result['message']]);
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')
            ->with('status', 'You have been logged out successfully.');
    }

    // Social Authentication Methods
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = $this->findOrCreateUser($googleUser, 'google');
            Auth::login($user);
            return redirect()->route('adminLayout')->with('success', 'Welcome! You have successfully logged in with Google.');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed. Please try again.');
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $user = $this->findOrCreateUser($facebookUser, 'facebook');
            Auth::login($user);
            return redirect()->route('adminLayout')->with('success', 'Welcome! You have successfully logged in with Facebook.');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Facebook login failed. Please try again.');
        }
    }

    private function findOrCreateUser($socialUser, $provider)
    {
        // Check if user exists with this provider
        $user = User::where('provider', $provider)
                   ->where('provider_id', $socialUser->getId())
                   ->first();

        if ($user) {
            return $user;
        }

        // Check if user exists with same email
        $existingUser = User::where('email', $socialUser->getEmail())->first();

        if ($existingUser) {
            // Link social account to existing user
            $existingUser->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
            return $existingUser;
        }

        // Create new user
        return User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'avatar' => $socialUser->getAvatar(),
            'role_id' => 3, // Default role
            'password' => Hash::make(Str::random(16)), // Random password
        ]);
    }

}
