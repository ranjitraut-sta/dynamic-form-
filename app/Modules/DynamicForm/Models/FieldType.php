<?php

namespace App\Modules\DynamicForm\Models;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    protected $fillable = [
        'name',
        'label', 
        'icon',
        'html_template',
        'validation_rules',
        'has_options',
        'is_active'
    ];

    protected $casts = [
        'validation_rules' => 'array',
        'has_options' => 'boolean',
        'is_active' => 'boolean'
    ];
}