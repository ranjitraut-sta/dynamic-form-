<?php

namespace App\Modules\DynamicForm\Models;

use Illuminate\Database\Eloquent\Model;

class FormTemplate extends Model
{
    protected $fillable = [
        'name',
        'description', 
        'category',
        'fields',
        'preview_image',
        'is_active'
    ];

    protected $casts = [
        'fields' => 'array',
        'is_active' => 'boolean'
    ];
}