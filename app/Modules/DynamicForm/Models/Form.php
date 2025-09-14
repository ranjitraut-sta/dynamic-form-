<?php

namespace App\Modules\DynamicForm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    protected $fillable = [
        'title',
        'description',
        'fields',
        'settings',
        'is_active'
    ];

    protected $casts = [
        'fields' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean'
    ];

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }
}
