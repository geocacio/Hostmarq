<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\WeaponType;
use Illuminate\Http\Request;

class WeaponTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Club $club)
    {
        $types = $club->weaponTypes;
        return response()->json($types);
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
    public function store(Request $request, Club $club)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        
        $type = $club->weaponTypes()->create($validatedData);
        if ($type) {
            return response()->json([
                'success' => 'Tipo criado com sucesso!',
                'type' => $type,
            ], 201);
        }
        
        return response()->json([
            'success' => 'Erro ao criar tipo de arma!',
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Club $club, WeaponType $weaponType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WeaponType $weaponType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club, WeaponType $weaponType)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        if ($weaponType->update($validatedData)) {
            return response()->json([
                'success' => 'Tipo atualizado com sucesso!',
                'type' => $weaponType,
            ]);
        }

        return response()->json([
            'success' => 'Erro ao atualizar tipo de arma!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club, WeaponType $weaponType)
    {
        if ($weaponType->delete()) {
            return response()->json([
                'success' => 'Tipo removido com sucesso!',
            ]);
        }

        return response()->json([
            'success' => 'Erro ao remover tipo de arma!',
        ]);
    }
}
