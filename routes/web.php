<?php
use App\Core\Helpers\ModuleMigrateHelper;

use App\Core\Http\ControllerInspectorController;
use Illuminate\Support\Facades\Route;


Route::get('/{controller}/get', [ControllerInspectorController::class, 'getControllerMethods']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect()->route('home');
});


Route::get('/{module}/migrate', function ($module) {
    return ModuleMigrateHelper::migrate($module);
});
