<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Interfaces\Repositories\RoleRepositoryInterface;
use App\Utils\DefaultResponse;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    private $roleRepository;
    private $defaultResponse;

    public function __construct(RoleRepositoryInterface $roleRepository, DefaultResponse $defaultResponse)
    {
        $this->roleRepository = $roleRepository;
        $this->defaultResponse = $defaultResponse;
    }

    public function togglePermission($role, $payload)
    {
        $user = auth()->user();
        
        //Verificar se o usuário logado tem permissão para adicionar permissões
        if(!$user->hasPermission('toggle-Permission')){
            throw new CustomException('Você não tem permissão para adicionar permissões', 403);
        }
        
        if($role->name == "Admin"){
            //Adicionar para a role Admin
            $data = DB::transaction(function () use ($role, $payload){
                return $this->roleRepository->togglePermission($role, $payload['permission_id']);
            });

        }else{
            $permission = $payload['permission_id'];

            //Verificar se foi selecionado um ou mais clubes que vão receber a permissão
            $clubIds = $payload['clubs'] ?? null;

            $action = $payload['action'] ?? null;
            //Verificar se foi selecionado a ação de adicionar ou remover a permissão (attach/detach)
            if(!$action && $clubIds && count($clubIds) > 1){
                throw new CustomException('O campo ação é obrigatório', 400);
            }

            //adicionar ou remover a permissão para os clubes selecionados, ou para todos os clubes
            $data = DB::transaction(function () use ($role, $permission, $action, $clubIds){
                return $this->roleRepository->togglePermission($role, $permission);
                // return $this->roleRepository->addPermissionOnClub($role, $permission, $action, $clubIds);
            });
        }

        if(!$data){
            throw new CustomException('Erro ao adicionar permissão', 500);
        }

        return $this->defaultResponse->successWithContent('Permissão adicionada com sucesso', 200, $data);
        
    }
}