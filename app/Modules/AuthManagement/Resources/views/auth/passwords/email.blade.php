@extends('layouts.app')
@section('content')
    @include('alert.top-end')

    <!-- Forgot Password Form -->
    <div id="forgotPasswordForm" class="form-panel">
        <h2 class="form-title mb-4">Forgot your password?</h2>
        <p class="text-white mb-4">Enter your email address below and we'll send you a link to reset your password.</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <input type="email" class="form-control custom-input" id="forgotEmail" placeholder="Email address"
                    value="{{ old('email') }}" name="email" required autocomplete="email" autofocus>
                <span class="text-danger">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="d-grid gap-2 mb-4">
                <button type="submit" class="btn btn-primary custom-btn">Send reset link</button>
            </div>
            <div class="text-center">
                <a href="{{ route('login') }}" class="form-switch-link terms-link" data-direction="right">Back to Login</a>
            </div>
        </form>
    </div>
@endsection
