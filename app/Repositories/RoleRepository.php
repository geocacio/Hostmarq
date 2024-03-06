<?php

namespace App\Repositories;

use App\Models\Role;
use App\Interfaces\Repositories\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class RoleRepository implements RoleRepositoryInterface
{
    public function addPermissionToUser(Model $role, int $permission)
    {
        // xdebug_break();
        return true;
    }
}