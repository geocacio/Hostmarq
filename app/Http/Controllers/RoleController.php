<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->where('name', '!=', 'Master')->get();
        return response()->json($roles);
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
        //validação
        $validatedData = $request->validate([
            'permission_id' => 'required|integer|exists:permissions,id',
        ]);

        $permission = Permission::find($validatedData['permission_id']);
        if (!$permission) {
            return response()->json(['error' => 'Permission not found'], 404);
        }

        $role->permissions()->attach($validatedData['permission_id']);

        return response()->json(['message' => 'Permission added successfully']);
    }
}
