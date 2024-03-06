<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface
{
    public function addPermissionOnClub(Model $role, int $permission, string $action, array $clubIds = null);
    public function togglePermission(Model $role, int $permission);
}