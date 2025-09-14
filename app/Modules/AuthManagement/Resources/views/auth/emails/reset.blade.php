<p>Click the link below to reset your password:</p>
<a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}">
    Reset Password
</a>

<p>If you did not request a password reset, please ignore this email.</p>
