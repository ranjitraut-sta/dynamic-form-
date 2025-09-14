@extends('layouts.app')
@section('content')
    <div id="loginForm" class="form-panel">
        <h2 class="form-title mb-4">Log in to your account</h2>
        <p class="text-white mb-4 already-account">Don't have an account? <a href="{{ route('register') }}" class="form-switch-link"
                data-direction="right">Sign up</a></p>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <input type="text" name="name" class="form-control custom-input" id="loginEmail"
                    placeholder="User Name Or Email" value="{{ old('name') }}" autocomplete="name" autofocus>
                <span class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="mb-3 password-input-container">
                <input type="password" name="password" class="form-control custom-input" id="loginPassword"
                    placeholder="Enter your password">
                <span class="password-toggle" data-target="loginPassword"><i class="fas fa-eye"></i></span>
                <span class="text-danger">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="d-flex justify-content-end mb-4">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="terms-link form-switch-link"
                        data-direction="left">Forgot
                        password?</a>
                @endif
            </div>

            <div class="d-grid gap-2 mb-4">
                <button type="submit" class="btn btn-primary custom-btn">Log in</button>
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
