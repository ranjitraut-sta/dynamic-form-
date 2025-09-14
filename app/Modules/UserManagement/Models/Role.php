<?php

namespace App\Modules\UserManagement\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = [
        'name',
        'display_order'
    ];

    // Define the many-to-many relationship with Permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permission', 'role_id', 'permission_id');
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
