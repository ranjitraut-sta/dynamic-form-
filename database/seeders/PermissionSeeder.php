<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permission::truncate();

        $permissions = [
            // Dashboard
            [
                'name' => 'View Admin Dashboard',
                'action' => 'AdminLayout',
                'controller' => 'DashboardController',
                'group_name' => 'dashboard',
            ],

            // Role
            [
                'name' => 'View Roles',
                'action' => 'index',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Create Role',
                'action' => 'create',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Store Role',
                'action' => 'store',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Edit Role',
                'action' => 'edit',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Update Role',
                'action' => 'update',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Delete Role',
                'action' => 'delete',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Show Role Details',
                'action' => 'show',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],
            [
                'name' => 'Assign Permission to Role',
                'action' => 'addPermission',
                'controller' => 'RoleController',
                'group_name' => 'role',
            ],

            // Permission
            [
                'name' => 'View Permissions',
                'action' => 'index',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Create Permission',
                'action' => 'create',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Store Permission',
                'action' => 'store',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Edit Permission',
                'action' => 'edit',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Update Permission',
                'action' => 'update',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Delete Permission',
                'action' => 'delete',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],
            [
                'name' => 'Show Permission Details',
                'action' => 'show',
                'controller' => 'PermissionController',
                'group_name' => 'permission',
            ],

            // RoleHasPermission
            [
                'name' => 'Assign Permissions to Roles',
                'action' => 'store',
                'controller' => 'RoleHasPermissionController',
                'group_name' => 'role_permission',
            ],

            // User
            [
                'name' => 'View Users',
                'action' => 'index',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Create User',
                'action' => 'create',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Store User',
                'action' => 'store',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Edit User',
                'action' => 'edit',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Update User',
                'action' => 'update',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Delete User',
                'action' => 'delete',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Show User Details',
                'action' => 'show',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],
            [
                'name' => 'Search Users',
                'action' => 'getUserSearchByNameOrStatus',
                'controller' => 'UserController',
                'group_name' => 'user',
            ],

            // User Detail
            [
                'name' => 'View User Details',
                'action' => 'index',
                'controller' => 'UserDetailController',
                'group_name' => 'user_detail',
            ],
            [
                'name' => 'Edit User Details',
                'action' => 'edit',
                'controller' => 'UserDetailController',
                'group_name' => 'user_detail',
            ],
            [
                'name' => 'Update User Details',
                'action' => 'update',
                'controller' => 'UserDetailController',
                'group_name' => 'user_detail',
            ],

            // Setting
            [
                'name' => 'View Settings',
                'action' => 'index',
                'controller' => 'SettingController',
                'group_name' => 'setting',
            ],
            [
                'name' => 'Update Settings',
                'action' => 'update',
                'controller' => 'SettingController',
                'group_name' => 'setting',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
