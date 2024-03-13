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
    public function index(Request $request, Club $club)
    {
        $query = WeaponModel::query()->where('club_id', $club->id);
        $search = $request->search;

        if($request->has('search')){
            $query->where('name', 'like', '%'.$search.'%');
        }

        $models = $query->paginate(12);
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
                'success' => 'Modelo criado com sucesso!',
                'model' => $model,
            ], 201);
        }
        
        return response()->json([
            'success' => 'Erro ao criar modelo de arma!',
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
                'success' => 'Modelo atualizado com sucesso!',
                'model' => $weaponModel,
            ]);
        }

        return response()->json([
            'success' => 'Erro ao atualizar modelo de arma!',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club, WeaponModel $weaponModel)
    {
        if ($weaponModel->delete()) {
            return response()->json([
                'success' => 'Modelo deletado com sucesso!',
            ]);
        }

        return response()->json([
            'success' => 'Erro ao deletar modelo de arma!',
        ], 500);
    }
}
