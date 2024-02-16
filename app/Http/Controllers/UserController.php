<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();
        $search = $request->search;
        
        if ($authUser->hasRole('Master') || $authUser->hasRole('Admin')) {
            // Se o usuário for Master ou Admin, retorna todos os usuários exceto o dele
            $query = User::with('roles', 'roles.permissions', 'club')
                ->where('id', '!=', $authUser->id);

        } else if ($authUser->hasRole('ClubMaster') || $authUser->hasRole('ClubAdmin')) {
            // Se o usuário for ClubMaster ou ClubAdmin, retorna todos os usuários que pertencem ao mesmo clube
            $users = $authUser->club->users()->with('roles', 'roles.permissions');
        } else {
            // retornar acesso não autorizado
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }

        $users = $query->paginate(12);
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

    public function update(Request $request, User $user)
    {
        // xdebug_break();
        $authUser = auth()->user();

        if ($authUser->hasRole('Master') || $authUser->hasRole('Admin')) {
            // Se o usuário for Master ou Admin, permite a atualização de qualquer usuário
            $user->update($request->all());
        } else if ($authUser->hasRole('ClubMaster') || $authUser->hasRole('ClubAdmin')) {
            // Se o usuário for ClubMaster ou ClubAdmin, permite a atualização de qualquer usuário que pertença ao mesmo clube
            if ($user->club_id == $authUser->club_id) {
                $user->update($request->all());
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } else {
            // retornar acesso não autorizado
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success' => 'User updated successfully',
            'user' => $user->toArray(),
        ]);
    }
}
