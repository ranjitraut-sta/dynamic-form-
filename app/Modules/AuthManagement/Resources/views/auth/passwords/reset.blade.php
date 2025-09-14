@extends('layouts.app')
@section('content')
    <div id="resetPasswordForm" class="form-panel">
        <h2 class="form-title mb-4">Reset your password</h2>
        <p class="text-muted mb-4">Please enter your new password below.</p>

        <form method="POST" action="{{ route('password.update') }}" novalidate>
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3 email-input-container">
                <input type="email" class="form-control custom-input" id="email" placeholder="Email Address"
                    value="{{ $email ?? old('email') }}" name="email">
            </div>

            <div class="mb-3 password-input-container">
                <input type="password" name="password" class="form-control custom-input" id="newPassword"
                    placeholder="New password">
                <span class="password-toggle" data-target="newPassword"><i class="fas fa-eye"></i></span>
                <span class="text-danger">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="mb-4 password-input-container">
                <input type="password" name="password_confirmation" class="form-control custom-input" id="confirmPassword"
                    placeholder="Confirm new password">
                <span class="password-toggle" data-target="confirmPassword"><i class="fas fa-eye"></i></span>
                <span class="text-danger">
                    @error('password_confirmation')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="d-grid gap-2 mb-4">
                <button type="submit" class="btn btn-primary custom-btn">Reset password</button>
            </div>
            <div class="text-center">
                <a href="{{ route('login') }}" class="form-switch-link terms-link" data-direction="right">Back to
                    Login</a>
            </div>
        </form>
    </div>
@endsection
