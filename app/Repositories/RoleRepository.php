<?php

namespace App\Repositories;

use App\Interfaces\Repositories\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class RoleRepository implements RoleRepositoryInterface
{
    public function togglePermission(Model $role, int $permission)
    {
        // Implement the logic for toggling the permission here
        return $role->permissions()->toggle($permission);
    }

    public function addPermissionOnClub(Model $role, int $permission, string $action, array $clubIds = null)
    {
        // xdebug_break();
        return true;
    }
}