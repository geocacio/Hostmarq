<?php

namespace App\Services;
use App\Interfaces\Repositories\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    private $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function togglePermission($role, $payload)
    {
        $user = auth()->user();
        
        //Verificar se o usuário logado tem permissão para adicionar permissões
        if($user->hasPermission('toggle-Permission')){
            //return custom exception
        }

        if($role->name == "Admin"){
            //Adicionar para a role Admin
            $data = DB::transaction(function () use ($role, $payload){
                return $this->roleRepository->togglePermission($role, $payload['permission_id']);
            });

        }else{
            $permission = $payload['permission_id'];
            //Verificar se foi selecionado a ação de adicionar ou remover a permissão (attach/detach)
            $action = $payload['action'];
            //Verificar se foi selecionado um ou mais clubes que vão receber a permissão
            $clubIds = $payload['clubs'] ?? null;
            //adicionar ou remover a permissão para os clubes selecionados, ou para todos os clubes
            // return $this->roleRepository->addPermissionOnClub($role, $permission, $action, $clubIds);
            $data = DB::transaction(function () use ($role, $permission, $action, $clubIds){
                return $this->roleRepository->addPermissionOnClub($role, $permission, $action, $clubIds);
            });
        }

        if(!$data){
            //return custom exception
        }

        //return custom response
        
    }
}