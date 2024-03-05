<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $excludeRules = [
        'Master' => ['Master'],
        'Admin' => ['Master', 'Admin'],
        'ClubMaster' => ['Master', 'Admin', 'ClubMaster'],
        'ClubAdmin' => ['Master', 'Admin', 'ClubMaster', 'ClubAdmin'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //pegar as permissões do usuário logado
        $roles = auth()->user()->roles()->first();
        $permissions = $roles->load('permissions');
        //pegar todas as roles
        $roles = Role::whereNotIn('name', $this->excludeRules[$roles->name])->get();

        $data = [
            'roles' => $roles,
            'permissions' => $permissions->permissions,
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }

    public function addPermission(Request $request, Role $role)
    {
        $user = auth()->user();
        $club = $user->club;
        $clubIds = [];

        $validatedData = $request->validate([
            'permission_id' => 'required|integer|exists:permissions,id',
            'action' => 'required|string|in:attach,detach',
        ]);

        //Verificar o tipo de usuário é Master ou Admin e pega os ids dos clubes
        if($user->hasRole('Master') || $user->hasRole('Admin')){
            //Verificar se foi selecionado um ou mais clubes que vão receber a permissão
            $clubIds = !empty($request->clubs_id) ? $request->clubs_id : Club::all()->pluck('id')->toArray();
        }

        //Verificar se o usuário é ClubMaster ou ClubAdmin e pega o id do clube
        if ($user->hasRole('ClubMaster') || $user->hasRole('ClubAdmin')) {
            $clubIds = [$club->id];
        }

        $permission = Permission::find($validatedData['permission_id']);
        if (!$permission) {
            return response()->json(['error' => 'Permission not found'], 404);
        }

        //Verificar o $request->action para saber se é para adicionar ou remover a permissão (attach/detach)
        if($validatedData['action'] == 'attach'){
            foreach ($clubIds as $clubId) {
                //Verificar se a permissão já existe
                $hasPermission = $role->permissions()->where('permissions.id', $validatedData['permission_id'])->where('club_id', $clubId)->exists();
                if (!$hasPermission) {
                    $role->permissions()->attach($validatedData['permission_id'], ['club_id' => $clubId, 'user_granted_id' => $user->id]);
                }
            }
        }else{
            foreach ($clubIds as $clubId) {
                $role->permissions()->detach($validatedData['permission_id'], ['club_id' => $clubId]);
            }
        }

        $mesage = $validatedData['action'] == 'attach' ? 'Permissão adicionada com sucesso!' : 'Permissão removida com sucesso!';
        return response()->json(['success' => $mesage, 'data' => $role->permissions]);
    }
}
