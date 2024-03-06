<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface
{
    public function addPermissionToUser(Model $role, int $permission);
}