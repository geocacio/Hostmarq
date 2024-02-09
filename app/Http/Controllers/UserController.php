<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $authUser = User::find(auth()->user()->id);
        
        if ($authUser->hasRole('Master') || $authUser->hasRole('Admin')) {
            // Se o usuário for Master ou Admin, retorna todos os usuários exceto o dele
            $users = User::with('roles', 'roles.permissions', 'club')
                ->where('id', '!=', $authUser->id)
                ->get();
        } else if ($authUser->hasRole('ClubMaster') || $authUser->hasRole('ClubAdmin')) {
            // Se o usuário for ClubMaster ou ClubAdmin, retorna todos os usuários que pertencem ao mesmo clube
            $users = $authUser->club->users()->with('roles', 'roles.permissions')->get();
        } else {
            // Se o usuário não tiver nenhuma das roles acima, retorna apenas o próprio usuário
            $users = [$authUser->load('roles', 'roles.permissions', 'club')];
        }

        return response()->json($users);
    }

    public function giveRole(Request $request, User $user)
    {
        //validação
        $validatedData = $request->validate([
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        $role = Role::find($validatedData['role_id']);
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $user->roles()->attach($validatedData['role_id']);

        return response()->json(['message' => 'Role given successfully']);
    }
}
