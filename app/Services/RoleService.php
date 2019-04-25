<?php
namespace App\Services;

use App\User;
use App\Models\Trust\Role;

class RoleService
{
    public static function add(User $user, $roleName)
    {
        if (!$roleName) {
            throwError('Please insert role name', 422);
        }
        if (!empty($roleName) && !in_array($roleName, Role::roles())) {
            throwError('Some thing went wrong!', 500);
        }
        // find or create role admin
        $role = Role::firstOrCreate(['name' => $roleName]);

        return $user->roles()->attach($role);
    }

    public static function sync(User $user, $roleName)
    {
        if (!$roleName) {
            throwError('Please insert role name', 422);
        }
        if (!empty($roleName) && !in_array($roleName, Role::roles())) {
            throwError('Some thing went wrong!', 500);
        }
        // find or create role admin
        $role = Role::firstOrCreate(['name' => $roleName]);

        return $user->roles()->sync($role);
    }
}
