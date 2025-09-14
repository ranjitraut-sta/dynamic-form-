<?php

use Illuminate\Support\Facades\Route;
use App\Modules\DashboardManagement\Controllers\DashboardManagementController;


Route::middleware(['web', 'auth','check.permission'])->group(function () {
    //---------------------------DASHBOARD MANAGEMENT ROUTE-----------------------------
    Route::prefix('admin/dashboard')->group(function () {
        Route::get('/', [DashboardManagementController::class, 'AdminLayout'])->name('adminLayout');
    });
});


