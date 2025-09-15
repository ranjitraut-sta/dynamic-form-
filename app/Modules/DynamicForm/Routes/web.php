<?php

use App\Modules\DynamicForm\Controllers\DynamicFormController;
use App\Modules\DynamicForm\Controllers\FieldController;
use App\Modules\DynamicForm\Controllers\FieldTypeController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    Route::resource('forms', DynamicFormController::class);
    Route::resource('field-types', FieldTypeController::class);
    Route::get('forms-simple/create', [DynamicFormController::class, 'simpleCreate'])->name('forms.simple-create');
    Route::get('field-types-api', [FieldController::class, 'getFieldTypes'])->name('field-types-api');
    Route::get('field-palette', [FieldController::class, 'getFieldPalette'])->name('field-palette');
    Route::post('field-html/{type}', [FieldController::class, 'getFieldHtml'])->name('field-html');
});

// Public form routes
Route::get('form/{form}', [DynamicFormController::class, 'publicForm'])->name('form.public');
Route::get('f/{uniqueUrl}', [DynamicFormController::class, 'publicFormByUrl'])->name('form.public.url');
Route::post('form/{formId}/submit', [DynamicFormController::class, 'submit'])
    ->name('forms.submit');
Route::post('f/{uniqueUrl}/submit', [DynamicFormController::class, 'submitByUrl'])
    ->name('forms.submit.url');
Route::delete('submissions/{submission}', [DynamicFormController::class, 'deleteSubmission'])
    ->name('submissions.delete');


