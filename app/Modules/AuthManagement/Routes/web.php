<?php

use Illuminate\Support\Facades\Route;
use App\Modules\AuthManagement\Controllers\Auth\LoginController;
use App\Modules\AuthManagement\Controllers\Auth\RegisterController;
use App\Modules\AuthManagement\Controllers\Auth\ForgotPasswordController;
use App\Modules\AuthManagement\Controllers\Auth\ResetPasswordController;
use App\Modules\AuthManagement\Controllers\Auth\ConfirmPasswordController;
use App\Modules\AuthManagement\Controllers\Auth\VerificationController;

Route::middleware(['web'])->prefix('auth')->group(function () {

    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Registration Routes
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Password Reset Routes
    Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    // Email Verification Routes
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    // Confirm Password
    Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

    // Social Authentication Routes
    Route::get('google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::get('facebook', [LoginController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('facebook/callback', [LoginController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');
});
