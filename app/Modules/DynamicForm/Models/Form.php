<?php

namespace App\Modules\DynamicForm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'fields',
        'settings',
        'is_active',
        'unique_url',
        'conditional_logic',
        'form_settings'
    ];

    protected $casts = [
        'fields' => 'array',
        'settings' => 'array',
        'conditional_logic' => 'array',
        'form_settings' => 'array',
        'is_active' => 'boolean'
    ];

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($form) {
            if (empty($form->unique_url)) {
                $form->unique_url = static::generateUniqueUrl();
            }
        });
    }

    private static function generateUniqueUrl()
    {
        do {
            $url = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);
        } while (static::where('unique_url', $url)->exists());

        return $url;
    }
}
