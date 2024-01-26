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
        $users = User::with('roles', 'roles.permissions')->get();
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
