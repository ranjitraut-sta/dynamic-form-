@extends('layouts.app')

@section('content')
    <div id="registerForm" class="form-panel">
        <h2 class="form-title mb-4">Create your account</h2>
        <p class="text-white mb-4 already-account">Already have an account? <a href="{{ route('login') }}"
                class="form-switch-link" data-direction="left">Login</a></p>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <input type="text" name="name" class="form-control custom-input" id="registerName"
                    placeholder="Full Name" value="{{ old('name') }}" autocomplete="name" autofocus>
                <span class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control custom-input" id="registerEmail"
                    placeholder="Email Address" value="{{ old('email') }}" autocomplete="email">
                <span class="text-danger">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="mb-3 password-input-container">
                <input type="password" name="password" class="form-control custom-input" id="registerPassword"
                    placeholder="Enter your password">
                <span class="password-toggle" data-target="registerPassword"><i class="fas fa-eye"></i></span>
                <span class="text-danger">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="mb-3 password-input-container">
                <input type="password" name="password_confirmation" class="form-control custom-input" id="confirmPassword"
                    placeholder="Confirm Password">
                <span class="password-toggle" data-target="confirmPassword"><i class="fas fa-eye"></i></span>
            </div>

            <div class="d-grid gap-2 mb-4">
                <button type="submit" class="btn btn-primary custom-btn">Create Account</button>
            </div>

        </form>

        <!-- Social Login Section -->
        <div class="text-center mb-3">
            <div class="d-flex align-items-center mb-3">
                <hr class="flex-grow-1" style="border-color: rgba(255,255,255,0.3);">
                <span class="px-3 text-white-50">or continue with</span>
                <hr class="flex-grow-1" style="border-color: rgba(255,255,255,0.3);">
            </div>
            
            <div class="d-flex gap-2 justify-content-center">
                <a href="{{ route('auth.google') }}" class="btn btn-outline-light flex-fill">
                    <i class="fab fa-google me-2"></i>Google
                </a>
                <a href="{{ route('auth.facebook') }}" class="btn btn-outline-light flex-fill">
                    <i class="fab fa-facebook-f me-2"></i>Facebook
                </a>
            </div>
        </div>

    </div>
@endsection
