<?php

use App\Modules\DynamicForm\Controllers\DynamicFormController;
use App\Modules\DynamicForm\Controllers\FieldController;
use App\Modules\DynamicForm\Controllers\FieldTypeController;
use App\Modules\DynamicForm\Controllers\TemplateController;
use App\Modules\DynamicForm\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    Route::resource('forms', DynamicFormController::class);
    Route::resource('field-types', FieldTypeController::class);
    Route::get('forms-simple/create', [DynamicFormController::class, 'simpleCreate'])->name('forms.simple-create');
    Route::get('field-types-api', [FieldController::class, 'getFieldTypes'])->name('field-types-api');
    Route::get('field-palette', [FieldController::class, 'getFieldPalette'])->name('field-palette');
    Route::post('field-html/{type}', [FieldController::class, 'getFieldHtml'])->name('field-html');
    Route::delete('forms/{form}/submissions/{submission}', [DynamicFormController::class, 'deleteSubmission'])->name('submissions.delete');
    Route::get('forms/{form}/submissions', [DynamicFormController::class, 'submissions'])->name('forms.submissions');

    // Templates
    Route::get('form-templates', [TemplateController::class, 'index']);
    Route::get('form-templates/{id}', [TemplateController::class, 'show']);
    Route::post('form-templates', [TemplateController::class, 'store']);
    Route::get('prebuilt-templates', [TemplateController::class, 'getPrebuiltTemplates']);
});

// API Routes for templates
Route::prefix('api')->group(function () {
    Route::get('templates/prebuilt', [TemplateController::class, 'getPrebuiltTemplates']);
    Route::get('templates/{id}', [TemplateController::class, 'show']);

    // Analytics
    Route::get('forms/{form}/analytics', [AnalyticsController::class, 'getFormAnalytics']);

    // Enhanced form operations
    Route::post('forms/{form}/save', [DynamicFormController::class, 'saveEnhanced']);
    Route::get('forms/{form}/enhanced-builder', [DynamicFormController::class, 'enhancedBuilder']);
    Route::get('template-wizard', [DynamicFormController::class, 'templateWizard'])->name('forms.template-wizard');
});

// Public form routes
Route::get('form/{form}', [DynamicFormController::class, 'publicForm'])->name('form.public');
Route::get('f/{uniqueUrl}', [DynamicFormController::class, 'publicFormByUrl'])->name('form.public.url');
Route::post('form/{formId}/submit', [DynamicFormController::class, 'submit'])
    ->name('forms.submit');
Route::post('f/{uniqueUrl}/submit', [DynamicFormController::class, 'submitByUrl'])
    ->name('forms.submit.url');
Route::delete('submissions/single/{submission}', [DynamicFormController::class, 'deleteSingleSubmission'])
    ->name('single.submissions.delete');


