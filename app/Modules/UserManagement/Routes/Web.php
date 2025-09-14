<?php

use App\Modules\UserManagement\Controllers\PermissionController;
use App\Modules\UserManagement\Controllers\RoleController;
use App\Modules\UserManagement\Controllers\RoleHasPermissionController;
use App\Modules\UserManagement\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'check.permission'])->prefix('admin')->group(function () {

    Route::prefix('role')->as('role.')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'delete')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk.delete');
        Route::get('/update-order', 'updateOrder')->name('order');
        Route::get('role-has-permission/{id}', 'addPermission')->name('permission');
    });

    //---------------------------PERMISSION SECTION ROUTE-----------------------------
    Route::prefix('permission')->as('permission.')->controller(PermissionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'delete')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk.delete');
    });

    //---------------------------USER  SECTION ROUTE-----------------------------
    Route::prefix('user')->as('user.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'delete')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk.delete');
        Route::get('/update-order', 'updateOrder')->name('order');

        // profile routes
        Route::get('profile', 'userProfile')->name('profile');
        Route::put('profile/update/{id}', 'updateProfile')->name('profile.update');
    });

});
//---------------------------ROLE HAS PERMISSION SECTION ROUTE-----------------------------
Route::prefix('admin/role-has-permission')->group(function () {
    Route::post('store', [RoleHasPermissionController::class, 'store'])->name('role.permission.store');
});
