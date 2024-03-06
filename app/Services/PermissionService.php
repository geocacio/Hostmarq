<?php

namespace App\Services;
use App\Interfaces\Repositories\RoleRepositoryInterface;

class PermissionService
{
    private $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function togglePermission($role, $permission)
    {
        // xdebug_break();
        //Se o role for Admin, adicionar em user_roles
        if ($role == 'Admin') {
            $this->roleRepository->addPermissionToUser($role, $permission);
        }
    }
}