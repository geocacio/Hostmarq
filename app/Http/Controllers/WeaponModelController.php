<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\WeaponModel;
use Illuminate\Http\Request;

class WeaponModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Club $club)
    {
        $models = $club->weaponModels;
        return response()->json($models);
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

        $model = $club->weaponModels()->create($validatedData);
        if ($model) {
            return response()->json([
                'status' => 'success',
                'message' => 'Modelo criado com sucesso!',
                'model' => $model,
            ], 201);
        }
        
        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao criar modelo de arma!',
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(WeaponModel $weaponModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WeaponModel $weaponModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club, WeaponModel $weaponModel)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        if ($weaponModel->update($validatedData)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Modelo atualizado com sucesso!',
                'model' => $weaponModel,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao atualizar modelo de arma!',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club, WeaponModel $weaponModel)
    {
        if ($weaponModel->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Modelo deletado com sucesso!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao deletar modelo de arma!',
        ], 500);
    }
}
